<?php

namespace project\app\Controllers;
use project\services\AnimalService;
use project\template\MyTemplate;

class AnimalController
{
    private AnimalService $animalService;

    private MyTemplate $myTemplate;

    public function __construct()
    {
        $this->animalService = new AnimalService();

        $this->myTemplate = new MyTemplate();
    }

    public function showAnimals(): void
    {
        echo $this->myTemplate->view(
            'C:\webdata\project\public\html\home.html',
            $this->animalService->showAnimals()
        );
    }
}
