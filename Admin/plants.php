<?php
include('admin_auth.php');
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

        /* Adjust the position of the dropdown icon */
        .dropdown-icon,
    .search-icon {
        position: absolute;
        top: 50%;
        right: 10px; /* Adjust as needed */
        transform: translateY(-50%);
        pointer-events: none; /* Ensures the icons don't interfere with clicking or typing */
    }
        .dataTables_wrapper .dataTables_filter {
        display: none;
    }

    .form-control {
            min-width: 120px; /* Set a minimum width for the dropdown */
        }

    .table-responsive {
        overflow-y: auto; /* Add vertical scrollbar if necessary */
    }
        .dataTables_wrapper .dataTables_paginate {
        display: none;
    }


    .modal {
        background-color: rgba(0, 0, 0, 0.5); /* Baguhin ang opacity ng modal overlay */
    }

    .modal-content {
        background-color: white; /* I-set ang background color na puti */
    }

    .modal-backdrop {
        opacity: 0.5; /* Subukan baguhin ang opacity na ito sa mas mababang halaga */
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

<?php
// Fetch data for BAY
$bayRef = $database->getReference('BAY');
$bayData = $bayRef->getValue();

// Fetch data for NFT
$nftRef = $database->getReference('NFT');
$nftData = $nftRef->getValue();
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-7">
                <h1 class="m-0">Plants</h1>
            </div>
            <div class="col">
                <!-- Empty column for spacing -->
            </div>
            <div class="col-auto d-flex align-items-center">
                <div class="form-group mb-0 mr-2 position-relative" style="border-radius: 5px 0 0 5px; border-right: none;">
                    <select id="statusFilter" class="form-control form-control-sm" style="border-radius: 5px 0 0 5px; border-right: none; width: 100px;">
                        <option value="All">All</option>
                        <option value="Planted">Planted</option>
                        <option value="Harvested">Harvested</option>
                        <option value="Withered">Withered</option>
                    </select>
                    <div class="dropdown-icon">
                        <i class="fas fa-caret-down"></i> <!-- Icon for dropdown -->
                    </div>
                </div>
                <div class="form-group mb-0 mr-2 position-relative" style="border-radius: 0; border-left: none; margin-left: -10px;">
                        <div class="dataTables_filter" id="customSearch2" style="border-left: 1px solid #ced4da;">
                            <input type="search" class="form-control form-control-sm" placeholder="Search" aria-controls="myTable" style="width: 150px; border-radius: 0 5px 5px 0; margin-right: 5px; border-left: none;" id="plantSearch">
                            <div class="search-icon" style="font-size: 0.8rem;">
                                <i class="fas fa-search"></i> <!-- Icon for search -->
                            </div>
                        </div>
                    </div>
                    <h4 class="font-weight-bold text-white mb-0">
                                        <a href="#addplants" data-toggle="modal" class="btn btn" style="background-color: #2C3090 !important; color:white; height: 31px; font-size: 10px; line-height: 12px;">
                                            Add Plants
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

<div class="col-md-12">

<?php
if (isset($_SESSION['verified_user_id'])) {
    $currentUserId = $_SESSION['verified_user_id'];
}
?>

                    <!-- DataTales Example -->
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="table-responsive mt-2">
                                <table class="table table-lg" id="myTable" width="100%" cellspacing="0">
                                <thead>
                                        <tr>
                                            <th class="text-center" style="color:gray;">Plant Name</th>
                                            <th class="text-center" style="color:gray;">Bay Number</th>
                                            <th class="text-center" style="color:gray;">Placement</th>
                                            <th class="text-center" style="color:gray;">Status</th>
                                            <th class="text-center" style="color:gray;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        $ref_table = 'plants';
                                        $fetchdata = $database->getReference($ref_table)->getValue();

                                            if (!empty($fetchdata)) {
                                                $i = 1;
                                                foreach ($fetchdata as $key => $row) {
                                                    ?>
                                                    <tr class="text-center" data-id="<?= $key ?>">
                                                        <td class="text-bold"><?= $row['plant_name']; ?></td>
                                                        <td><?= $row['bay']; ?></td>
                                                        <td><?= $row['nft']; ?></td>
                                                        <td><?= $row['plant_status']; ?></td>

                                                        <td data-id="<?= $key ?>">
                                                            <a href="plant-info.php?id=<?= $key; ?>" class="btn btn-link" abbr title="view plant info" abbr id="abbr1" style="text-decoration: none;" onmouseover="this.querySelector('i').style.color='#2C3090';" onmouseout="this.querySelector('i').style.color='grey';"><i class="fa-solid fa-eye" style="color: grey;"></i></a>
                                                            <a href="report.php?id=<?= $key; ?>" class="btn btn-link" abbr title="create a report" abbr id="abbr2" style="text-decoration: none;" onmouseover="this.querySelector('i').style.color='#2C3090';" onmouseout="this.querySelector('i').style.color='grey';"><i class="fa-solid fa-clipboard" style="color: grey;"></i></a>

                                                            <?php
                                                            $claims = $auth->getUser($user->uid)->customClaims;

                                                            if (isset($claims['admin'])) {
                                                                ?>
                                                                <button type="button" class="btn btn-link delete-plant" abbr title="remove plant" abbr id="abbr3" style="text-decoration: none;" onmouseover="this.querySelector('i').style.color='red';" onmouseout="this.querySelector('i').style.color='grey';"><i class="fa-solid fa-trash" style="color: grey;"></i></button>
                                                                <?php
                                                                } else {
                                                                }
                                                                ?>
                                                                </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="9">No Record Found</td>
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

<?php
include('Modal/plant_modal.php');
include('includes/footer.php');
?>


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


<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>


<script>
    // Initialize Firebase with your own configuration
    var firebaseConfig = {
        apiKey: "AIzaSyAIjMwy9jr4Cr_cudDpn5A3RpxUpgL6jDw",
        authDomain: "ph-sensor-web-app.firebaseapp.com",
        databaseURL: "https://ph-sensor-web-app-default-rtdb.firebaseio.com",
        projectId: "ph-sensor-web-app",
        storageBucket: "ph-sensor-web-app.appspot.com",
        messagingSenderId: "385380264610",
        appId: "1:385380264610:web:fbac7afd889b8e8feb85fb",
        measurementId: "G-5JN9Y96ZM9"
        };


    firebase.initializeApp(firebaseConfig);

     // Function to fetch plant details based on the selected plant name
     function fetchPlantDetails(plantName) {
        var database = firebase.database();
        var ref = database.ref("plants_details");

        // Query to get details based on plant name
        ref.orderByChild("plant_name").equalTo(plantName).once("value", function (snapshot) {
            if (snapshot.exists()) {
                var plantDetails = snapshot.val();
                var phLevelLow = plantDetails[Object.keys(plantDetails)[0]].ph_lvl_low;
                var phLevelHigh = plantDetails[Object.keys(plantDetails)[0]].ph_lvl_high;
                var daysToHarvest = plantDetails[Object.keys(plantDetails)[0]].days_harvest;

                // Update the pH level input fields
                document.getElementById("ph_lvl_low").value = phLevelLow;
                document.getElementById("ph_lvl_high").value = phLevelHigh;

                // Calculate estimated harvest date
                updateEstimatedHarvestDate(daysToHarvest);
            }
        });
    }

    // Function to calculate estimated harvest date
    function updateEstimatedHarvestDate(daysToHarvest) {
        var datePlanted = document.getElementById("date_planted").value;

        if (datePlanted && daysToHarvest) {
            var datePlantedObj = new Date(datePlanted);
            var estimatedHarvestDate = new Date(datePlantedObj.setDate(datePlantedObj.getDate() + parseInt(daysToHarvest)));
            var formattedDate = estimatedHarvestDate.toISOString().split('T')[0];

            // Update the date_harvest input field
            document.getElementById("date_harvest").value = formattedDate;
        }
    }

    // Function to populate the plant names dropdown
    function populatePlantNames() {
        var database = firebase.database();
        var ref = database.ref("plants_details");

        ref.orderByChild("plant_name").once("value", function (snapshot) {
            if (snapshot.exists()) {
                var plantNamesDropdown = document.getElementById("plant_name");

                // Clear existing options
                plantNamesDropdown.innerHTML = "";

                // Populate dropdown with plant names
                snapshot.forEach(function (childSnapshot) {
                    var plantName = childSnapshot.val().plant_name;
                    var option = document.createElement("option");
                    option.value = plantName;
                    option.text = plantName;
                    plantNamesDropdown.appendChild(option);
                });
            }
        });
    }

    // Call the function to populate plant names on page load
    populatePlantNames();

    // Event listener for the plant name dropdown change
    document.getElementById("plant_name").addEventListener("change", function () {
        var selectedPlantName = this.value;
        fetchPlantDetails(selectedPlantName);
    });

    // Event listener for the date_planted input change
    document.getElementById("date_planted").addEventListener("change", function () {
        var selectedPlantName = document.getElementById("plant_name").value;
        fetchPlantDetails(selectedPlantName);
    });
</script>



<script>
            $(document).ready(function() {
                // Initialize DataTable with your table's ID
                var table = $('#myTable').DataTable();

                $(document).ready(function() {
            $('#plantSearch').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('#myTable tbody tr').each(function() {
                    var rowContainsSearchTerm = false;
                    $(this).find('td').each(function() {
                        var cellText = $(this).text().toLowerCase();
                        if (cellText.includes(searchTerm)) {
                            rowContainsSearchTerm = true;
                            return false; // Exit the loop early if a match is found in this row
                        }
                    });
                    if (rowContainsSearchTerm) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
        // Initial setup to hide "Estimated Date Harvested" column
        // Default value for the filter
        var defaultStatus = 'All';
        $('#statusFilter').val(defaultStatus);

        // Function to filter rows based on status
        function filterRowsByStatus(status) {
            $('#myTable tbody tr').hide(); // Hide all rows initially
            if (status === 'All') {
                $('#myTable tbody tr').show(); // Show all rows if 'All' is selected
            } else {
                $('#myTable tbody tr').each(function() {
                    var rowStatus = $(this).find('td:nth-child(4)').text().trim();
                    if (rowStatus === status) {
                        $(this).show();
                    }
                });
            }
        }

        // Trigger filtering based on default status
        filterRowsByStatus(defaultStatus);

        // Event handler for filter change
        $('#statusFilter').on('change', function() {
            var status = $(this).val();
            filterRowsByStatus(status);
        });
    });


</script>

<script>
$(document).ready(function() {
    // Initialize the modal
    $('#deleteplants').modal();

    // Handle Delete button click
    $('.delete-plant').click(function() {
        // Get the plant ID from the data attribute of the parent <tr> element
        var plantId = $(this).closest('tr').data('id'); // Changed to 'tr' instead of 'td'
        var plantName = $(this).closest('tr').find('td:eq(0)').text(); // Assuming plant name is in the first column

        // Use AJAX to fetch the data from Firebase using the plant ID
        $.ajax({
            url: 'plants_row.php',
            type: 'POST',
            data: { id: plantId },
            success: function(data) {
                // Parse the data (assuming it's in JSON format)
                var plantData = JSON.parse(data);

                // Populate the modal with the plant information
                $('#deleteplants').find('.plantid').val(plantId);

                $('#delete_plant_name').text(plantData.plant_name);

                // Show the modal
                $('#deleteplants').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error); // Log any errors to the console
            }
        });
    });

    // Event listener for NO button click
    $('#deleteplants .btn-secondary').click(function() {
        // Hide the modal when NO button is clicked
        $('#deleteplants').modal('hide');
    });
});
</script>
