<?php
declare(strict_types=1);
namespace project\app\Controllers;
use project\services\AnimalService;
use project\template\TemplateEngine;
use project\utils\RouteCollection;
class AnimalController
{
    private AnimalService $animalService;

    private TemplateEngine $myTemplate;

    public function __construct()
    {
        $this->animalService = new AnimalService();

        $this->myTemplate = new TemplateEngine();
    }

    public function showAnimals(): void
    {
        echo $this->myTemplate->view(
            RouteCollection::ANIMAL_PAGE_TEMPLATE,
            $this->animalService->showAnimals()
        );
    }
}
