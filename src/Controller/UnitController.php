<?php

namespace App\Controller;

use App\Entity\Play;
use App\Form\Type\PlayType;
use App\Service\FetchUnitInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function createUnit(Request $request)
    {
        $play = new Play();

        $form = $this->createForm(PlayType::class, $play);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $play = $form->getData();
            $play->setCreator(($this->getUser()));

            $this->unitService->createPlay($play);

            return $this->redirectToRoute('home_auth');
        }

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
    public function editUnit(string $id, Request $request)
    {
        $play = $this->unitService->getOneUnit($id);
        $form = $this->createForm(PlayType::class, $play);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $play = $form->getData();
            $this->unitService->editPlay();

            return $this->redirectToRoute('details_page', ['id' => $id]);
        }

        return $this->render('forms/edit_play_form.html.twig', [
            'form' => $this->createForm(PlayType::class)->createView(),
            'play' => $play, ]);
    }

    public function likeUnit($id)
    {
        // code...
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
