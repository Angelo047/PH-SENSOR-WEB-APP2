
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
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0">Plant Details</h1>
            </div>
            <div class="col-sm-6 d-flex justify-content-end align-items-center">
                <div class="input-group mr-3" style="width: 200px;">
                    <input type="text" class="form-control" id="search_user" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <h4 class="font-weight-bold text-primary mb-0">
                    <a href="#addplantsdetails" data-toggle="modal" data-bs-toggle="modal" data-bs-target="#exampleModal1" class="btn btn" style="background-color: #3f51b5; color:white;"> &nbsp;REGISTER</a></h4>

                </h4>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12">
        <!-- DataTales Example -->
        <div class="card shadow">
        <div class="card-body">

        <div class="table-responsive" style="overflow-y: auto;">
                <table class="table table-lg" id="myTable4" width="100%" cellspacing="0">

                <thead class="bg-light sticky-top top-0">
                  <tr>
                            <th class="text-center">Plants Name</th>
                            <th class="text-center">Lowest pH Level</th>
                            <th class="text-center">Highest pH Level</th>
                            <th class="text-center">Days Before Harvest</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ref_table = 'plants_details';
                        $fetchdata = $database->getReference($ref_table)->getValue();

                        if (!empty($fetchdata)) {
                            $i = 1;
                            foreach ($fetchdata as $key => $row) {
                        ?>
                                <tr class="text-center" data-id="<?= $key ?>">

                                    <td class="text-bold"><?= $row['plant_name']; ?></td>
                                    <td><?= $row['ph_lvl_low']; ?></td>
                                    <td><?= $row['ph_lvl_high']; ?></td>
                                    <td><?= $row['days_harvest']; ?></td>
                                    <td>

                                    <a class="btn btn-link edit-plant" style="text-decoration: none;" onmouseover="this.querySelector('i').style.color='#3f51b5';" onmouseout="this.querySelector('i').style.color='grey';"><i class="fa-solid fa-pen" style="color: grey;"></i></a>

                                    <a class="btn btn-link delete-plant" style="text-decoration: none;" onmouseover="this.querySelector('i').style.color='red';" onmouseout="this.querySelector('i').style.color='grey';"><i class="fa-solid fa-trash" style="color: grey;"></i></a>

                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr id="noDataMessage" class="text-center">
                             <div id="noDataMessage" class="alert alert-info" style="display: none;">No data entries.</div>
                                </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
include('Modal/plants_details_modal.php');
include('includes/footer.php');
?>




<script>
  $(document).ready(function() {
    // Initialize the modal
    $('#editplant').modal();

    // Handle Edit button click
    $('.edit-plant').click(function() {
      // Get the NFT ID from the table row
      var plantId = $(this).closest('tr').data('id');

      // Use AJAX to fetch the data from Firebase using the NFT ID
      $.ajax({
        url: 'plant_details_row.php',
        type: 'POST',
        data: { id: plantId },
        success: function(data) {
          // Parse the data (assuming it's in JSON format)
          var plantData = JSON.parse(data);

          // Populate the modal with the retrieved data
          $('#editplant').find('.plantid').val(plantId);
          $('#editplant').find('#plant_name').val(plantData.plant_name);
          $('#editplant').find('#ph_lvl_high').val(plantData.ph_lvl_high);
          $('#editplant').find('#ph_lvl_low').val(plantData.ph_lvl_low);
          $('#editplant').find('#days_harvest').val(plantData.days_harvest);


          // Show the modal
          $('#editplant').modal('show');
        },
        error: function(error) {
          console.log('Error fetching data: ', error);
        }
      });
    });
  });
</script>



<script>
$(document).ready(function() {
  // Initialize the modal
  $('#deleteplant').modal();

  // Handle Delete button click
  $('.delete-plant').click(function() {
    // Get the NFT ID from the table row
    var plantId = $(this).closest('tr').data('id');
    var userName = $(this).closest('tr').find('td:eq(1)').text(); // Assuming display name is in the second column


    // Use AJAX to fetch the data from Firebase using the NFT ID
    $.ajax({
      url: 'plant_details_row.php',
      type: 'POST',
      data: { id: plantId},
      success: function(data) {
        // Parse the data (assuming it's in JSON format)
        var plantData = JSON.parse(data);

        // Populate the modal with the retrieved data
        $('#deleteplant').find('.plantid').val(plantId);

        // Set the NFT name in the modal
        $('#delete_plant_name').text(plantData.plant_name);

        // Show the modal
        $('#deleteplant').modal('show');
      },
      error: function(error) {
        console.log('Error fetching data: ', error);
      }
    });
  });
});

</script>


<script>
    $(document).ready(function() {
        $('#myTable4').DataTable();
    });
</script>


<script>
  function displayImagePreview() {
    var input = document.getElementById('plant_photo');
    var img = document.getElementById('profile-pic');
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        img.src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      img.src = 'pics/default.png';
    }
  }

  function updatePlantImage() {
    // Add any additional logic here if needed
  }
</script>

<script>
$(document).ready(function() {

    $('#search_user').on('input', function() {
        var searchTerm = $(this).val();
        filterUsersBySearch(searchTerm);
    });

    function filterUsersBySearch(searchTerm) {
        $('#myTable4 tbody tr').each(function() {
            var displayName = $(this).find('td:nth-child(1)').text().trim(); // Assuming display name is in the 1st column
            var phoneNumber = $(this).find('td:nth-child(2)').text().trim(); // Assuming phone number is in the 2nd column
            var email = $(this).find('td:nth-child(3)').text().trim(); // Assuming email is in the 3rd column
            var role = $(this).find('td:nth-child(4)').text().trim(); // Assuming role is in the 4th column

            if (displayName.includes(searchTerm) || phoneNumber.includes(searchTerm) || email.includes(searchTerm) || role.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }

        });
    }
    if (!found) {
        $('#noDataMessage').show();
      } else {
        $('#noDataMessage').hide();
      }
    });

</script>