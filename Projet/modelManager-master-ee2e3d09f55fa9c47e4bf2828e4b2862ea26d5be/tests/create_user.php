<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 20:25
 */

// create_user.php
require_once __DIR__ . "/bootstrap.php";

$userName = "test";
$password = "test";

$user = new User();
$user->setName($userName);
$user->setPassword($password);

try {
    $entityManager->persist($user);
    $entityManager->flush();
} catch (\Doctrine\ORM\ORMException $e) {
}

echo "Created User with ID " . $user->getId() . "\n";