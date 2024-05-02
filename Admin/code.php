<?php
include('dbcon.php');
session_start();



if(isset($_POST['id']) && isset($_POST['plant_status'])) {
    $id = $_POST['id'];
    $plant_status = $_POST['plant_status'];
    $plant_name = $_POST['plant_name'];
    $ph_lvl_high = $_POST['ph_lvl_high'];
    $ph_lvl_low = $_POST['ph_lvl_low'];
    $bay = $_POST['bay'];
    $nft = $_POST['nft'];
    $date_planted = $_POST['date_planted'];

    // Get the current user's ID
    $uid = $_SESSION['verified_user_id'];

    // Fetch the current user's display name from Firebase Authentication
    $user = $auth->getUser($uid);
    $Facilitator = $user->displayName;

    // Get current timestamp
    $timestamp = date('Y-m-d H:i:s');

    try {
        // Construct the data for activities
        $postData3 = [
            'plant_name' => $plant_name,
            'ph_lvl_high' => $ph_lvl_high,
            'ph_lvl_low' => $ph_lvl_low,
            'bay' => $bay,
            'nft' => $nft,
            'date_planted' => $date_planted,
            'Facilitator' => $Facilitator,
            'Action' => 'Updated',
            'timestamp' => $timestamp,
        ];

        // Push data to the activities database
        $ref_table3 = "activities";
        $postRef_result3 = $database->getReference($ref_table3)->push($postData3);

        // Update the plant status and claim_date
        $claim_date = date('Y-m-d');

        // Update plant status and claim_date in the Firebase Realtime Database
        $plantRef = $database->getReference('plants/' . $id);
        $plantRef->update([
            'plant_status' => $plant_status,
            'claim_date' => $claim_date,
        ]);

        // Redirect with success message
        $_SESSION['success'] = "Plant status updated successfully!";
        header('Location: plants'); // Replace with the correct page URL
        exit();
    } catch (Exception $e) {
        // Handle any exceptions
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header('Location: plants.php'); // Redirect to an error page
        exit();
    }
}




if (isset($_POST['delete-plants-btn'])) {
    $plantId = $_POST['id'];

    $plantRef = $database->getReference('plants/' . $plantId);

    $plantRef->remove();

    $_SESSION['success'] = "You have successfully deleted this plant";
    header('Location: plants');
      exit;
}




if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    try {
        $auth->deleteUser($userId);
        $_SESSION['success'] = "User Deleted Successfully";
        echo json_encode(['success' => true]); // Send success response
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "User Failed to Delete";
        echo json_encode(['error' => 'User deletion failed']); // Send error response
        exit();
    }
}


if(isset($_POST['id']) && isset($_POST['plant_status'])) {
    $id = $_POST['id'];
    $plant_status = $_POST['plant_status'];

    // Get the current date
    $claim_date = date('Y-m-d');

    // Assuming $database is your Firebase instance
    $plantRef = $database->getReference('plants/' . $id);

    // Update the plant status and claim_date
    $plantRef->update([
        'plant_status' => $plant_status,
        'claim_date' => $claim_date,
    ]);

    // Redirect with success message
    $_SESSION['success'] = "Plant status updated successfully!";
    header('Location: plants'); // Replace with the correct page URL
    exit();
}


if (isset($_POST['edit-plant-details-btn'])) {
    $plantId = $_POST['id'];
    $plant_name = $_POST['plant_name'];
    $ph_lvl_high = $_POST['ph_lvl_high'];
    $ph_lvl_low = $_POST['ph_lvl_low'];
    $days_harvest = $_POST['days_harvest'];

    $plantRef = $database->getReference('plants_details/' . $plantId);

    $plantRef->update([
        'plant_name' => $plant_name,
        'ph_lvl_high' => $ph_lvl_high,
        'ph_lvl_low' => $ph_lvl_low,
        'days_harvest' => $days_harvest,
    ]);

    $_SESSION['success'] = "You have successfully deleted this registered plant";
    header('Location: plants_details');
    exit;
}



