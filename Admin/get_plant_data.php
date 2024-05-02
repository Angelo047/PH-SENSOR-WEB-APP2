<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)
->withServiceAccount('ph-sensor-web-app-firebase-adminsdk-1ed6k-fefcd2b805.json')
->withDatabaseUri('https://ph-sensor-web-app-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();

if (isset($_POST['plantId'])) {
    $selectedPlantId = $_POST['plantId'];

    // Fetch plant data based on the selected plant ID
    $selectedPlantRef = $database->getReference('/plants/' . $selectedPlantId);
    $selectedPlantData = $selectedPlantRef->getSnapshot()->getValue();

    // Return the plant data as JSON
    echo json_encode($selectedPlantData);
}
?>
