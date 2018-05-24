<?php
/**
 * Created by PhpStorm.
 * User: ilbenjello
 * Date: 05/02/18
 * Time: 10:30
 */
require_once __DIR__ . "/../config/bootstrap.php";
// create_XSD.php  <XSD_name> <version> <model_hash>
$XSDDesc = $argv[1];
$version = $argv[2];
$ModelHash = $argv[3];

$XSDValidator = new \App\Entity\XSDValidator();
$model = $entityManager->find("App\Entity\Model", (int)$hash);
$XSDValidator->setDescription($XSDDesc);
$XSDValidator->setXsd("A test XSD");
$XSDValidator->assignModel($model);
$XSDValidator->assignModel($model);

$entityManager->persist($user);
$entityManager->flush();

echo "Created User with ID " . $user->getId() . "\n";