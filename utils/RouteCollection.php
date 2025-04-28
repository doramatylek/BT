<?php
declare(strict_types=1);
namespace project\utils;

class RouteCollection
{
    public const BASE_PATH = '/project';
    public const ADMIN_HEADER = 'Location: /project/admin?path=';
    public const FILE_MANAGER_TEMPLATE = __DIR__ . '/../admin/html/file_manager.html';
    public const ANIMAL_PAGE_TEMPLATE = __DIR__ . '/../public/html/home.html';
    public const PUBLIC_PATH = __DIR__ . '/../public';

}