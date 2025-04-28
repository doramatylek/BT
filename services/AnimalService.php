<?php
declare(strict_types=1);
namespace project\services;
use project\database\EntityManager;
class AnimalService
{


    public function showAnimals(): array {

        // $animal = $this->entityManager->getRepository(Animal::class)->find($id);

        //        if (!$animal) {
        //            // Если животное не найдено, можем вернуть 404
        //            header("HTTP/1.0 404 Not Found");
        //            echo "404 Not Found: Animal not found.";
        //            return;
        //        }

        //        $data = [
        //            'name' => $animal->getName(),
        //            'age' => $animal->getAge(),
        //            'type' => $animal->getType(),
        //            'description' => $animal->getDescription(),
        //            'image' => $animal->getImageUrl(),
        //        ];
        $animals = [
            ['name' => 'Rom', 'age' => '5', 'type' => 'dog', 'description' => '...', 'image' => 'http://localhost/project/public/img/rom.jpg'],
            ['name' => 'Vursik', 'age' => '2', 'type' => 'cat', 'description' => '...', 'image' => 'http://localhost/project/public/img/vurs.jpg'],
            ['name' => 'Pascal', 'age' => '1', 'type' => 'rat', 'description' => '...', 'image' => 'http://localhost/project/public/img/pascal.jpg'],
        ];
        $data = ['animals' => $animals];
        return $data;

    }
}