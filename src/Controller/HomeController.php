<?php

namespace App\Controller;

use App\Service\FetchUnitInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class HomeController extends BasicController
{
    /**
     * @Route("/", methods="GET", name="home")
     */
    public function home(): Response
    {
        return $this->render('home/home_unauth.html.twig', [
        ]);
    }

    /**
     * @Route("home/{flag}", methods="GET", name="home_auth")
     *
     * @param mixed $flag
     */
    public function homeAuth($flag): Response
    {
        return $this->render('home/home_auth.html.twig', [
            'flag' => $flag,
        ]);
    }

    /**
     * @Route("unit/all/{flag}", name="all_units")
     *
     * @param mixed $flag
     *
     * @return Response
     */
    public function getAllUnits($flag, FetchUnitInterface $unitService)
    {
        $plays = $unitService->getAllUnits();

        if (null === $this->getUser()) {
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
