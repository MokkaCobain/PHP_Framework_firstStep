<?php
namespace App\Zion\Abstract;

use App\Kernel;
use Twig\Environment;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;


    abstract class AbstractController
    {
        /**
         * La propriété représente le conteneur de service
         *
         * @var ContainerInterface
         */
        private ContainerInterface $container;

        /**
         * Le constructeur permet d'accéder au conteneur de service
         */
        public function __construct()
        {
            $this->container = Kernel::getKernel()->getContainer();
        }   

        /**
         * renderView() = fonction pour retourner le contenu de la vue à la méthode render()
         *
         * @param string $view_path
         * @param array $parameters
         * 
         * @return string
         */
        private function renderView(string $view_path, array $parameters = []) : string
        {
            // Si twig n'est pas trouvé, on lève une exception
            if( ! $this->container->has(Environment::class) )
            {
                throw new \Exception("Twig bundle is not available");
            }

            // Si twig trouvé on le récupère
            $twig = $this->container->get(Environment::class);

            // On utilise la fonction native render() pour rendre le contenu de la vue + stock dans $content
            $content = $twig->render($view_path, $parameters);

            // On retourne $content
            return $content;

        }

        /**
         * render() = fonction récupère le contenu de la vue appelée par $view_path grâce à la méthode renderView()
         * Elle retourne ensuite la réponse envoyée au controller qui l'appelle (exemple : WelcomeController)
         *
         * @param string $view_path
         * @param array $parameters
         * 
         * @return Response
         */
        public function render(string $view_path, array $parameters = []) : Response
        {
            // On récupère $content de renderView()
            $content = $this->renderView($view_path, $parameters);

            $response = new Response(
                $content,
                Response::HTTP_OK,
                ['content-type' => 'text/html']
            );
            return $response;
        }


        
    }