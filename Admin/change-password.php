<?php
include('admin_auth.php'); // Include the file that contains authorization logic
include('includes/header.php');
include('includes/navbar.php');
?>

<style>


    /* Kulay ng scrollbar */
    ::-webkit-scrollbar {
    width: 10px; /* lapad ng scrollbar */
    }

    /* Track ng scrollbar */
    ::-webkit-scrollbar-track {
    background: white; /* kulay ng track */
    }

    /* Handle ng scrollbar */
    ::-webkit-scrollbar-thumb {
    background: grey; /* kulay ng handle */
    border-radius: 5px; /* rounded edges ng handle */
    }

    /* Kung nais mo ng hover effect sa handle ng scrollbar */
    ::-webkit-scrollbar-thumb:hover {
    background: grey; /* kulay ng handle on hover */
    }

</style>


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

if(isset($_SESSION['success'])){
    echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '" . $_SESSION['success'] . "',
                confirmButtonText: 'Okay'
            });
        </script>
    ";
    unset($_SESSION['success']);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="font-size: 35px; font-weight: bold;">Change Password</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <?php
                        if(isset($_SESSION['verified_user_id'])) {
                            $uid = $_SESSION['verified_user_id'];
                        ?>
                            <form id="changePasswordForm" action="code.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="change_pwd_user_id" value="<?=$uid?>">
                                <div class="form-group mb-3">
                                    <label for="">Old Password</label>
                                    <input type="password" name="old_password" required class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" name="new_password" required class="form-control" id="newPassword">
                                    <span id="passwordLengthError" class="text-danger" style="display: none;">Password must be at least 8 characters long.</span>
                                    <span id="passwordNumberError" class="text-danger" style="display: none;">Password must contain at least one number.</span>
                                    <span id="passwordSpecialCharError" class="text-danger" style="display: none;">Password must contain at least one special character.</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Re-Type Password</label>
                                    <input type="password" name="retype_password" required class="form-control" id="retypePassword">
                                    <span id="retypePasswordError" class="text-danger" style="display: none;">Passwords do not match.</span>
                                    <span id="retypePasswordSuccess" class="text-success" style="display: none;">Passwords match.</span>
                                </div>
                                <div class="form-group mb-3 mt-5">
                                    <button type="submit" name="change_password_btn" class="btn btn btn-block" style="background-color: #3f51b5; color:white;">Change Password</button>
                                </div>
                            </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php
include('includes/footer.php');
?>

<script>
    // Function to validate password
    function validatePassword(password) {
        // Check if password is at least 8 characters long
        var lengthRegex = /.{8,}/;
        // Check if password contains at least one number
        var numberRegex = /\d/;
        // Check if password contains at least one special character
        var specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

        // Check all conditions
        var isLengthValid = lengthRegex.test(password);
        var containsNumber = numberRegex.test(password);
        var containsSpecialChar = specialCharRegex.test(password);

        return {
            valid: isLengthValid && containsNumber && containsSpecialChar,
            lengthValid: isLengthValid,
            numberValid: containsNumber,
            specialCharValid: containsSpecialChar
        };
    }

    // Function to handle input event on password field
    document.getElementById('newPassword').addEventListener('input', function() {
        var password = this.value;

        // Validate the password
        var validation = validatePassword(password);

        // Display error messages based on validation result
        document.getElementById('passwordLengthError').style.display = validation.lengthValid ? 'none' : 'inline';
        document.getElementById('passwordNumberError').style.display = validation.numberValid ? 'none' : 'inline';
        document.getElementById('passwordSpecialCharError').style.display = validation.specialCharValid ? 'none' : 'inline';
    });

    // Function to handle input event on retype password field
    document.getElementById('retypePassword').addEventListener('input', function() {
        var password = document.getElementById('newPassword').value;
        var retypePassword = this.value;

        // Check if passwords match
        var passwordsMatch = password === retypePassword;

        // Display success or error message based on match result
        document.getElementById('retypePasswordError').style.display = passwordsMatch ? 'none' : 'inline';
        document.getElementById('retypePasswordSuccess').style.display = passwordsMatch ? 'inline' : 'none';
    });

    // Function to validate the form before submission
    document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
        var password = document.getElementById('newPassword').value;
        var retypePassword = document.getElementById('retypePassword').value;

        // Validate new password
        var passwordValidation = validatePassword(password);
        var passwordsMatch = password === retypePassword;

        // Prevent form submission if validation fails
        if (!passwordValidation.valid || !passwordsMatch) {
            event.preventDefault();
            alert('Please correct the format in the form.');
        }
    });
</script>
