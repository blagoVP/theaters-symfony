<?php

namespace App\Service;

use App\Repository\UserRepository;

class FetchUserService implements FetchUserInterface
{
    private $repo;

    public function __construct(UserRepository $userRepository)
    {
        $this->repo = $userRepository;
    }

    public function getAll()
    {
        return $this->repo->findAll();
    }

    public function getOneById($id)
    {
        return $this->repo->find($id);
    }
}
