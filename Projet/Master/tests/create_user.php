<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 20:25
 */

// create_user.php
require_once __DIR__ . "/../config/bootstrap.php";

$userName = "test";

$user = new \App\Entity\User();
$user->setName($userName);

$entityManager->persist($user);
$entityManager->flush();

echo "Created User with ID " . $user->getId() . "\n";