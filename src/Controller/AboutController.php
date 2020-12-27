<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    // @Route("/about")
    // public function aboutPage(UserRepository $userRepository): Response
    // {
    //     $user = $userRepository->find(27);

    //     return new Response(var_dump($user));
    // }
}
