<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 22:25
 */

// find_by_hash.php <id>
require_once __DIR__ . "/bootstrap.php";

$hash = 1;

$model = $entityManager->find("Model", (int)$hash);

echo "Model: ".$model->getDescription().$model->getVersion()."\n";
