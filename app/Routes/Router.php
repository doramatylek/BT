<?php
declare(strict_types=1);
namespace project\app\Routes;

use project\app\Controllers\AnimalController;
use project\app\Routes\AdminRouter;
use project\utils\RouteCollection;
use project\utils\ErrorMessages;

class Router
{
    private array $controllers = [
        ''         => [AnimalController::class, 'showAnimals'],
        'adoption' => [AnimalController::class, 'handleAdoption'],
    ];

    private AdminRouter $adminRouter;

    public function __construct()
    {
        $this->adminRouter = new AdminRouter();
    }

    public function route(string $requestUri): void
    {
        $basePath = RouteCollection::BASE_PATH;
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $trimmedUri = preg_replace('#^'.preg_quote($basePath, '#').'#', '', $requestUri);
        $trimmedUri = $trimmedUri === '' ? '/' : $trimmedUri;

        $path = explode('/', trim(parse_url($trimmedUri, PHP_URL_PATH), '/'));
        $route = $path[0] ?? '';

        if ($route === 'admin') {
            $adminPath = '/' . implode('/', array_slice($path, 1));
            $this->adminRouter->route($requestMethod, $adminPath);
            return;
        }

        if (isset($this->controllers[$route])) {
            [$controllerClass, $method] = $this->controllers[$route];
            $controllerInstance = new $controllerClass();

            if (method_exists($controllerInstance, $method)) {
                $controllerInstance->$method();
                return;
            }
        }

        http_response_code(404);
        die(ErrorMessages::ROUT_NOT_FOUND . $requestMethod.' '.$requestUri);
    }
}