if (isset($_POST['delete-plant-btn'])) {
    $plantId = $_POST['id'];

    $plantRef = $database->getReference('plants_details/' . $plantId);

    $plantRef->remove();

    $_SESSION['success'] = "Plant Details deleted successfully";
    header('Location: plants_details');
      exit;
}


if (isset($_POST['delete-bay-btn'])) {
    $bayId = $_POST['id'];

    $bayRef = $database->getReference('BAY/' . $bayId);

    $bayRef->remove();

    $_SESSION['success'] = "You have successfully deleted this registered bay";
    header('Location: bay_nft');
      exit;
}



if (isset($_POST['edit-bay-btn'])) {
    $bayId = $_POST['id'];
    $newBAYValue = $_POST['bay'];
    $newBAYValue2 = $_POST['placement'];


    $bayRef = $database->getReference('BAY/' . $bayId);

    $bayRef->update([
        'bay' => $newBAYValue,
        'placement' => $newBAYValue2,
    ]);

    $_SESSION['success'] = "Bay and Placement Updated successfully";
        header('Location: bay_nft');
    exit;
}


    if (isset($_POST['delete-nft-btn'])) {
        $nftId = $_POST['id'];

        $nftRef = $database->getReference('NFT/' . $nftId);

        $nftRef->remove();

        $_SESSION['success'] = "You have successfully deleted this registered pipe or NFT.";
        header('Location: bay_nft');
          exit;
    }


if (isset($_POST['edit-nft-btn'])) {
    // Get the NFT ID and new value from the form
    $nftId = $_POST['id'];
    $newNFTValue = $_POST['nft'];

    // Reference to the NFT in the Realtime Database
    $nftRef = $database->getReference('NFT/' . $nftId);

    // Update the NFT value
    $nftRef->update([
        'nft' => $newNFTValue,
    ]);

    // Redirect or perform any other actions after the update
    $_SESSION['success'] = "NFT Updated successfully";
        header('Location: bay_nft');
    exit;
}


if (isset($_POST['add-nft-btn'])) {
    $postData = [
        'nft' => $_POST['nft'],
    ];

    $ref_table = "NFT";
    $postRef_result = $database->getReference($ref_table)->push($postData);

    if ($postRef_result->getKey()) {
        $_SESSION['success'] = "You have successfully added a pipe or NFT";
        header('Location: bay_nft');
    } else {
        $_SESSION['error'] = "Failed to add plant";
    }
}

if (isset($_POST['add-bay-btn'])) {
    $postData = [
        'bay' => $_POST['bay'],
        'placement' => $_POST['placement'],

    ];


    $ref_table = "BAY";
    $postRef_result = $database->getReference($ref_table)->push($postData);

    if ($postRef_result->getKey()) {
        $_SESSION['success'] = "Bay and Placement added successfully";
        header('Location: bay_nft');
    } else {
        $_SESSION['error'] = "Failed to add Bay and Placement";
    }
}


// CREATE DETAILS FOR PLANTS
if (isset($_POST['add-plant-details-btn'])) {
    $postData = [
        'plant_name' => $_POST['plant_name'],
        'ph_lvl_low' => $_POST['ph_lvl_low'],
        'ph_lvl_high' => $_POST['ph_lvl_high'],
        'days_harvest' => $_POST['days_harvest'],
    ];

    $ref_table = "plants_details";
    $postRef_result = $database->getReference($ref_table)->push($postData);

    if ($postRef_result->getKey()) {
        $_SESSION['success'] = "Plant Details added successfully";
        header('Location: plants_details');
    } else {
        $_SESSION['error'] = "Failed to add plant";
    }
}



