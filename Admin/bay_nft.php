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


#searchInputmyTable {
        outline-color: #3f51b5;
    }
#searchInputmyTable2 {
        outline-color: #3f51b5;
    }
#searchInputmyTable:hover + button i {
        color: #3f51b5;
    }
#searchInputmyTable2:hover + button i {
        color: #3f51b5;
    }
@media (max-width: 576px) {
    .card-header {
        flex-direction: column;
        align-items: stretch;
    }

    .input-group {
        margin-bottom: 10px;
        max-width: none;
    }

    .search-box {
        margin-left: 0;
    }

    .search-box input {
        width: 100%;
    }

    .search-box button {
        position: relative;
        right: auto;
        top: auto;
        transform: none;
    }

    .btn {
        width: 100%;
    }
}
@media only screen and (max-width: 600px) {
    .card-header {
        flex-direction: column;
        align-items: stretch;
    }
    .input-group {
        margin-bottom: 10px;
        max-width: 100%;
    }
    .search-box {
        margin-left: 0;
    }
    #searchInputmyTable2 {
        max-width: 100%;
    }
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
                    <h1 class="m-0">Bay and Placement</h1>
                    <div class="col-sm-12">
                        <br>
                        <!-- DataTales Example for BAY Details -->
                        <div class="card shadow">

                            <div class="card-header d-flex justify-content-end align-items-center">
                                <div class="input-group mr-2" style="max-width: 200px; border-radius: 5px;">
                                    <div class="search-box" style="position: relative;">
                                        <input id="searchInputmyTable" type="text" placeholder="Search" style="border: 1px solid #8f8f8f; padding: 4px; border-radius: 5px; padding-right: 15px;">
                                        <button onclick="searchTable()" type="button" style="background-color: transparent; border: none; position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <h4 class="font-weight-bold text-primary mb-0">
                                    <a href="#addbay" data-toggle="modal" data-bs-toggle="modal" data-bs-target="#exampleModal1" class="btn" style="background-color: #3f51b5; color: white;">REGISTER</a>
                                </h4>
                            </div>



                            <div class="card-body">
                                <div class="table-responsive">
                                    <!-- BAY Details Table -->
                                    <table class="table" id="myTable" width="100%" cellspacing="0">
                                        <!-- Table Header -->
                                        <thead>
                                            <tr>
                                                <th class="text-center">Bay</th>
                                                <th class="text-center">Placement</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <!-- Table Body -->
                                        <tbody>
                                            <?php
                                            $ref_table = 'BAY';
                                            $fetchdata = $database->getReference($ref_table)->getValue();

                                            if ($fetchdata > 0) {
                                                $i = 1;
                                                foreach ($fetchdata as $key => $row) {
                                                    ?>
                                                    <tr class="text-center" data-id="<?= $key ?>">
                                                        <td><?= $row['bay']; ?></td>
                                                        <td><?= $row['placement']; ?></td>

                                                        <td>
                                                        <a class="btn btn-link edit-bay text-white mb-2" name="edit-bay" style="text-decoration: none;" onmouseover="this.querySelector('i').style.color='#3f51b5';" onmouseout="this.querySelector('i').style.color='grey';"><i class="fa-solid fa-pen" style="color: #8f8f8f;"></i></a>
                                                        <a class="btn btn-link delete-bay px-3 mb-2" name="delete-bay" style="text-decoration: none;" onmouseover="this.querySelector('i').style.color='red';" onmouseout="this.querySelector('i').style.color='grey';"><i class="fa-solid fa-trash" style="color: #8f8f8f;"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="3">No Record Found</td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div id="searchFeedbackmyTable" class="col-3 mt-2" style="display: none; color: red;">
                                     No matching results found.
                                 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>




    <?php
    include('Modal/nft_modal.php');
    include('Modal/bay_modal.php');
    include('includes/footer.php');
    ?>


<script>
  $(document).ready(function() {
    // Initialize the modal
    $('#editbay').modal();
    // Handle Edit button click
    $('.edit-bay').click(function() {
      // Get the NFT ID from the table row
      var bayId = $(this).closest('tr').data('id');

      // Use AJAX to fetch the data from Firebase using the NFT ID
      $.ajax({
        url: 'bay_row.php',
        type: 'POST',
        data: { id: bayId },
        success: function(data) {
          // Parse the data (assuming it's in JSON format)
          var bayData = JSON.parse(data);

          // Populate the modal with the retrieved data
          $('#editbay').find('.bayid').val(bayId);
          $('#editbay').find('#edit_bay').val(bayData.bay);
          $('#editbay').find('#edit_placement').val(bayData.placement);

          // Show the modal
          $('#editbay').modal('show');
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
  $('#deletebay').modal();

  // Handle Delete button click
  $('.delete-bay').click(function() {
    // Get the NFT ID from the table row
    var bayId = $(this).closest('tr').data('id');

    // Use AJAX to fetch the data from Firebase using the NFT ID
    $.ajax({
      url: 'bay_row.php',
      type: 'POST',
      data: { id: bayId },
      success: function(data) {
        // Parse the data (assuming it's in JSON format)
        var bayData = JSON.parse(data);

        // Populate the modal with the retrieved data
        $('#deletebay').find('.bayid').val(bayId);

        // Set the NFT name in the modal
        $('#delete_bay_name').text(bayData.bay);

        // Show the modal
        $('#deletebay').modal('show');
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
        $('#myTable2').DataTable();
    });
</script>


<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInputTable2 = document.getElementById('searchInputmyTable');
        const table2 = document.getElementById('myTable');
        const searchFeedbackTable2 = document.getElementById('searchFeedbackmyTable');

        searchInputTable2.addEventListener('input', function () {
            const searchTerm = searchInputTable2.value.toLowerCase();
            const rows = table2.querySelectorAll('tbody tr');
            let noMatches = true;

            rows.forEach(row => {
                const dataCells = row.querySelectorAll('td');
                let rowMatchesSearch = false;

                dataCells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        rowMatchesSearch = true;
                    }
                });

                if (rowMatchesSearch) {
                    row.style.display = '';
                    noMatches = false;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show or hide the "No matching results found" message
            if (noMatches) {
                searchFeedbackTable2.style.display = 'block';
            } else {
                searchFeedbackTable2.style.display = 'none';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInputTable3 = document.getElementById('searchInputmyTable2');
        const table3 = document.getElementById('myTable2'); // Changed table ID
        const searchFeedbackTable3 = document.getElementById('searchFeedbackmyTable2');

        searchInputTable3.addEventListener('input', function () {
            const searchTerm = searchInputTable3.value.toLowerCase();
            const rows = table3.querySelectorAll('tbody tr');
            let noMatches = true;

            rows.forEach(row => {
                const dataCells = row.querySelectorAll('td');
                let rowMatchesSearch = false;

                dataCells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        rowMatchesSearch = true;
                    }
                });

                if (rowMatchesSearch) {
                    row.style.display = '';
                    noMatches = false;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show or hide the "No matching results found" message
            if (noMatches) {
                searchFeedbackTable3.style.display = 'block';
            } else {
                searchFeedbackTable3.style.display = 'none';
            }
        });
    });
</script>
