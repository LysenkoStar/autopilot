<?php

namespace App\Controller;

use App\Provider\VkUserProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private $app_id;

    public function __construct($app_id)
    {
        $this->app_id = $app_id;
    }

    /**
     * @Route("/", name="index")
     * @param VkUserProvider $provider
     * @return Response
     */
    public function index(VkUserProvider $provider)
    {
        $uri = $provider->getAuthorizationLink();

        return $this->render('index/index.html.twig', [
            'login' => $uri,
        ]);
    }
}
