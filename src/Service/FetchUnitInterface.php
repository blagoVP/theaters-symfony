<?php

namespace App\Service;

interface FetchUnitInterface
{
    public function getOneUnit($id);

    public function getAllUnits();

    public function deleteUnit($id);

    public function createPlay($play, $user);

    public function editPlay();

    public function likePlay($play, $user);
}
