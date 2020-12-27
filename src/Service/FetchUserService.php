<?php

namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class FetchUserService implements FetchUserInterface
{
    private $repo;

    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->repo = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function getAll()
    {
        return $this->repo->findAll();
    }

    public function getOneById($id)
    {
        return $this->repo->find($id);
    }

    public function registerUser($user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
