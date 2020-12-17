<?php

namespace App\Service;

use App\Repository\PlayRepository;
use Doctrine\ORM\EntityManagerInterface;

class FetchUnitService implements FetchUnitInterface
{
    private $repo;

    private $entityManager;

    public function __construct(PlayRepository $playRepository, EntityManagerInterface $entityManager)
    {
        $this->repo = $playRepository;
        $this->entityManager = $entityManager;
    }

    public function getAllUnits()
    {
        return $this->repo->findAll();
    }

    public function getOneUnit($id)
    {
        return $this->repo->find($id);
    }

    public function deleteUnit($id)
    {
        $play = $this->getOneUnit($id);
        $this->entityManager->remove($play);
        $this->entityManager->flush();
    }
}
