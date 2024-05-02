<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)
->withServiceAccount('ph-sensor-web-app-firebase-adminsdk-1ed6k-fefcd2b805.json')
->withDatabaseUri('https://ph-sensor-web-app-default-rtdb.firebaseio.com/');


$database = $factory->createDatabase();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $ref_table = 'BAY/' . $id; // Adjust the reference to match your Firebase structure
    $data = $database->getReference($ref_table)->getValue();

    // Output data as JSON
    echo json_encode($data);
    exit;
}


?>
