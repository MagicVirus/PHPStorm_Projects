<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 18:07
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__."/../vendor/autoload.php";
$isDevMode = true;

$dbParams = array(
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => '',
    'dbname' => 'db_projet_tut'
);

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/"), $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
