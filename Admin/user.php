<?php
include('admin_auth.php');

// Redirect unauthorized users to another page
$uid = $verifiedIdToken->claims()->get('sub');
$claims = $auth->getUser($uid)->customClaims;
if(isset($claims['admin']) == false)  {
    header('Location: ./');
    exit();
}

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


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

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

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row row-cols-auto">
            <div class="col-sm-7">
                <h1 class="m-0">Manage Users</h1>
            </div>
            <div class="col">

            </div>

            <div class="row">
    <div class="col">



    <div class="form-group" style="padding-left: 40px; width: 200px;">

    <select id="role-filter" class="form-control" style="width: 130px; margin-left: 60px;">
        <option value="">All Roles </option>
        <option value="Admin">Admin</option>
        <option value="Gardener">Gardener</option>
        <!-- Add more role options as needed -->
    </select>
    <i class="fas fa-caret-down" style="position: absolute; top: 35%; right: 5px; transform: translateY(-50%);"></i>
</div>



    </div>

    <div class="col">
        <div class="form-group">
            <input type="text" class="form-control" id="search_user" placeholder="Search">
        </div>
    </div>
</div>
    <div class="col">
        <h4 class="font-weight-bold text-primary">
            <a href="#addnew" data-toggle="modal" class="btn btn" style="background-color: #3f51b5; color:white;"> &nbsp;
                ADD USER
            </a>
        </h4>
    </div>
</div>
        </div>
        </div>

        <div class="col-md-12">
        <!-- DataTales Example -->
        <div class="card shadow">
        <div class="card-body">

            <!-- DataTales Example -->

        <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">

                <table class="table table-lg" id="myTable" width="100%" cellspacing="0">


                        <thead class="sticky-top top-0">
                            <tr>
                                <th class="text-center">Users</th>
                                <!-- <th class="text-center">Phone Number</th> -->
                                <th class="text-center">Email</th>
                                <th class="text-center">Roles</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>

                        </thead>
                        <tbody>
                        <?php
                                    if (isset($_SESSION['verified_user_id'])) {
                                        $currentUserId = $_SESSION['verified_user_id'];
                                    }

                                    $users = $auth->listUsers();
                                    $i = 1;
                                    foreach ($users as $user) {
                                        // Skip the current user
                                        if (isset($currentUserId) && $user->uid === $currentUserId) {
                                            continue;
                                        }
                                    ?>
                                    <tr class="text-center">
                                        <td class="text-bold"><?= $user->displayName; ?></td>
                                        <td><?= $user->email; ?></td>
                                        <td>
                                            <?php
                                            $claims = $auth->getUser($user->uid)->customClaims;

                                            if (isset($claims['admin'])) {
                                                echo 'Admin';
                                            } elseif (isset($claims['gardener'])) {
                                                echo 'Staff';
                                            } else {
                                                echo "Staff";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($user->disabled) {
                                                echo '<span class="badge bg-danger">Disabled</span>';
                                            } else {
                                                echo '<span class="">Active</span>';
                                            }
                                            ?>
                                        </td>
                                    <td>
                                        <a href="#" class="btn btn-link edit-user mb-2" data-id="<?= $user->uid ?>"><i class="fa-solid fa-pen" style="color: #3f51b5;"></i></a>
                                        <a href="#" class="btn btn-link delete-user mb-2" data-id="<?= $user->uid ?>"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                        <tr id="noDataMessage" style="display: none;">
                        <td colspan="6" class="text-center">No Record Found</td>
                    </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>



<?php
include('Modal/user_modal.php');
include('includes/footer.php');
?>

<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var password = document.getElementById("password");
    var confirm_password = document.getElementById("confirm_password");

    function validatePassword() {
        if (password.value !== confirm_password.value) {
            confirm_password.setCustomValidity("Passwords do not match");
        } else {
            confirm_password.setCustomValidity("");
        }
    }

    password.addEventListener("change", validatePassword);
    confirm_password.addEventListener("keyup", validatePassword);
});
</script>

