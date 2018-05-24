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
 * @ORM\Table(name="Models")
 * @ORM\Entity
 **/
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


    /**
     * @param User $user
     */
    public function setViewer(User $user)
    {
        $user->canView($this);
        $this->viewers[] = $user;
    }

    public function getViewers()
    {
        $ret = array();
        foreach ($this->viewers as $viewer) {
            $ret [] = $viewer;
        }
        return $ret;
    }

    /**
     * @return int
     */
    public function getHash(): int
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
      return "Model Content";
      //  return $this->model;
    }

    /**
     * @param $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
      return "1.0";
      //  return $this->version;
    }

    /**
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
      return "Description";
        return $this->description;
    }

    /**
     * @param XSDValidator $XSDValidator
     */
    public function assignXSDValidator(XSDValidator $XSDValidator)
    {
        $this->validator = $XSDValidator;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @param User[] $viewers
     */
    public function setViewers(array $viewers): void
    {
        $this->viewers = $viewers;
    }

    /**
     * @param XSDValidator $validator
     */
    public function setValidator(XSDValidator $validator): void
    {
        $this->validator = $validator;
    }
}
