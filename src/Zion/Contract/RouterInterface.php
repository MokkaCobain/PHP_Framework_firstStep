<?php 

namespace App\Zion\Contract;

    interface RouterInterface 
    {

        /**
         *  collectControllers($controllers) = fonciton pour récupérer la liste de tous les controllers. La liste est fournie par le Kernel
         * 
         * Elle transmet la liste à la methode "addRoutes"
         *
         * @param array $controllers
         * @return void
         */
        public function collectControllers(array $controllers) : void;

        /**
         * addRoutes($controllers) = fonction qui stock les routes dans uen armoire à routes = $routes
         *
         * @param array $controllers
         * @return void
         */
        public function addRoutes(array $controllers) : void;


        /**
         * resolve() = fonction pour vérifier si l'uri_url match avec l'uri_route
         *
         * @return array|null
         */
        public function resolve() : ?array;
    }