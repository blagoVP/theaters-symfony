<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @method null|User getUser()
 */
abstract class BasicController extends AbstractController
{
    protected function getUser(): User
    {
        return parent::getUser();
    }
}