// CREATE FUNCTION FOR PLANTS
if (isset($_POST['add-plant-btn'])) {
    $file_tmp = $_FILES['plant_photo']['tmp_name'];
    $file_name = $_FILES['plant_photo']['name'];
    $file_destination = "pics/" . $file_name;

    $uid = $_SESSION['verified_user_id'];

    // Fetch all users from Firebase Authentication
    $users = $auth->listUsers(); // This will return a UserRecords instance
    $user = $auth->getUser($uid);
    $Facilitator = $user->displayName;


    $timestamp = date('Y-m-d H:i:s');


    if (move_uploaded_file($file_tmp, $file_destination)) {
            // File uploaded successfully, update $postData
        $postData = [
            'plant_photo' => $file_destination,
            'plant_name' => $_POST['plant_name'],
            'ph_lvl_low' => $_POST['ph_lvl_low'],
            'ph_lvl_high' => $_POST['ph_lvl_high'],
            'bay' => $_POST['bay'],
            'nft' => $_POST['nft'],
            'date_planted' => $_POST['date_planted'],
            'date_harvest' => $_POST['date_harvest'],
            'plant_status' => 'Planted', // New plant status
        ];

        $ref_table = "plants";
        $postRef_result = $database->getReference($ref_table)->push($postData);

        $postData2 = [
            'plant_name' => $_POST['plant_name'],
            'ph_lvl_low' => $_POST['ph_lvl_low'],
            'ph_lvl_high' => $_POST['ph_lvl_high'],
            'bay' => $_POST['bay'],
            'nft' => $_POST['nft'],
            'date_planted' => $_POST['date_planted'],
            'Action' => 'Added', // New plant status
            'Facilitator' => $Facilitator,
        ];

        $ref_table2 = "activities";
        $postRef_result = $database->getReference($ref_table2)->push($postData2);

        if ($postRef_result->getKey() !== null) {
            $_SESSION['success'] = "Plant added successfully";
            header('Location: plants');
            exit(); // Make sure to exit after redirect
        } else {
            $_SESSION['error'] = "Failed to add plant";
        }
    } else {
        // Failed to upload file
        $_SESSION['error'] = "Failed to upload plant photo";
    }

    header('Location: plants');
    exit(); // Make sure to exit after redirect
}



if (isset($_POST['register-btn'])) {
    $full_name = $_POST['full-name'];
    // $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $selectedRole = $_POST['role_as']; // Get the selected role from the form

    // Check if the password and confirm password match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Password and Confirm Password do not match";
        header('Location: user');
        exit;
    }

    try {
        // Validate existing email
        $existingUser = $auth->getUserByEmail($email);
        if ($existingUser) {
            $_SESSION['error'] = "Email already exists";
            header('Location: user');
            exit;
        }
    } catch (Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        // User not found, continue with registration
    }

    try {
        // Validate existing phone number
        $existingUserByPhone = $auth->getUserByPhoneNumber('+91' . $phone);
        if ($existingUserByPhone) {
            $_SESSION['error'] = "Phone number already exists";
            header('Location: user');
            exit;
        }
    } catch (Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        // User not found, continue with registration
    }

    $userProperties = [
        'email' => $email,
        'emailVerified' => false,
        // 'phoneNumber' => '+91' . $phone,
        'password' => $password,
        'displayName' => $full_name,
    ];

    $createdUser = $auth->createUser($userProperties);

    if ($createdUser) {
        // Set custom user claims based on the selected role
        if ($selectedRole === 'admin') {
            $claims = ['admin' => true];
        } elseif ($selectedRole === 'gardener') {
            $claims = ['gardener' => true];
        } else {
            $claims = [];
        }

        // Set the custom claims
        $auth->setCustomUserClaims($createdUser->uid, $claims);

        $_SESSION['success'] = "User Created Successfully";
        header('Location: user');
    } else {
        $_SESSION['error'] = "User Failed to Create";
        header('Location: user');
    }
}

//UPDATE FUNCTION FOR USER

