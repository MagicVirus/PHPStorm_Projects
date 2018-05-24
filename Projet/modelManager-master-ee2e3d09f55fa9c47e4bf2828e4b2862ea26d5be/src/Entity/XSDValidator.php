<?php
/**
* Created by PhpStorm.
* User: ilbenjello
* Date: 05/02/18
* Time: 09:56
*/

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="XSDValidator")
*/
class XSDValidator
{
  /**
  * @ORM\Id
  * @ORM\GeneratedValue
  * @ORM\Column(type="integer")
  * @var int
  */
  protected $id;
  /**
  * @ORM\Column(type="string")
  * @var string
  */
  protected $description;

  /**
  * @ORM\Column(type="string")
  * @var string
  */
  protected $xsd;

  /**
  * @ORM\Column(type="string")
  * @var string
  */
  protected $xml;

  /**
  * @ORM\Column(type="string")
  * @var string - the model this XSD validates
  */
  protected $modelValidated;

  /**
  * @param string $modelValidated
  */
  public function assignModel(Model $modelValidated)
  {
    $this->modelValidated = $modelValidated;
  }

  /**
  * @return int
  */
  public function getId()
  {
    return $this->id;
  }

  /**
  * @return string
  */
  public function getModelValidated(): string
  {
    return $this->modelValidated;
  }

  /**
  * @return string
  */
  public function getDescription(): string
  {
    return $this->description;
  }

  /**
  * @return string
  */
  public function getXsd(): string
  {
    return $this->xsd;
  }

  /**
  * @param string $xsd
  */
  public function setXsd(string $xsd)
  {
    $this->xsd = $xsd;
  }

  /**
  * @param string $description
  */
  public function setDescription(string $description)
  {
    $this->description = $description;
  }

  public function setXml(string $xml){
    $this->xml = $xml;
  }

  /**
  * @return string
  * "valid" if OK notValid otherwise
  */
  public function isValid(){
    //TODO: check if models are OK
    return "valid";
  }

  public function getComparedFile($modelTab){
    return "Model Compared";
  }

}
