<?php
session_start(); // Start the session

require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$factory = (new Factory)
    ->withServiceAccount('ph-sensor-web-app-firebase-adminsdk-1ed6k-fefcd2b805.json')
    ->withDatabaseUri('https://ph-sensor-web-app-default-rtdb.firebaseio.com/');

    $database = $factory->createDatabase();
    $auth = $factory->createAuth();

    // Check if the user is authenticated and has a valid session
if (isset($_SESSION['verified_user_id'])) {
    $uid = $_SESSION['verified_user_id'];

    // Fetch all users from Firebase Authentication
    $users = $auth->listUsers(); // This will return a UserRecords instance
    $user = $auth->getUser($uid);


    $Facilitator = $user->displayName;


    // Rest of your code remains unchanged...
    $plantId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($plantId) {
        $plantInfoRef = $database->getReference('/plants')->getChild($plantId);
        $plantInfo = $plantInfoRef->getValue();

        if ($plantInfo) {
            $requiredLowPhLevel = $plantInfo['ph_lvl_low'];
            $requiredHighPhLevel = $plantInfo['ph_lvl_high'];
            $plantName = $plantInfo['plant_name'];

            date_default_timezone_set('Asia/Manila'); // Set the timezone to Philippines

            // Call the pH level check function
        } else {
            echo 'Plant information not found.' . PHP_EOL;
        }
    } else {
        echo 'Invalid plant ID.' . PHP_EOL;
    }

    // Function to check pH level
    function checkPhLevel($requiredLowPhLevel, $requiredHighPhLevel, $plantName, $database, $plantInfo, $users, $Facilitator, $plantId) {
        $phSensorDataRef = $database->getReference('/phSensorData');
        $latestPhSensorData = $phSensorDataRef->orderByKey()->limitToLast(1)->getSnapshot()->getValue();

        if (empty($latestPhSensorData)) {
            // Handle the case where no pH data is available
            echo 'No pH data available.' . PHP_EOL;
            return;
        }

        $latestPhValue = reset($latestPhSensorData);

        $status = ''; // Variable to hold the status

        $latestPhValue = number_format($latestPhValue, 1); // Format to one decimal point

        if ($latestPhValue > $requiredHighPhLevel) {
            $status = 'High';
        } elseif ($latestPhValue < $requiredLowPhLevel) {
            $status = 'Low';
        }

        if ($status !== '') {
            // pH level is either high or low, create a notification
            $notificationsRef = $database->getReference('/notifications')->push();
            $notificationsRef->set([
                'plant_name' => $plantInfo['plant_name'],
                'plant_photo' => $plantInfo['plant_photo'],
                'message' => "$status pH Level: $latestPhValue ",
                'current_date' => date('h:i A, m/d/Y'),
                'isRead' => 0,
                'Facilitator' => $Facilitator,
                'ph_lvl' => "$latestPhValue",
                'status' => $status,
                'plant_id' => $plantId,
                'bay' =>  $plantInfo['bay'],
            ]);
            // Send email notification using PHPMailer for each user
            foreach ($users as $userRecord) {
                $toEmail = $userRecord->email;
                $fullName = $userRecord->displayName;
                sendEmailNotification($toEmail, $latestPhValue, $plantName, $status, $requiredLowPhLevel, $requiredHighPhLevel, $fullName);
            }
        } else {
            echo 'pH value is within the acceptable range for ' . $plantInfo['plant_name'] . '.' . PHP_EOL;
        }
    }

    // Function to send email notification using PHPMailer
    function sendEmailNotification($toEmail, $latestPhValue, $plantName, $status, $requiredLowPhLevel, $requiredHighPhLevel, $fullName) {
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'guiltiasin941@gmail.com'; // Replace with your Gmail email
        $mail->Password = 'jbxv rlzo zrif hajw';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('guiltiasin941@gmail.com', 'PH WATER');
        $mail->addAddress($toEmail);
        $mail->isHTML(true);
        $mail->Subject = 'pH Level Notification';
        $mail->Body = "The pH level of your $plantName is $status outside the acceptable range of $requiredLowPhLevel to $requiredHighPhLevel" . "<br>" .
            "The current pH level is: $latestPhValue";

        if (!$mail->send()) {
            echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Email sent successfully';
        }
    }
    checkPhLevel($requiredLowPhLevel, $requiredHighPhLevel, $plantName, $database, $plantInfo, $users, $Facilitator, $plantId);

} else {
    echo 'User not authenticated.' . PHP_EOL;
}
?>