<?php
session_start();

unset($_SESSION['verified_user_id']);
unset($_SESSION['idTokenString']);

if(isset($_SESSION['verified_admin']))
{
    unset($_SESSION['verified_admin']);
    // $_SESSION['success'] = "Logout Successfully";
}
elseif(isset($_SESSION['verified_gardener']))
{
    unset($_SESSION['verified_gardener']);
    // $_SESSION['success'] = "Logout Successfully";
}


if(isset($_SESSION['expiry_status']))
{
    $_SESSION['error'] = "Session Expired";
}
else{
    // $_SESSION['error'] = "Logout Successfully";
}
header('Location: ./');
exit();

?>