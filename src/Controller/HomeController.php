<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", methods="GET", name="home")
     */
    public function home(): Response
    {
        return $this->render('home/home_unauth.html.twig', [
            'someVar' => 'sasasa',
        ]);
    }

    /**
     * @Route("home", methods="GET", name="home_auth")
     *
     * @return Response
     */
    public function homeAuth()
    {
        return $this->render('home/home_auth.html.twig', [
            'someVar' => 'sasasa',
        ]);
    }
}
