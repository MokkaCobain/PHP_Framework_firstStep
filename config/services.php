<?php

use Twig\Environment;
use App\Zion\Routing\Router;
use Twig\Loader\FilesystemLoader;
use App\Controller\WelcomeController;
use App\Controller\Error\ErrorController;
use Symfony\Component\HttpFoundation\Request;

    return [


        Request::class => Request::createFromGlobals(),

        // Instance d'une class Router type new Router (source https://php-di.org/doc/best-practices.html)
        Router::class  =>  DI\create()->constructor(),

        /// Les class des controllers
        'controllers' => 
        [
            "WelcomeController" => WelcomeController::class,
            "ErrorController"   => ErrorController::class,
        ],

        // Moteur de vue Twig
        Environment::class => function()
        {
            $loader = new FilesystemLoader(__DIR__ . "/../templates");
            return new Environment($loader);
        }

    ];