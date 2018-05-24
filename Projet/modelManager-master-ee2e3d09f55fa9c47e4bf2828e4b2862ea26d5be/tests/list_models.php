<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 22:20
 */
// list_models.php
require_once __DIR__ . "/bootstrap.php";

$dql = "SELECT * FROM Model ";
$query = $entityManager->createQuery($dql);
$models = $query->getArrayResult();

foreach ($models as $model) {
    echo $model['description'] . " - " . $model['version']."\n";
    echo "    Visible to: \n";
    foreach ($model['viewers'] as $viewer) {
        echo "    user: ".$viewer['login']."\n";
    }
    echo "\n";
}