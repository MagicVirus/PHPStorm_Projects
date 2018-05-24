<?php
/**
 * Created by PhpStorm.
 * User: ilbenjello
 * Date: 05/02/18
 * Time: 11:22
 */

// find_from_XSD.php <XSD_id>

$xsdId = $argv[1];

$xsd = $entityManager->find('App\Entity\XSDValidator', (int)$xsdId);

$model = $entityManager->getRepository('Model')->getModelFromXSD($xsd);

echo $model['description'] . " - " . $model['version']."\n";
echo "    Visible to: \n";
foreach ($model['viewers'] as $viewer) {
    echo "    user: ".$viewer['login']."\n";
}
echo "\n";