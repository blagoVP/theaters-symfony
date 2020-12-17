<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Service\FetchUserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     *
     * @return Response
     */
    public function login()
    {
        return $this->render('forms/login_form.html.twig', ['form' => $this->createForm(UserType::class)->createView()]);
    }

    /**
     * @Route("/register", name="register")
     *
     * @return Response
     */
    public function register()
    {
        return $this->render('forms/register_form.html.twig', ['form' => $this->createForm(UserType::class)->createView()]);
    }

    /**
     * @Route("/test", name="test")
     *
     * @return Response
     */
    public function testRegister(ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername('test user2');
        $user->setPassword('passsss');

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new Response((string) $errors);
        }

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response(
            '<html><body><h1>Database persisted</h1></body></html>'
        );
    }

    /**
     * @Route("/getuser/{id}")
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function getTestUesr($id, FetchUserInterface $fetchUser)
    {
        $user = $fetchUser->getOneById($id)->getUsername();

        return new Response($user);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        return new Response(
            '<html><body><h1>Logout</h1></body></html>'
        );
    }
}
