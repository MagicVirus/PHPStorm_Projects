<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="Users")
 * @ORM\Entity
 **/
class User
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $login;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $password;

    /**
     * @ORM\ManyToOne(targetEntity="Model")
     * @var Model[] an ArrayCollection of Models.
     **/
    protected $visibleModels = null;

    public function __construct()
    {
        $this->visibleModels = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setName($login)
    {
        $this->login = $login;
    }

    public function getPassword(){
        return $this->password;
    }

    public function canView(Model $model){
        $this->visibleModels [] = $model;
    }

    public function getVisibleModels(){
        $ret = array();
        foreach ($this->visibleModels as $model){
            $ret [] = $model;
        }
        return $ret;
    }
}