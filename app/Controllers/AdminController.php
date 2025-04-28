<?php
declare(strict_types=1);
namespace project\app\Controllers;

use project\services\AdminService;
use project\template\TemplateEngine;
use project\utils\RouteCollection;
class AdminController
{
    private AdminService $adminService;
    private TemplateEngine $template;

    public function __construct()
    {
        $this->adminService = new AdminService(RouteCollection::PUBLIC_PATH);
        $this->template = new TemplateEngine();
    }

    public function index(): void
    {
        $currentDir = $_GET['path'] ?? '';
        $items = $this->adminService->listItems($currentDir);
        $breadcrumbs = $this->adminService->getBreadcrumbs($currentDir);

        echo $this->template->view(RouteCollection::FILE_MANAGER_TEMPLATE, [
            'items' => $items,
            'currentDir' => $currentDir,
            'breadcrumbs' => $breadcrumbs,
            'basePath' => RouteCollection::BASE_PATH
        ]);
    }

    public function uploadFile(): void
    {
        $currentDir = $_POST['currentDir'] ?? '';

        if (isset($_FILES['file'])) {
            $this->adminService->uploadFile($currentDir, $_FILES['file']);
        }

        header(RouteCollection:: ADMIN_HEADER.urlencode($currentDir));
        exit;
    }

    public function deleteFile(): void
    {
        $currentDir = $_GET['currentDir'] ?? '';
        $fileName = $_GET['fileName'] ?? '';

        $this->adminService->deleteFile($currentDir, $fileName);
        header(RouteCollection:: ADMIN_HEADER.urlencode($currentDir));
        exit;
    }

    public function createDirectory(): void
    {
        $currentDir = $_POST['currentDir'] ?? '';
        $dirName = $_POST['dirName'] ?? '';

        $this->adminService->createDirectory($currentDir, $dirName);
        header(RouteCollection:: ADMIN_HEADER.urlencode($currentDir));
        exit;
    }

    public function deleteDirectory(): void
    {
        $currentDir = $_GET['currentDir'] ?? '';
        $dirName = $_GET['dirName'] ?? '';

        $this->adminService->deleteDirectory($currentDir, $dirName);
        header(RouteCollection:: ADMIN_HEADER.urlencode($currentDir));
        exit;
    }
}