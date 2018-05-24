<?php

namespace App\Entity;

use App\Gateway\GatewayUser;
use App\Entity\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @User
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

  private $gatewayUser;
  private $admin;

  /**
  * User constructor.
  */
  public function __construct()
  {
    //TODO: get visibleModels from DB
    $this->visibleModels = new ArrayCollection();
    $this->gatewayUser = new GatewayUser();
  }

  /**
  * @return int
  */
  public function getId() :int
  {
    return $this->id;
  }

  /**
  * @return string
  */
  public function getLogin(): string
  {
    return $this->login;
  }

  /**
  * @param $login
  */
  public function setName($login)
  {
    $this->login = $login;
  }

  public function isAdmin(){
    return $this->admin;
  }

  /**
  * @return string
  */
  public function getPassword(): string
  {
    return $this->password;
  }

  /**
  * @param Model $model
  */
  public function canView(Model $model)
  {
    $this->visibleModels [] = $model;
  }

  /**
  * @return array
  */
  public function getVisibleModels()
  {
    $ret = array();

    $model1 = new Model();
    $model2 = new Model();

    $ret [] = $model1;
    $ret [] = $model2;

    // foreach ($this->visibleModels as $model) {
    //     $ret [] = $model;
    // }
    return $ret;
  }

  public function connectUser($usr, $pass){
    if($this->gatewayUser->isValidLogin($usr, $pass)){
      $this->id = $this->gatewayUser->getID($usr);
      $this->admin = $this->gatewayUser->isAdmin($this->id);
      return true;
    }
    return false;
  }

  public function isConnected($id){
    if($this->gatewayUser->isConnected($id)){
      $this->id = $id;
      $this->admin = $this->gatewayUser->isAdmin($this->id);
      return true;
    }
    return false;
  }
}
