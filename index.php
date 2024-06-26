<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Water pH</title>
  <link rel="icon" type="logo" href="Admin/pics/logo.png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="Admin/plugins/fontawesome-free/css/all.min.css">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

<!-- Include SweetAlert CSS -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">

<!-- Include SweetAlert JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Using SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<link rel="stylesheet" href="style.css">


</head>

<body>
  <?php
if(isset($_SESSION['error'])){
    echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '" . $_SESSION['error'] . "',
                confirmButtonText: 'Okay'
            });
        </script>
    ";
    unset($_SESSION['error']);
}
?>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="bg/hydro.jpg" alt="">
        <div class="text">
        </div>
      </div>
    </div>
        <form name="myForm" action="logincode.php" onsubmit="return validateForm()" method="post" class="forms">
        <div class="form-content">
        <div class="login-form text-center"> <!-- Center align the content -->
        <img src="bg/v5_1541.png" class="logo mb-3" width="20%" height="20%" style="max-width: 200px;"> <!-- Apply margin bottom for spacing -->
        <div class="title">USER LOGIN</div>
          <form action="#">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
              </div>
              <div class="button input-box">
                <input type="submit" value="Log In" name="login-btn" id="submit">
              </div>
            </div>
        </form>
      </div>

    </div>
    </div>
    </div>
  </div>
</body>
</html>


<?php
include('includes/scripts.php');
?>