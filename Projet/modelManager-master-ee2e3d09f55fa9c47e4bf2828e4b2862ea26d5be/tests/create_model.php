<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 21:48
 */

// create_model.php <viewer_id> <XSDValidator_id> <model-hashes>
require_once __DIR__ . "/bootstrap.php";

$viewerId = 1;
$modelIds = [1,2];

$viewer = $entityManager->find("User", (int)$viewerId);
$model = new Model();
$model->setModel("A model");
$model->setDescription("A test model");
$model->setVersion(2);
if ($viewer != null) {
    $model->setViewer($viewer);
}


$entityManager->persist($model);
$entityManager->flush();

echo "Your new Model Hash ".$model->getHash()."\n";