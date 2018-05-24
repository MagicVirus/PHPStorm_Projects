<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 21:48
 */

// create_model.php <viewer_id> <model-hashes>
require_once __DIR__ . "/../config/bootstrap.php";

$viewerId = $argv[1];
$modelIds = explode(",", $argv[3]);

$viewer = $entityManager->find("App\Entity\User", $viewerId);
if (!$viewer) {
    echo "No viewer found for the given id(s).\n";
    exit(1);
}

$model = new \App\Entity\Model();
$model->setModel("A model");
$model->setDescription("A test model");


$model->setViewer($viewer);

$entityManager->persist($model);
$entityManager->flush();

echo "Your new Model Hash ".$model->getHash()."\n";