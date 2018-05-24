<?php
/**
 * Created by PhpStorm.
 * User: Magi
 * Date: 05/02/2018
 * Time: 11:31
 */

namespace App\Entity;


class Place
{
    public $name;

    public $address;

    public function __construct($name, $address)
    {
        $this->name = $name;
        $this->address = $address;
    }
}