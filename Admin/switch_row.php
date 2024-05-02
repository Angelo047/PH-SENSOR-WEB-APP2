<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)
    ->withServiceAccount('ph-sensor-web-app-firebase-adminsdk-1ed6k-fefcd2b805.json')
    ->withDatabaseUri('https://ph-sensor-web-app-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();

// Function to check pH level and control switches
function checkAndUpdateSwitches($database) {
    // Get current pH level data from Firebase
    $phSensorData = $database->getReference('/phSensorData')->getValue();
    $latestPhValue = end($phSensorData);

    // Get plant pH level range from Firebase or any other source
    $plantId = isset($_GET['id']) ? $_GET['id'] : null;
    $plantInfo = $database->getReference("/plants/$plantId")->getValue();

    // Check if plant information is available and keys exist
    if ($plantInfo && isset($plantInfo['ph_lvl_low']) && isset($plantInfo['ph_lvl_high'])) {
        $requiredLowPhLevel = $plantInfo['ph_lvl_low'];
        $requiredHighPhLevel = $plantInfo['ph_lvl_high'];

        // Get the previous pH level from Firebase or any other source
        $previousPhLevel = $database->getReference("/plants/$plantId/previousPhLevel")->getValue();

        // Determine if pH level is within the acceptable range
        if ($latestPhValue >= $requiredLowPhLevel && $latestPhValue <= $requiredHighPhLevel) {
            // pH level is within the acceptable range
            if ($previousPhLevel < $requiredLowPhLevel || $previousPhLevel > $requiredHighPhLevel) {
                // The previous pH level was outside the acceptable range, update the switches
                $database->getReference('/relay/1/switch')->set('off');
                $database->getReference('/relay/2/switch')->set('off');
                $database->getReference('/relay/1/disabled')->set(true);
                $database->getReference('/relay/2/disabled')->set(true);
            }
        } else {
            // pH level is outside the acceptable range
            if ($previousPhLevel >= $requiredLowPhLevel && $previousPhLevel <= $requiredHighPhLevel) {
                // The previous pH level was within the acceptable range, update the switches
                $database->getReference('/relay/1/switch')->set('off');
                $database->getReference('/relay/2/switch')->set('off');
                $database->getReference('/relay/1/disabled')->set(false);
                $database->getReference('/relay/2/disabled')->set(false);
            }

            // If pH level is higher than ph_lvl_high, turn on relay 1 for 5 seconds
            if ($latestPhValue <= $requiredHighPhLevel) {
                $database->getReference('/relay/1/switch')->set('on');
                sleep(10); // Wait for 5 seconds
                $database->getReference('/relay/1/switch')->set('off');
                // Sleep for 2 minutes (24 iterations * 5 seconds = 120 seconds)
                for ($i = 0; $i < 24; $i++) { // 24 iterations = 120 seconds
                    sleep(5); // Sleep for 5 seconds
                    // Check if pH level is still higher than ph_lvl_high, if not, break the loop
                    if ($latestPhValue > $requiredHighPhLevel) {
                        break;
                    }
                }
            }

            // If pH level is lower than ph_lvl_low, turn on relay 2 for 5 seconds
            if ($latestPhValue >= $requiredLowPhLevel) {
                $database->getReference('/relay/2/switch')->set('on');
                sleep(10); // Wait for 5 seconds
                $database->getReference('/relay/2/switch')->set('off');
                // Sleep for 2 minutes (24 iterations * 5 seconds = 120 seconds)
                for ($i = 0; $i < 24; $i++) { // 24 iterations = 120 seconds
                    sleep(5); // Sleep for 5 seconds
                    // Check if pH level is still lower than ph_lvl_low, if not, break the loop
                    if ($latestPhValue < $requiredLowPhLevel) {
                        break;
                    }
                }
            }

    }


        // Update the previous pH level
        $database->getReference("/plants/$plantId/previousPhLevel")->set($latestPhValue);
    } else {
        // Plant information not found or keys are not defined
        echo 'Plant information not found or incomplete.' . PHP_EOL;
    }
}

// Call the function to check pH level and control switches
checkAndUpdateSwitches($database);
?>
