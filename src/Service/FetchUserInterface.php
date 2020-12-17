<?php

namespace App\Service;

interface FetchUserInterface
{
    public function getAll();

    public function getOneById($id);
}
