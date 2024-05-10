<?php
include('admin_auth.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<style>

@media print {
    body {
        background-color: white !important;
    }
}

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

  .table th {
    text-align: center;
}

.table-responsive {
    max-height: 600px; /* Set the max height of the container */
    overflow-y: auto; /* Enable vertical scrolling */
}

.table-responsive thead th {
    /* position: sticky; */
    top: 0;
    background-color: #fff; /* Set the background color of the header */
    z-index: 1; /* Ensure the header is above the table body */
}
#searchInputTable2 {
        outline-color: #3f51b5;
    }
#searchInputTable3 {
        outline-color: #3f51b5;
    }
#searchInputTable2:hover + button i {
        color: #3f51b5;
    }
#searchInputTable3:hover + button i {
        color: #3f51b5;
    }
@media only screen and (max-width: 600px) {
    .card-header {
        flex-direction: column;
    }
}

#outputButton1, #outputButton2 {
    margin-left: 10px;
    flex-shrink: 0; /* Prevent the buttons from shrinking */
}

</style>

<?php
// Fetch data for BAY
$bayRef = $database->getReference('plants_details');
$bayData = $bayRef->getValue();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Activities</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
                <div class="col-12">
                    <div class="card card-outline">
                       <div class="card-header" style="display: flex; justify-content: space-between;">
                        <h1 class="card-title" style="padding-top: 5px; margin: 0;">Stabilizing Water pH</h1>
                        <div class="search-box" style="position: relative; margin-left: auto;"> <!-- Added margin-left: auto; -->
                            <input id="searchInputTable2" type="text" placeholder="Search" style="border: 1px solid #8f8f8f; padding: 5px 10px; padding-right: 30px; border-radius: 5px; width: 100%;"> <!-- Added width and removed margin -->
                            <button onclick="searchTable()" type="button" style="background-color: transparent; border: none; position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button type="button" class="btn mt-2 mt-md-0 ml-md-2 pr-3" id="generateReportButton" onclick="generateReportModal()" style="background-color: #3f51b5; color: white;">
                                    Generate Report
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                   <div class="row mb-5">
                        <div class="col-sm-3">
                            <div class="form-group"> <!-- Added mb-0 class to remove margin bottom -->
                                <label for="fromDate" class="form-label">From:</label>
                                <input class="form-control" type="date" id="fromDate">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"> <!-- Added mb-0 class to remove margin bottom -->
                                <label for="toDate" class="form-label">To:</label>
                                <input class="form-control" type="date" id="toDate">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"> <!-- Added mb-0 class to remove margin bottom -->
                                <label for="statusFilter" class="form-label">Status:</label> <!-- Added form-label class -->
                                <select class="form-control" id="statusFilter">
                                    <option value="">All</option>
                                    <option value="Low">Low</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group"> <!-- Added mb-0 class to remove margin bottom -->
                                <label for="plantFilter" class="form-label">Plant Name:</label> <!-- Added form-label class -->
                                <select class="form-control" id="plantFilter">
                                    <option value="">All</option>
                                    <?php foreach ($bayData as $key => $row) {
                                        echo '<option value="' . $row['plant_name'] . '">' . $row['plant_name'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="card-body table-responsive">
                        <table class="table" id="example1">
                            <!-- Table headers -->
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Facilitator</th>
                                    <th class="text-center">Time & Date</th>
                                    <th class="text-center">PH Level</th>
                                    <th class="text-center">Plant Name</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody>
                                <?php
                                $ref_table = 'notifications';
                                $fetchdata = $database->getReference($ref_table)->getValue();
                                if (!empty($fetchdata)) {
                                    $i = 1;
                                    foreach ($fetchdata as $row) {
                                        ?>
                                        <tr class="text-center">
                                            <td><?= $i++; ?></td>
                                            <td><?= !empty($row['Facilitator']) ? $row['Facilitator'] : ''; ?></td>
                                            <td><?= !empty($row['current_date']) ? $row['current_date'] : ''; ?></td>
                                            <td><?= !empty($row['ph_lvl']) ? $row['ph_lvl'] : ''; ?></td>
                                            <td><?= !empty($row['plant_name']) ? $row['plant_name'] : ''; ?></td>
                                            <td><?= !empty($row['status']) ? $row['status'] : ''; ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6">No Record Found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <div id="searchFeedbackTable2" class="col-3 mt-2" style="display: none; color: red;">
                           No matching results found.
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Second table for Plants -->
<!-- <section class="content">
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-outline">

                 <div class="card-header" style="display: flex; justify-content: space-between;">
                    <h1 class="card-title" style="padding-top: 5px; margin: 0;">Planting Details</h1>
                    <div class="search-box" style="position: relative; margin-left: auto;">

                        <input id="searchInputTable3" type="text" placeholder="Search" style="border: 1px solid #8f8f8f; padding: 5px 10px; padding-right: 30px; border-radius: 5px; width: 100%;">
                        <button onclick="searchTable()" type="button" style="background-color: transparent; border: none; position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                        <button type="button" class="btn btn-primary mr-2" id="outputButton1" onclick="window.location.href = 'act_report2.php';">
                            <i class="fas fa-save"></i> GENERATE OUTPUT
                        </button>
                </div>

                    <div class="card-body table-responsive">
                        <table class="table" id="myTable3">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Plant Name</th>
                                    <th class="text-center">Date Planted</th>
                                    <th class="text-center">Bay</th>
                                    <th class="text-center">Placement</th>
                                    <th class="text-center">Water pH Level Range</th>
                                    <th class="text-center">Facilitator</th>
                                    <th class="text-center">Status</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ref_table = 'activities';
                                $fetchdata = $database->getReference($ref_table)->getValue();
                                if (!empty($fetchdata)) {
                                    $i = 1;
                                    foreach ($fetchdata as $row) {
                                        ?>
                                          <tr class="text-center">
                                            <td><?= $i++; ?></td>
                                            <td><?= !empty($row['plant_name']) ? $row['plant_name'] : ''; ?></td>
                                            <td><?= date('M d, Y', strtotime($row['date_planted'])); ?></td>
                                            <td><?= !empty($row['bay']) ? $row['bay'] : ''; ?></td>
                                            <td><?= !empty($row['nft']) ? $row['nft'] : ''; ?></td>
                                            <td><?= !empty($row['ph_lvl_low']) && !empty($row['ph_lvl_high']) ? $row['ph_lvl_low'] . ' - ' . $row['ph_lvl_high'] : ''; ?></td>
                                            <td><?= !empty($row['Facilitator']) ? $row['Facilitator'] : ''; ?></td>
                                            <td><?= !empty($row['Action']) ? $row['Action'] : ''; ?></td>
                                        </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="8">No Record Found</td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div id="searchFeedbackTable3" class="col-3 mt-2" style="display: none; color: red;">
                                     No matching results found.
                                 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

</section> -->
</div>




<?php
include('includes/footer.php');
include('Modal/activities_modal.php');

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
// Function to calculate the mean of an array of numbers
function calculateMean(numbers) {
    var sum = numbers.reduce((a, b) => a + b, 0);
    return sum / numbers.length;
}

// Function to calculate the median of an array of numbers
function calculateMedian(numbers) {
    var sorted = numbers.slice().sort((a, b) => a - b);
    var middle = Math.floor(sorted.length / 2);
    if (sorted.length % 2 === 0) {
        return (sorted[middle - 1] + sorted[middle]) / 2;
    } else {
        return sorted[middle];
    }
}

// Function to generate report
// Function to generate report
function generateReportModal() {
    var table = document.getElementById('example1');

    var phLevels = [];
    var rowCount = 0;
    var lowStatusCount = 0;
    var highStatusCount = 0;
    var highPhPlantsCount = 0;
    var lowPhPlantsCount = 0;
    var highPhPlants = [];
    var lowPhPlants = [];

    // Initialize the report content
    var reportContent = '';

    for (var i = 1; i < table.rows.length; i++) {
        var row = table.rows[i];
        if (row.style.display !== 'none') {
            rowCount++;
            reportContent += '<tr>';
            for (var j = 0; j < row.cells.length; j++) {
                if (j === 3) {
                    var phLevel = parseFloat(row.cells[j].innerText);
                    phLevels.push(phLevel);
                    if (phLevel > 7.5) {
                        highPhPlantsCount++;
                        var plantName = row.cells[j + 1].innerText.trim();
                        if (!highPhPlants.includes(plantName)) {
                            highPhPlants.push(plantName);
                        }
                    } else if (phLevel < 6.5) {
                        lowPhPlantsCount++;
                        var plantName = row.cells[j + 1].innerText.trim();
                        if (!lowPhPlants.includes(plantName)) {
                            lowPhPlants.push(plantName);
                        }
                    }
                } else if (j === 5) {
                    var status = row.cells[j].innerText.trim();
                    if (status === "Low") {
                        lowStatusCount++;
                    } else if (status === "High") {
                        highStatusCount++;
                    }
                }

            }

        }
    }



    // Calculate statistics
    var meanPH = calculateMean(phLevels);
    var medianPH = calculateMedian(phLevels);
    var minPH = Math.min(...phLevels);
    var maxPH = Math.max(...phLevels);

    // Format meanPH to two decimal places
    var meanPHFormatted = meanPH.toFixed(1);

    // Get the filter criteria values
    var fromDate = document.getElementById('fromDate').value || 'All';
    var toDate = document.getElementById('toDate').value || 'All';
    var statusFilter = document.getElementById('statusFilter').value || 'All';
    var plantFilter = document.getElementById('plantFilter').value || 'All';

    // Populate the filter criteria in the modal
    document.getElementById('fromDateHolder').innerText = fromDate;
    document.getElementById('toDateHolder').innerText = toDate;
    document.getElementById('statusFilterHolder').innerText = statusFilter;
    document.getElementById('plantFilterHolder').innerText = plantFilter;

    // Display the report content in the modal body
    if (rowCount > 0) {
        // Populate the statistics in the modal
        document.getElementById('meanPH').innerText = meanPHFormatted;
        document.getElementById('medianPH').innerText = medianPH;
        document.getElementById('minPH').innerText = minPH;
        document.getElementById('maxPH').innerText = maxPH;

        // Populate the frequency counts
        document.getElementById('numLogged').innerText = rowCount;
        document.getElementById('LowStatus').innerText = lowStatusCount;
        document.getElementById('HighStatus').innerText = highStatusCount;

        // Populate plant-specific analysis
        document.getElementById('highPHPlants').innerText = highPhPlantsCount;
        document.getElementById('highPHPlantsDetails').innerText = highPhPlants.join(', ');
        document.getElementById('lowPHPlants').innerText = lowPhPlantsCount;
        document.getElementById('lowPHPlantsDetails').innerText = lowPhPlants.join(', ');

        // Calculate percentages
        var totalActivities = lowStatusCount + highStatusCount;
        var lowPhPercentage = (lowStatusCount / totalActivities) * 100;
        var highPhPercentage = (highStatusCount / totalActivities) * 100;

        // Display percentages
        document.getElementById('lowpHstat').innerText = lowPhPercentage.toFixed(2) + '%';
        document.getElementById('highpHstat').innerText = highPhPercentage.toFixed(2) + '%';


        // Populate the report content
        document.getElementById('reportModalBody').innerHTML = reportContent;

        // Show the modal
        $('#reportModal').modal('show');
    } else {
        alert('No data to generate report.');
    }
}

// Attach click event listener to the "Generate Report" button
document.getElementById('generateReportButton').addEventListener('click', generateReportModal);

// Function to populate filter criteria
function populateFilterCriteria() {
    // Get the selected filter values
    var fromDate = document.getElementById('fromDate').value;
    var toDate = document.getElementById('toDate').value;
    var statusFilter = document.getElementById('statusFilter').value;
    var plantFilter = document.getElementById('plantFilter').value;

    // Populate the filter criteria in the modal
    document.getElementById('filterCriteria').innerText = `From: ${fromDate}, To: ${toDate}, Status: ${statusFilter}, Plants: ${plantFilter}`;
}

// Attach change event listeners to the filter elements
document.getElementById('fromDate').addEventListener('change', populateFilterCriteria);
document.getElementById('toDate').addEventListener('change', populateFilterCriteria);
document.getElementById('statusFilter').addEventListener('change', populateFilterCriteria);
document.getElementById('plantFilter').addEventListener('change', populateFilterCriteria);
</script>



<script>
    $(document).ready(function() {
        $('#example1').DataTable();
    });
</script>


<script>
    // Add event listeners to the date filter, status filter, and plant filter
    document.getElementById('statusFilter').addEventListener('change', filterTable);
    document.getElementById('plantFilter').addEventListener('change', filterTable);
    document.getElementById('fromDate').addEventListener('change', filterTable);
    document.getElementById('toDate').addEventListener('change', filterTable);

    // Function to parse date strings in the format "11:01 AM, 04/25/2024" into Date objects
    function parseDate(dateString) {
        const parts = dateString.split(', ');
        const datePart = parts[1];
        return new Date(datePart);
    }

    // Function to filter the table based on date, status, and plant name
    function filterTable() {
        const statusFilterValue = document.getElementById('statusFilter').value.toUpperCase();
        const plantFilterValue = document.getElementById('plantFilter').value;
        const fromDateValue = new Date(document.getElementById('fromDate').value);
        const toDateValue = new Date(document.getElementById('toDate').value);
        const rows = document.getElementById('example1').querySelectorAll('tbody tr');

        rows.forEach(row => {
            const dateCellValue = parseDate(row.cells[2].textContent); // Get the date cell value
            const statusCellValue = row.cells[5].textContent.toUpperCase(); // Get the status cell value
            const plantCellValue = row.cells[4].textContent; // Get the plant name cell value

            // Check if the row should be displayed based on date, status, and plant name filters
            const dateMatch = isNaN(fromDateValue.getTime()) || isNaN(toDateValue.getTime()) || (dateCellValue >= fromDateValue && dateCellValue <= toDateValue);
            const statusMatch = statusFilterValue === '' || statusCellValue === statusFilterValue;
            const plantMatch = plantFilterValue === '' || plantCellValue === plantFilterValue;

            // Toggle row display based on filters
            row.style.display = dateMatch && statusMatch && plantMatch ? 'table-row' : 'none';
        });

        // Show feedback if no matching results found
        const feedback = document.getElementById('searchFeedbackTable2');
        const noResults = Array.from(rows).every(row => row.style.display === 'none');
        feedback.style.display = noResults ? 'block' : 'none';
    }
</script>

