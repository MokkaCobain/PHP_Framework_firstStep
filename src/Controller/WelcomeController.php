<?php
declare(strict_types=1);

namespace App\Controller;

use App\Zion\Attribute\Route;
use App\Zion\Abstract\AbstractController;
use Symfony\Component\HttpFoundation\Response;

    class WelcomeController extends AbstractController
    {
        #[Route('/', name: 'index', methods: ['GET'])]
        public function index() : Response
        {
            $name="Momo";
            $days= ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
            return $this->render("index.html.twig", 
            [
                "name" => $name,
                "days" => $days,
            ]); 
        }


        #[Route('/test/{id}', name: 'test', methods: ['GET'])]
        public function test($data)
        {
            $question="Que pasa?";
            return $this->render("test.html.twig", ["question" => $question]); 
        }
    }