<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 22:28
 */

// user_views.php <user-id>
require_once __DIR__ . "/../config/bootstrap.php";

$theUserId = $argv[1];

$dql = "SELECT * FROM User WHERE id = ?1";

$User = $entityManager->createQuery($dql)
    ->setParameter(1, $theUserId)
    ->setMaxResults(15)
    ->getResult();

echo "User " . $user->getLogin() . " can view ".count($user->getVisibleModels()). " models:\n\n";

foreach ($user->getVisibleModels() as $model) {
    echo $model->getHash() . " - " . $model->getDescription(). " -" . $model->getVersion() ."\n";
}