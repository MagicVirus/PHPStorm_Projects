<?php
/**
 * Created by PhpStorm.
 * User: Ilyac
 * Date: 04/02/2018
 * Time: 22:28
 */

// user_views_repository.php <user-id>
require_once __DIR__ . "/bootstrap.php";

$theUserId = $argv[1];

$user = $entityManager->getRepository('Model')->getViewerModel($theUserId);

echo "User " . $user->getLogin() . " can view ".count($user->getVisibleModels()). " models:\n\n";

foreach ($user->getVisibleModels() as $model) {
    echo $model->getHash() . " - " . $model->getDescription(). " -" . $model->getVersion() ."\n";
    echo "Validated by : " . $model->getValidator()->getdescription() . $model->getValidator()->getVersion() . "\n";
}