if (isset($_POST['update-user-btn'])) {
    $full_name = $_POST['full-name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $uid = $_POST['user_id'];
    $selectedRole = $_POST['role_as'];

    $properties = [
        'displayName' => $full_name,
        'email' => $email,
        'phoneNumber' => $phone,
    ];

    $updatedUser = $auth->updateUser($uid, $properties);

    if ($updatedUser) {
        // Set custom claims based on the selected role
        $claims = [];

        if ($selectedRole === 'admin') {
            $claims['admin'] = true;
        } elseif ($selectedRole === 'gardener') {
            $claims['gardener'] = true;
        } else {
            // Handle other roles or invalid selections here
        }

        // Set the custom claims
        $auth->setCustomUserClaims($uid, $claims);

        $_SESSION['success'] = "User Updated Successfully";
        header("Location: user");
        exit();
    } else {
        $_SESSION['error'] = "User Failed to Update";
        header("Location: user");
        exit();
    }
}

//USER STATUS UPDATE
if(isset($_POST['enable_disable_acc_btn']))
{
    $disable_enable = $_POST['select_enable_disable'];
    $uid = $_POST['enable_disable_id'];


    if($disable_enable == "disable")
    {
        $updatedUser = $auth->disableUser($uid);
        $msg = "Account Disabled";
    }
    else{
        $updatedUser = $auth->enableUser($uid);
        $msg = "Account Enabled";
    }

    if($updatedUser)
    {
        $_SESSION['success'] = $msg;
        header('Location: user-list');
        exit();
    }else{
        $_SESSION['error'] = "Something Went Wrong.";
        header('Location: user-list');
        exit();
    }
}

//UPDATE USER PROFILE

if(isset($_POST['update_user_profile']))
{
    $display_name = $_POST['display_name'];
    $email = $_POST['email']; // Added email field
    $profile = $_FILES['profile']['name'];
    $random_no = rand(1111,9999);

    $uid = $_SESSION['verified_user_id'];
    $user = $auth->getUser($uid);

    $new_image = $random_no . $profile;
    $old_image = $user->photoUrl;

    // Check if a new profile picture is uploaded
    if($profile != NULL)
    {
        $file_name = 'uploads/' . $new_image;

        // Move uploaded file to uploads directory
        move_uploaded_file($_FILES['profile']['tmp_name'], "uploads/" . $new_image);

        // Delete old profile picture if exists
        if($old_image != NULL)
        {
            unlink($old_image);
        }
    }
    else
    {
        // If no new profile picture uploaded, maintain the old one
        $file_name = $old_image;
    }

    $properties = [
        'displayName' => $display_name,
        'email' => $email, // Updated email field
        'photoUrl' => $file_name, // Update profile picture only if new one uploaded
    ];

    // Update user profile
    $updatedUser = $auth->updateUser($uid, $properties);

    if($updatedUser)
    {
        $_SESSION['success'] = "User Profile Updated Successfully";
        header('Location: my-profile');
        exit(0);
    }
    else
    {
        $_SESSION['error'] = "User Profile Failed to Update";
        header('Location: my-profile');
        exit(0);
    }
}

//CHANGE PASSWORD OF USER
if(isset($_POST['change_password_btn']))
{
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $retype_password = $_POST['retype_password'];
    $uid = $_POST['change_pwd_user_id'];

    // Authenticate the user with the old password
    try {
        $user = $auth->getUser($uid); // Get the user information

        $signInResult = $auth->signInWithEmailAndPassword($user->email, $old_password);

        // Old password is correct, proceed with changing the password
        if($new_password == $retype_password)
        {
            $updatedUser = $auth->changeUserPassword($uid, $new_password);
            if($updatedUser)
            {
                $_SESSION['success'] = "Password Updated Successfully";
                header('Location: change-password');
                exit();
            } else {
                $_SESSION['error'] = "Password Failed to Update";
                header('Location: change-password');
                exit();
            }
        } else {
            $_SESSION['error'] = "New Password and Re-Type Password do not match";
            header("Location: change-password");
            exit();
        }
    } catch (Exception $e) {
        // Old password is incorrect
        $_SESSION['error'] = "Old Password is incorrect";
        header("Location: change-password");
        exit();
    }
}

// Check if the password is submitted
if(isset($_POST['password'])) {
    $password = $_POST['password'];
    $uid = $_SESSION['verified_user_id'];

    try {
        // Retrieve the user's data from Firebase
        $user = $auth->getUser($uid);

        // Verify the entered password against the user's Firebase credentials
        $auth->signInWithEmailAndPassword($user->email, $password);

        // If no exception is thrown, the password is correct
        echo 'success';
        exit();
    } catch (\Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
        // Password is incorrect
        echo 'error';
        exit();
    } catch (\Exception $e) {
        // Other errors
        echo 'error';
        exit();
    }
}


?>