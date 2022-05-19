<?php
namespace App\Zion\Attribute;

    #[\Attribute(\Attribute::TARGET_METHOD)]
    class Route 
    {
        /**
         * La propriété représente l'uri de la route
         *
         * @var string
         */
        private string $path;

        /**
         * La propriété représente le nom de la route
         *
         * @var string
         */
        private string $name;

        /**
         * La propriété représente les méthodes d'envoi de la requête
         *
         * @var array
         */
        private array $methods;

        public function __construct(string $path, string $name, array $methods)
        {
            $this->path = $path;
            $this->name = $name;
            $this->methods = $methods;
        }
        
        // Fonctions pour accéder aux propriétés en dehors de la class (les getteurs ou accesseurs)
        public function getPath()
        {
            return $this->path;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getMethods()
        {
            return $this->methods;
        }
    }