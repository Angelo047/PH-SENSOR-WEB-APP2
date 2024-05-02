<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)
    ->withServiceAccount('ph-sensor-web-app-firebase-adminsdk-1ed6k-fefcd2b805.json')
    ->withDatabaseUri('https://ph-sensor-web-app-default-rtdb.firebaseio.com/');

    $database = $factory->createDatabase();
$auth = $factory->createAuth(); // Create the authentication service

// Check if the request contains the user ID
if (isset($_POST['id'])) {
    $userId = $_POST['id'];

    try {
        // Get user data from Firebase Authentication
        $user = $auth->getUser($userId);

        // Prepare user data to send back as JSON response
        $userData = [
            'displayName' => $user->displayName,
            'email' => $user->email,
            'phoneNumber' => $user->phoneNumber,
            'claims' => $user->customClaims,
            'status' => $user->disabled
        ];

        // Send user data as JSON response
        echo json_encode($userData);
    } catch (\Exception $e) {
        // Handle any errors
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // If user ID is not provided in the request
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'User ID not provided']);
}
?>