<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

$factory = (new Factory)
->withServiceAccount('ph-sensor-web-app-firebase-adminsdk-1ed6k-fefcd2b805.json')
->withDatabaseUri('https://ph-sensor-web-app-default-rtdb.firebaseio.com/');


    $database = $factory->createDatabase();
    $auth = $factory->createAuth();

    $reference = $database->getReference('/phSensorData');
    $snapshot = $reference->getSnapshot();
    $phSensorData = $snapshot->getValue();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($phSensorData);

?>
