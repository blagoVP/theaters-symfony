<?php

namespace App\Controller;

use App\Entity\Play;
use App\Form\Type\PlayType;
use App\Service\FetchUnitInterface;
use App\Service\FetchUserInterface;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/unit")
 */
class UnitController extends AbstractController
{
    private $unitService;

    public function __construct(FetchUnitInterface $fetchUnitService)
    {
        $this->unitService = $fetchUnitService;
    }

    /**
     * @Route("/create", name="create_unit")
     *
     * @return Response
     */
    public function createUnit(FetchUserInterface $fetchUserService, ValidatorInterface $validator)
    {
        // $user = $fetchUserService->getOneById(3);

        // $entityManager = $this->getDoctrine()->getManager();

        // $play = new Play();
        // $play->setCreatedAt(new DateTime());
        // $play->setCreator($user);
        // $play->setTitle('Man City ot user 1Cloud 9 by Caryl Churchill');
        // $play->setDescription('fajlfhaeflihsoihsondhcvnsdvhys');
        // $play->setImageUrl('https://media.timeout.com/images/103727773/380/285/image.jpg');

        // $errors = $validator->validate($play);
        // if (count($errors) > 0) {
        //     return new Response((string) $errors);
        // }

        // $entityManager->persist($play);
        // $entityManager->flush();

        return $this->render('forms/play_form.html.twig', ['form' => $this->createForm(PlayType::class)->createView()]);
    }

    /**
     * @Route("/details/{id<\d+>}", name="details_page")
     *
     * @return Response
     */
    public function details(string $id)
    {
        $play = $this->unitService->getOneUnit($id);
        $isLiked = false;

        return $this->render('unit/details_page.html.twig', [
            'play' => $play,
            'isLiked' => $isLiked,
        ]);
    }

    /**
     * @Route("/delete/{id<\d+>}", name="delete_unit")
     *
     * @return Response
     */
    public function deleteUnit(string $id)
    {
        $this->unitService->deleteUnit($id);

        return $this->redirectToRoute('home_auth');
    }

    /**
     * @Route("/edit/{id<\d+>}", name="edit_unit")
     */
    public function editUnit(string $id)
    {
        return new Response(
            "<html><body><h1>Edit page with id={$id}</h1></body></html>"
        );
    }

    /**
     * @Route("unit/all/{flag}", name="all_units")
     *
     * @param mixed $flag
     *
     * @return Response
     */
    public function getAllUnits($flag)
    {
        $plays = $this->unitService->getAllUnits();
        if ('0' === $flag) {
            $plays = array_slice($plays, 0, 3);

            return $this->render('unit/_three_units_unAuth.html.twig', [
                'plays' => $plays,
            ]);
        }

        return $this->render('unit/_units_auth.html.twig', [
            'plays' => $plays,
        ]);
    }
}
