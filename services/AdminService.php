<?php
declare(strict_types=1);
namespace project\services;

use Exception;
use project\utils\ErrorMessages;
use project\utils\FileManagerConstants;
class AdminService
{
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = realpath($basePath);
        if ($this->basePath === false) {
            throw new Exception(ErrorMessages::BASE_PATH_DOES_NOT_EXIST);
        }
    }

    public function getFullPath(string $relativePath = ''): string
    {
        $relativePath = trim($relativePath, '/\\');
        $fullPath = $this->basePath . '\\' . $relativePath;
        $fullPath = realpath($fullPath) ?: $this->basePath . '\\' . $relativePath;

        if (strpos($fullPath, $this->basePath) !== 0) {
            throw new Exception(ErrorMessages::DIRECTORY_TRAVERSAL);
        }

        return $fullPath;
    }

    public function listItems(string $path = ''): array
    {
        $fullPath = $this->getFullPath($path);
        $items = [];

        if (is_dir($fullPath)) {
            foreach (scandir($fullPath) as $item) {
                if ($item !== '.' && $item !== '..') {
                    $itemPath = $fullPath . '\\' . $item;
                    $items[] = [
                        'name' => $item,
                        'is_dir' => is_dir($itemPath),
                        'size' => is_dir($itemPath) ? '-' : $this->formatSize(filesize($itemPath)),
                        'modified' => date(FileManagerConstants::DATE, filemtime($itemPath)),
                    ];
                }
            }
        }

        return $items;
    }

    public function createDirectory(string $path, string $dirName): bool
    {
        $dirName = preg_replace('/[^a-zA-Z0-9\-_]/', '', $dirName);
        $fullPath = $this->getFullPath($path) . '\\' . $dirName;

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755);
            return true;
        }
        return false;
    }

    public function deleteFile(string $path, string $fileName): bool
    {
        $fullPath = $this->getFullPath($path) . '\\' . $fileName;

        if (file_exists($fullPath) && is_file($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }

    public function deleteDirectory(string $path, string $dirName): bool
    {
        $fullPath = $this->getFullPath($path) . '\\' . $dirName;

        if (file_exists($fullPath) && is_dir($fullPath)) {
            $isEmpty = count(scandir($fullPath)) == 2;
            if ($isEmpty) {
                return rmdir($fullPath);
            }
        }
        return false;
    }

    public function uploadFile(string $path, array $file): bool
    {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = basename($file['name']);
            $targetPath = $this->getFullPath($path) . '\\' . $fileName;

            if (!file_exists($targetPath)) {
                return move_uploaded_file($file['tmp_name'], $targetPath);
            }
        }
        return false;
    }

    public function getBreadcrumbs(string $path = ''): array
    {
        $pathParts = explode('\\', trim($path, '\\'));
        $breadcrumbs = [];
        $accumulatedPath = '';

        foreach ($pathParts as $part) {
            if (!empty($part)) {
                $accumulatedPath .= $part . '\\';
                $breadcrumbs[] = [
                    'name' => $part,
                    'path' => $accumulatedPath,
                ];
            }
        }

        return $breadcrumbs;
    }

    private function formatSize(int $bytes): string
    {
        if ($bytes >= FileManagerConstants::GB) {
            return number_format($bytes / FileManagerConstants::GB, 2) . FileManagerConstants::GB_LABEL;
        }
        if ($bytes >= FileManagerConstants::MB) {
            return number_format($bytes / FileManagerConstants::MB, 2) . FileManagerConstants::MB_LABEL;
        }
        if ($bytes >= FileManagerConstants::KB) {
            return number_format($bytes / FileManagerConstants::KB, 2) . FileManagerConstants::KB_LABEL;
        }
        if ($bytes > 1) {
            return $bytes . FileManagerConstants::BYTES;
        }
        if ($bytes == 1) {
            return FileManagerConstants::BYTE;
        } else {
            return FileManagerConstants::ZERO_BYTES;
        }
    }
}
