<?php
declare(strict_types=1);
namespace project\utils;

class ErrorMessages
{
    public const ROUT_NOT_FOUND = 'Route not found: ';
    public const BASE_PATH_DOES_NOT_EXIST = 'Base path does not exist';
    public const DIRECTORY_TRAVERSAL = 'Access denied: trying to access outside base directory';
}