<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 21:03
 */

// update_user.php <id> <new-name>
require_once __DIR__ . "/bootstrap.php";

$id = 1;
$newName = "test2";

$user = $entityManager->find('User', (int)$id);

if ($user == null) {
    echo "User $id does not exist.\n";
    exit(1);
}

$user->setName($newName);

$entityManager->flush();