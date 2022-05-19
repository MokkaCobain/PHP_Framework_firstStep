<?php

namespace App\Zion\Routing;

// Import des class & interface
use App\Kernel;
use App\Zion\Attribute\Route;
use App\Zion\Contract\RouterInterface;
use Symfony\Component\HttpFoundation\Request;

class Router implements RouterInterface
{
    /**
     * La propriété représente l'armoire à routes
     *
     * @var array
     */
    private array $routes = [];

    /**
     * La propriété représente les paramètres (paramètres dynamiques de la route)
     *
     * @var array
     */
    private array $parameters = [];

    /**
     *  collectControllers($controllers) = fonciton pour récupérer la liste de tous les controllers. La liste est fournie par le Kernel
     * 
     * Elle transmet la liste à la methode "addRoutes"
     *
     * @param array $controllers
     * @return void
     */
    public function collectControllers(array $controllers): void
    {
        $this->addRoutes($controllers);
    }

    /**
     * addRoutes($controllers) = fonction qui stock les routes dans uen armoire à routes = $routes
     *
     * @param array $controllers
     * @return void
     */
    public function addRoutes(array $controllers): void
    {
        // Boucle qui parcourt le tableau des controllers
        foreach ($controllers as $controller) {
            // On récupère toutes les informations d'une class
            $reflectionController = new \ReflectionClass($controller);

            // On récupère les méthodes déclarées dans chaque controller
            $reflectionMethods = $reflectionController->getMethods();

            // Boucle qui parcourt chaque méthode
            foreach ($reflectionMethods as $reflectionMethod) {
                // Pour chaque méthode on récupère l'attribut #[Route]
                $reflectionAttributes = $reflectionMethod->getAttributes(Route::class);

                // Boucle qui parcourt chaque attribut
                foreach ($reflectionAttributes as $reflectionAttribute) {
                    // Pour chaque attribut on crée une nouvelle instance de route
                    $route = $reflectionAttribute->newInstance();

                    $this->routes[$route->getName()] =
                        [
                            "class" => $reflectionMethod->class,
                            "method" => $reflectionMethod->name,
                            "route" => $route,
                        ];
                }
            }
        }
    }


    /**
     * resolve() = fonction pour vérifier si l'uri_url match avec l'uri_route
     *
     * @return array|null
     */
    public function resolve(): ?array
    {

        // On récupère l'uri_url
        $request = Kernel::getKernel()->getContainer()->get(Request::class);

        $uri_url = $request->server->get('REQUEST_URI');

        foreach ($this->routes as $route) {

            $uri_route = $route['route']->getPath();

            if ($this->matches($uri_url, $uri_route)) {
                // dd('oui');
                if (isset($this->parameters) && !empty($this->parameters)) 
                {
                    return
                        [
                            "route" => $route,
                            "parameters" => $this->parameters,
                        ];
                }
                return
                [
                    "route" => $route
                ];
            }
        }
        return null;
    }

    private function matches($uri_url, $uri_route): bool
    {
        // On remplace les éléments dynamiques par un pattern
        $pattern = preg_replace("#{[a-z]+}#", "([a-zA-Z0-9]+)", $uri_route);

        $pattern = "#^$pattern$#";


        if (preg_match($pattern, $uri_url, $matches)) 
        {
            // dump("testtjh,bfd,ndxvb,xnb ");
            array_shift($matches);
            $this->parameters = $matches;

            return true;
        }
        return false;
    }
}
