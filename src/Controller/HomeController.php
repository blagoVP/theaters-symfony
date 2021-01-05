<?php

namespace App\Controller;

use App\Service\FetchUnitInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request): Response
    {
        // dd($request->getPathInfo());
        if (null == $this->getUser()) {
            return $this->render('home/home_unauth.html.twig', [
            ]);
        }

        return $this->redirectToRoute('home_auth', [
            'flag' => 'default',
        ]);
    }

    /**
     * @Route("/home/{flag}", methods="GET", name="home_auth")
     *
     * @param mixed $flag
     */
    public function home($flag, Request $request): Response
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

        if ('sort_by_date' === $flag) {
            uasort($plays, function ($a, $b) {
                return strtotime($a->getCreatedAt()->format('Y-m-d H:i:s')) < strtotime($b->getCreatedAt()->format('Y-m-d H:i:s'));
            });
        }

        if ('default' === $flag) {
            uasort($plays, function ($a, $b) {
                return strtotime($a->getCreatedAt()->format('Y-m-d H:i:s')) > strtotime($b->getCreatedAt()->format('Y-m-d H:i:s'));
            });
        }

        if ('sort_by_likes' === $flag) {
            uasort($plays, function ($a, $b) {
                return count($a->getUsersLiked()) < count($b->getUsersLiked());
            });
        }

        return $this->render('unit/_units_auth.html.twig', [
            'plays' => $plays,
        ]);
    }
}