<script>
    function confirmDelete(userId) {
        // Set the userId to be deleted in a hidden input field
        document.getElementById('userIdToDelete').value = userId;

        // Display SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If user clicks "Yes," submit the form
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>


<script>
    // Password validation function
    function validatePassword(password) {
        var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return pattern.test(password);
    }

    // Function to check if password and confirm password match
    function passwordsMatch(password, confirm_password) {
        return password === confirm_password;
    }

    // Function to handle password validation
    function validateForm() {
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;
        var password_error = document.getElementById("password_error");
        var retypePasswordError = document.getElementById("retypePasswordError");
        var retypePasswordSuccess = document.getElementById("retypePasswordSuccess");

        // Validate password
        if (!validatePassword(password)) {
            password_error.innerHTML = "Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one digit, and one special character.";
            return false;
        }

        // Check if password and confirm password match
        if (!passwordsMatch(password, confirm_password)) {
            retypePasswordError.style.display = "block";
            retypePasswordSuccess.style.display = "none";
            return false;
        } else {
            retypePasswordError.style.display = "none";
            retypePasswordSuccess.style.display = "block";
        }

        // If validation passed, clear error message
        password_error.innerHTML = "";
        return true;
    }

    // Add event listener to form submission
    document.getElementById("myForm").addEventListener("submit", function(event) {
        // Prevent form submission if validation fails
        if (!validateForm()) {
            event.preventDefault();
        }
    });
</script>


<script>
$(document).ready(function() {
    // Handle Delete button click
    $('.delete-user').click(function() {
        var userId = $(this).data('id');
        var userName = $(this).closest('tr').find('td:eq(0)').text(); // Assuming display name is in the second column

        // Populate the modal with user data
        $('#deleteuser').find('.userId').val(userId);
        $('#deleteUserName').text(userName);

        // Show the modal
        $('#deleteuser').modal('show');
    });

    // Handle form submission for user deletion
    $('#deleteUserForm').submit(function(event) {
        event.preventDefault();
        var userId = $('.userId').val();

        // Prompt confirmation using SweetAlert
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the user.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc4c64',
            cancelButtonColor: '#3b71ca',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                 // Add loading animation
                 Swal.fire({
                        title: 'Deleting...',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        onOpen: () => {
                            Swal.showLoading();
                        }
                    });
                // If confirmed, call function to delete the user
                deleteUser(userId);
            }
        });
    });

    // Function to delete user
    function deleteUser(userId) {
        // Perform AJAX request to delete the user
        $.ajax({
            url: 'code.php', // Change this to the actual endpoint for deleting users
            type: 'POST',
            data: { userId: userId },
            success: function(response) {
                // Redirect to user.php after deletion
                window.location.href = "user.php";
            },
            error: function(xhr, status, error) {
                // Show error message
                console.error('Error deleting user:', status, error);
            }
        });
    }
});
</script>

