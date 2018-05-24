<?php
/**
 * Created by PhpStorm.
 * User: teiva
 * Date: 31/01/18
 * Time: 14:35
 */

namespace App\Entity;

/**
 * @Admin
 * @ORM\Entity
 * @ORM\Table(name="Admin")
 */
class Admin extends User
{

    public function addUser($name, $pass){
      //TODO: hit DB to add user
    	$dql = "SELECT * FROM Model ";
    }

    public function removeUser($name){
      //TODO: hit DB to remove user
    }

    public function addModel($model, $email){
      //TODO: hit DB to add model to user
    }
}
