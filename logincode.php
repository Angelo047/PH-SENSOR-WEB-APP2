<?php
session_start();
include('dbcon.php');

if(isset($_POST['login-btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $user = $auth->getUserByEmail("$email");

        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
        $idTokenString = $signInResult->idToken();

        $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        $uid = $verifiedIdToken->claims()->get('sub');

        $claims = $auth->getUser($uid)->customClaims;

        if(isset($claims['admin']) == true || isset($claims['gardener']) == true)  {
            $_SESSION['verified_admin'] = true;
            $_SESSION['verified_user_id'] = $uid;
            $_SESSION['idTokenString'] = $idTokenString;
        }
        header('Location: Admin/');
        exit();

    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        $_SESSION['error'] = "Invalid username or password. Please try again.";
        header('Location: ./');
        exit();
    } catch (FailedToVerifyToken $e) {
        echo 'The token is invalid: '.$e->getMessage();
    } catch(Exception $e) {
        $_SESSION['error'] = "Invalid username or password. Please try again.";
        header('Location: ./');
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid username or password. Please try again.";
    header('Location: ./');
    exit();
}
?>
