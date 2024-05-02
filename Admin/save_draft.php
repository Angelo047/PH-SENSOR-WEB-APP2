<?php
session_start(); // Start the session

require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

// Initialize Firebase
$factory = (new Factory)
    ->withServiceAccount('ph-sensor-web-app-firebase-adminsdk-1ed6k-fefcd2b805.json')
    ->withDatabaseUri('https://ph-sensor-web-app-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();

$plant_id = isset($_GET["id"]) ? $_GET["id"] : null;

if(isset($_POST["plant_id"]) && isset($_POST["recentChanges"])) {
    $plant_id = $_POST["plant_id"]; // Change $plant_id to $_POST["plant_id"]
    $recentChanges = $_POST["recentChanges"];
    $bay_systemOverview = $_POST["bay_systemOverview"];
    $bay_performance = $_POST["bay_performance"];
    $nft_systemOverview = $_POST["nft_systemOverview"];
    $nft_performance = $_POST["nft_performance"];
    $Challenges = $_POST["Challenges"];
    $Solutions = $_POST["Solutions"];
    $Improvements = $_POST["Improvements"];
    $Practices = $_POST["Practices"];


    if($plant_id != '') { // Change $post_id to $plant_id
        // Update post (draft)
        $database->getReference('drafts/' . $plant_id)->set([
            'recentChanges' => $recentChanges,
            'bay_systemOverview' => $bay_systemOverview,
            'bay_performance' => $bay_performance,
            'nft_systemOverview' => $nft_systemOverview,
            'nft_performance' => $nft_performance,
            'Challenges' => $Challenges,
            'Solutions' => $Solutions,
            'Improvements' => $Improvements,
            'Practices' => $Practices,
        ]);
        // Get the key of the newly inserted post
        $last_insert_id = $newPost->getKey();
        echo $last_insert_id;
        exit;
    }
}

?>
