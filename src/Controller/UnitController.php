<?php

namespace App\Controller;

use App\Entity\Play;
use App\Form\Type\PlayType;
use App\Service\FetchUnitInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/unit")
 */
class UnitController extends BasicController
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
            $user = $this->getUser();
            $user->addPlay($play);

            $this->unitService->createPlay($play, $user);

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
        $user = $this->getUser();
        $isLiked = false;

        if (null !== $play->getUsersLiked()) {
            foreach ($play->getUsersLiked() as $compare) {
                if ($compare == $user) {
                    $isLiked = true;

                    break;
                }
            }
        }

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
        if ($this->getUser() === $this->unitService->getOneUnit($id)->getCreator()) {
            $this->unitService->deleteUnit($id);
        }

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

        if ($form->isSubmitted() && $form->isValid() && $this->getUser() == $play->getCreator()) {
            $play = $form->getData();
            $this->unitService->editPlay();

            return $this->redirectToRoute('details_page', ['id' => $id]);
        }

        return $this->render('forms/edit_play_form.html.twig', [
            'form' => $this->createForm(PlayType::class)->createView(),
            'play' => $play, ]);
    }

    /**
     * @Route("/like/{id<\d+>}", name="like_unit")
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function likeUnit($id)
    {
        $user = $this->getUser();
        $play = $this->unitService->getOneUnit($id);
        $play->addUsersLiked($user);

        $this->unitService->likePlay($play, $user);

        return $this->redirectToRoute('details_page', ['id' => $id]);
    }
}
