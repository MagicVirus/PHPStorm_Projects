<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 21:06
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="modelRepository")
 * @ORM\Table(name="models")
 */
class Model
{
    /**
     * @ORM\id @ORM\Column(type="integer")
     * @var int
     **/
    protected $hash;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(type="string") full model
     * @var string
     **/
    protected $model;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $version;
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="visibleModels")
     * @var User[] An ArrayCollection of Users.
     **/
    protected $viewers;

    public function setViewer(User $user){
        $user->canView($this);
        $this->viewers[] = $user;
    }

    public function getViewers(){
        $ret = array();
        foreach ($this->viewers as $viewer){
            $ret [] = $viewer;
        }
        return $ret;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getVersion(){
        return $this->version;
    }
    public function setDescription($description){
        $this->description = $description;
    }
    public function getDescription(){
        return $this->description;
    }
}