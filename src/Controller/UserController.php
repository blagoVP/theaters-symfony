<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Service\FetchUserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    private $userService;

    public function __construct(FetchUserInterface $fetchUserService)
    {
        $this->userService = $fetchUserService;
    }

    /**
     * @Route("/register", name="register")
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $user = $form->getData();
            $user->setRoles(['ROLE_USER']);
            $this->userService->registerUser($user);

            return $this->redirectToRoute('home_auth');
        }

        return $this->render('forms/register_form.html.twig', ['form' => $this->createForm(UserType::class)->createView()]);
    }
}
