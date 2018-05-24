<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 22:20
 */

// list_model_repository.php
require_once __DIR__ . "/../config/bootstrap.php";


$models = $entityManager->getRepository('Model')->getModelArray();

foreach ($models as $model) {
    echo $model['description'] . " - " . $model['version'] . "\n";
    echo "    Visible to: \n";
    foreach ($model['viewers'] as $viewer) {
        echo "    user: " . $viewer['login'] . "\n";
    }
    echo "\n";
}