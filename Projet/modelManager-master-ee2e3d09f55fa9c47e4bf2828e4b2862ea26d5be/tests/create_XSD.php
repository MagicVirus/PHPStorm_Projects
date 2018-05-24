<?php
/**
 * Created by PhpStorm.
 * User: ilbenjello
 * Date: 05/02/18
 * Time: 10:30
 */
require_once __DIR__ . "/bootstrap.php";
// create_XSD.php  <XSD_name> <version> <model_hash>
$XSDDesc = "test xsd";
$version = "1";
$ModelHash = '1';

$XSDValidator = new XSDValidator();
$model = $entityManager->find("Model", (int)$ModelHash);
$XSDValidator->setDescription($XSDDesc);
$XSDValidator->setXsd("A test XSD");
if($model != null){
    $XSDValidator->assignModel($model);
    $model->assignXSDValidator($XSDValidator);
}



$entityManager->persist($XSDValidator);
$entityManager->flush();

echo "Created XSD with ID " . $XSDValidator->getId() . "\n";