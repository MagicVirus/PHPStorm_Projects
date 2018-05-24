<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 21:01
 */

// list_users.php
require_once __DIR__ . "/../config/bootstrap.php";

$userRepository = $entityManager->getRepository('User');
$users = $userRepository->findAll();

foreach ($users as $user) {
    echo sprintf("-%s\n", $user->getName());
}