<script>
    $(document).ready(function() {
        // Initialize the modal
        $('#edituser').modal();

        $('.edit-user').click(function() {
            // Get the User ID from the button data attribute
            var userId = $(this).data('id');

            // Populate the modal with user data
            $('#edituser').find('.userId').val(userId);

            // Use AJAX to fetch the data from Firebase using the User ID
            $.ajax({
                url: 'user_details_row.php',
                type: 'POST',
                data: { id: userId },
                success: function(data) {
                    // Parse the data (assuming it's in JSON format)
                    var userData = JSON.parse(data);

                    // Populate the modal with the retrieved data
                    $('#edituser').find('.userid').val(userId);
                    $('#edituser').find('input[name="full-name"]').val(userData.displayName);
                    $('#edituser').find('input[name="email"]').val(userData.email);
                    $('#edituser').find('input[name="phone"]').val(userData.phoneNumber);
                    $('#edituser').find('select[name="role_as"]').val(userData.claims.admin ? 'admin' : 'gardener');
                    $('#edituser').find('select[name="status"]').val(userData.disabled ? 'true' : 'false');


                    // Show the modal
                    $('#edituser').modal('show');
                },
                error: function(error) {
                    console.log('Error fetching data: ', error);
                }
            });
        });

        // Handle form submission for user details update
        $('#editUserForm').submit(function(event) {
            event.preventDefault();
            var userId = $('.userId').val();
            // Serialize the form data
            var formData = $(this).serialize() + '&edit-user-details-btn=1'; // Add edit-user-details-btn to the serialized data

            // Prompt confirmation using SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to Edit the User.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b71ca',
                cancelButtonColor: '#dc4c64',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Add loading animation
                    Swal.fire({
                        title: 'Updating...',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        onOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // If confirmed, call function to update the user
                    updateUser(userId, formData);
                }
            });
        });

        function updateUser(userId, formData) {
            // Submit the form via AJAX
            $.ajax({
                url: 'code.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle success response
                    // Refresh the page or update the table with the updated data
                    location.reload(); // Reload the page for demonstration
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error updating user details:', status, error);
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Initialize the data table
        var table = $('#myTable').DataTable();

        // Event handler for editing user
        $('#myTable').on('click', '.edit-user', function() {
            var userId = $(this).data('id');
            // Populate modal and show it
            // Example: $('#edituser').modal('show');
        });

        // Event handler for deleting user
        $('#myTable').on('click', '.delete-user', function() {
            var userId = $(this).data('id');
            // Perform delete operation or show confirmation modal
        });
    });
</script>

<script>
$(document).ready(function() {
    $('#search_user').on('input', function() {
        var searchTerm = $(this).val();
        filterUsersBySearch(searchTerm);
    });

    function filterUsersBySearch(searchTerm) {
        var found = false; // Flag para sa pagtukoy kung may resulta o wala
        $('#myTable tbody tr').each(function() {
            var displayName = $(this).find('td:nth-child(1)').text().trim(); // Assuming display name is in the 1st column
            var phoneNumber = $(this).find('td:nth-child(2)').text().trim(); // Assuming phone number is in the 2nd column
            var email = $(this).find('td:nth-child(3)').text().trim(); // Assuming email is in the 3rd column
            var role = $(this).find('td:nth-child(4)').text().trim(); // Assuming role is in the 4th column


            if (displayName.includes(searchTerm) || phoneNumber.includes(searchTerm) || email.includes(searchTerm) || role.includes(searchTerm)) {
                $(this).show();
                found = true;
            } else {
                $(this).hide();
            }
        });


        if (!found) {
            $('#noDataMessage').show();
        } else {
            $('#noDataMessage').hide();
        }
    }
});
</script>


<script>
$(document).ready(function() {
    // Add event listener to the dropdown
    $('#user_role').change(function() {
        var selectedRole = $(this).val(); // Get the selected option value
        var selectedRole = $(this).val(); // Get the selected option value
        var selectedRole = $(this).val(); // Get the selected option value

        // Filter table r       ows based on the selected option value
        $('#myTable tbody tr').each(function() {
            var role = $(this).find('td:nth-child(4)').text().trim(); // Assuming role is in the 4th column
            if (selectedRole === 'all') {
                $(this).show(); // Show all rows if "All Roles" is selected
            } else if (role === selectedRole) {
                $(this).show(); // Show rows with the selected role
            } else {
                $(this).hide(); // Hide rows with other roles
            }
        });
    });

    // Rest of your code...
});
</script>

<script>
    // JavaScript to filter table based on selected role
    $(document).ready(function() {
        $('#role-filter').change(function() {
            var selectedRole = $(this).val().toLowerCase();
            if (selectedRole === '') {
                // Show all rows if no role is selected
                $('#myTable tbody tr').show();
            } else {
                // Hide rows that do not match the selected role
                $('#myTable tbody tr').each(function() {
                    var rowRole = $(this).find('td:eq(3)').text().trim().toLowerCase(); // Assuming role is in the fourth column
                    if (rowRole === selectedRole) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
    });
</script>