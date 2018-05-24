<?php
/**
 * Created by PhpStorm.
 * User: teiva
 * Date: 31/01/18
 * Time: 14:35
 */

namespace App\Entity;

use App\Controller\ControllerModel;
use App\Repository;

class Admin extends User
{

    public function addUser($login, $pass, $entityManager){
        $user = new User();
        $user->setName($login);
        $user->setPassword($pass);
        try {
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (\Doctrine\ORM\ORMException $e) {
        }
    }

    public function removeUser($name){
      //TODO: hit DB to remove user
    }

    public function addModel($model, $email){
      //TODO: hit DB to add model to user
    }
}
