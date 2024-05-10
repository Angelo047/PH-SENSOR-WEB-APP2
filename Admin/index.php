<?php
include('admin_auth.php'); // Include the file that contains authorization logic
include('includes/header.php');
include('includes/navbar.php');
?>

<head>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>
<style>


.textfont {
    font-weight: bold;
}

.fi fi-rr-user {
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
    display: var(--fa-display, inline-block);
    font-style: normal;
    font-variant: normal;
    line-height: 1;
    text-rendering: auto;
}
*, *::before, *::after {
    box-sizing: border-box;
}

  .dropdown-icon-container {
        position: relative;
        display: inline-block;
    }

    .dropdown-icon-container select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #fff;
        border: 1px solid #ced4da;
        padding: 8px 30px 8px 10px; /* Adjust padding as needed */
        font-size: 16px;
        border-radius: 4px;
    }

    .dropdown-icon-container i {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        color: #333; /* Adjust icon color as needed */
    }
    .count
    {
        padding-left: 35px;
        color: #ffffff;
        padding-top: 10px;

    }



        .spacer {
    margin: 0 5px; /* Adjust the spacing as needed */
    color: #666; /* Example color */
}
.clock-text {
    font-size: 20px !important;
}

/* Adjust font size and vertical alignment for smaller devices */
@media (max-width: 767px) {
    .clock-text {
        font-size: 16px !important;
    }
}

/* Further adjust font size and vertical alignment for even smaller devices */
@media (max-width: 576px) {
    .clock-text {
        font-size: 14px !important;
    }
}

</style>

<?php
// Initialize arrays to store the count of plants for each month and status
$months = [];
$plantedByMonth = [];
$harvestedByMonth = [];
$witheredByMonth = [];

$ref_table = 'plants';
$plants_ref = $database->getReference($ref_table);

// Loop through each plant
foreach ($plants_ref->getValue() as $key => $plant) {
    // Check if date_planted is set and not empty
    if (isset($plant['date_planted']) && !empty($plant['date_planted'])) {
        // Get the month from the date_planted field
        $month = date('n', strtotime($plant['date_planted']));
        // Increment the count for the corresponding month
        if (!in_array($month, $months)) {
            // If the month is not already in the array, add it
            $months[] = $month;
            // Initialize counts for this month
            $plantedByMonth[$month] = 0;
            $harvestedByMonth[$month] = 0;
            $witheredByMonth[$month] = 0;
        }
        // Increment the count for the corresponding status and month
        if ($plant['plant_status'] === 'Planted') {
            $plantedByMonth[$month]++;
        } elseif ($plant['plant_status'] === 'Harvested') {
            $harvestedByMonth[$month]++;
        } elseif ($plant['plant_status'] === 'Withered') {
            $witheredByMonth[$month]++;
        }
    }
}
?>


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
            ?>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0" style=" font-size: 35px; font-weight: bold;">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
<!--             <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol> -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <h1 class="count">

                <?php
                        $ref_table = 'plants';
                        $total_count = $database->getReference($ref_table)->getSnapshot()->numChildren();
                        echo $total_count;
                        ?>
                </h1>

                <p class="textfont">REGISTERED PLANTS</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-seedling"></i>
              </div>

            </div>
          </div>



          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">

              <h1 class="count">
                <?php
              $ref_table = 'plants';
              $total_harvested = 0;

              $plants_ref = $database->getReference($ref_table);

              // Loop through each plant
              foreach ($plants_ref->getValue() as $key => $plant) {
                  // Check if the plant_status is Harvested
                  if (isset($plant['plant_status']) && $plant['plant_status'] === 'Harvested') {
                      $total_harvested++;
                  }
              }
              ?>

                <?php echo $total_harvested;?>
                <sup style="font-size: 20px"></sup>
              </h1>

                <p class="textfont" >HARVESTED PLANTS</p>
              </div>
              <div class="icon">
              <i class="fi fi-rr-hand-holding-seeding"></i>
              </div>
            </div>
          </div>

          <?php
          $users = iterator_to_array($auth->listUsers());
          // Get the total number of registered users
          $numberOfUsers = count($users);
          ?>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <h1 class="count"><?= $numberOfUsers ?></h1>

                <p class="textfont">REGISTERED USERS</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-user"></i>
              </div>

            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <h1 class="count">
                <?php
              $ref_table = 'plants';
              $total_withered = 0;

              $plants_ref = $database->getReference($ref_table);

              // Loop through each plant
              foreach ($plants_ref->getValue() as $key => $plant) {
                  // Check if the plant_status is Harvested
                  if (isset($plant['plant_status']) && $plant['plant_status'] === 'Withered') {
                      $total_withered++;
                  }
              }
              ?>
                  <?php echo $total_withered;?></h1>

                <p class="textfont">WITHERED PLANTS</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-bell"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->


        <section class="content">
    <div class="row">
        <div class="col-md-6">
            <!-- Interactive chart -->
            <div class="card card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title" style="padding-top:8px;">WATER pH LEVEL UPDATE</h3>
                        <div>
                            <!-- Change the button to call a JavaScript function when clicked -->
                            <button class="btn btn btn-sm" onclick="createReport()" style="background-color:#3f51b5; color:white;"><i class="fa-solid fa-chart-simple"></i> Create Report</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="fromDateInput">From:</label>
                            <input type="date" id="fromDateInput" class="form-control">
                        </div>
                        <div class="col">
                            <label for="toDateInput">To:</label>
                            <input type="date" id="toDateInput" class="form-control">
                        </div>
                        <div class="col">
                            <!-- Dropdown menu for selecting plants -->
                            <div class="form-group">
                                <label for="filterDropdown2">Select Plant:</label>
                                <select id="filterDropdown2" class="form-control">
                                    <option value="all">All Plants</option>
                                </select>
                                <i class="fas fa-caret-down position-absolute top-50 translate-middle-y" style="right: 10px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Date range filter -->
                <div class="card-body">
                    <div class="chart">
                        <!-- Keep canvas element for the chart -->
                        <canvas id="barChart2" style="min-height: 400px; height: 100%; max-height: 460px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ALKALINE AND ACIDIC PLANTS PER MONTH</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="lineChart"  style="min-height: 520px; height: 100%; max-height: 495px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


        <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- Interactive chart -->
                <div class="card card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title" style="padding-top:8px;">DAILY WATER pH LEVEL UPDATE</h3>
                            </div>
                            <div class="col-auto">
                                <!-- Dropdown menu for selecting plants -->
                                <!-- <select id="filterDropdown4" class="form-control">
                                    <option value="all">All Plants</option>
                                </select> -->
                                <!-- Icon for dropdown -->
                                <!-- <i class="fas fa-caret-down position-absolute top-50 translate-middle-y" style="right: 10px;"></i> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart3" style="min-height: 400px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
    <!-- Interactive chart -->
    <div class="card card-outline">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h3 class="card-title" style="padding-top:8px;">MONTHLY BAY WATER PH UPDATE</h3>
                </div>
                <div class="col-auto">
                    <!-- Dropdown menu for selecting bays -->
                    <select id="Bays" class="form-control">
                        <option value="all">All Bays</option>
                    </select>
                    <!-- Icon for dropdown -->
                    <i class="fas fa-caret-down position-absolute top-50 translate-middle-y" style="right: 10px;"></i>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="barChart4" style="min-height: 450px; height: 100%; max-height: 460px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
</section>




<div class="col-md-12">
    <!-- Clock chart -->
    <div class="item3">
        <div id="clock" class="clock-text"></div>
    </div>
</div>
        </div>
    </div>
</section>


</div>
</div>



<?php
include('includes/footer.php');
include('Modal/Report.php');


?>

<script src="plugins/flot/jquery.flot.js"></script>
<script src="plugins/flot/plugins/jquery.flot.pie.js"></script>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>



    <script>
            function updateClock() {
                var now = new Date();
                var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                var monthsOfYear = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                var dayOfWeek = daysOfWeek[now.getDay()];
                var month = monthsOfYear[now.getMonth()];
                var dayOfMonth = now.getDate();
                var year = now.getFullYear();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var seconds = now.getSeconds();
                var ampm = hours >= 12 ? 'PM' : 'AM';

                hours = hours % 12;
                hours = hours ? hours : 12; // The hour '0' should be '12'

                var formattedTime = dayOfWeek + '<span class="spacer"> | </span>' + month + ' ' + dayOfMonth + ' , ' + year + '<span class="spacer"> | </span>' +
                    hours + ':' + (minutes < 10 ? '0' : '') + minutes + ':' +
                    (seconds < 10 ? '0' : '') + seconds + ' ' + ampm;
                document.getElementById('clock').innerHTML = formattedTime;
            }

            // Update the clock every second
            setInterval(updateClock, 1000);

            // Initial call to display the clock immediately
            updateClock();
    </script>


<script>
function createReport() {
    // Get the filter values
    var fromDate = document.getElementById('fromDateInput').value;
    var toDate = document.getElementById('toDateInput').value;
    var selectedPlant = document.getElementById('filterDropdown2').value;

    // Reference to your database
    var notificationsRef = firebase.database().ref("notifications");

    // Retrieve pH level data from the database within the specified date range
    notificationsRef.once("value", function(snapshot) {
        // Initialize an object to store pH levels and bay information for each plant
        var phLevelsByPlant = {};

        // Iterate over notifications
        snapshot.forEach(function(childSnapshot) {
            var data = childSnapshot.val();
            // Check if the date is within the specified range
            var notificationDate = new Date(data.current_date);
            if (notificationDate >= new Date(fromDate) && notificationDate <= new Date(toDate)) {
                // If a specific plant is selected or 'All' is selected, filter the data by plant name
                if (selectedPlant === 'all' || data.plant_name === selectedPlant) {
                    // If the plant name doesn't exist in the phLevelsByPlant object, initialize an object for it
                    if (!phLevelsByPlant[data.plant_name]) {
                        phLevelsByPlant[data.plant_name] = { pHLevels: [], bay: data.bay };
                    }
                    // Push pH level to the array corresponding to the plant name
                    phLevelsByPlant[data.plant_name].pHLevels.push(parseFloat(data.ph_lvl));
                }
            }
        });

        // Once all data is fetched, calculate highest and lowest pH levels for each plant
        var highestLowestPhLevels = {};
        Object.keys(phLevelsByPlant).forEach(function(plantName) {
            var phLevels = phLevelsByPlant[plantName].pHLevels;
            // Calculate highest and lowest pH levels for the current plant
            var highestPhLevel = Math.max(...phLevels);
            var lowestPhLevel = Math.min(...phLevels);
            // Store the highest and lowest pH levels in the object
            highestLowestPhLevels[plantName] = { highest: highestPhLevel, lowest: lowestPhLevel, bay: phLevelsByPlant[plantName].bay };
        });

        // Once all calculations are done, proceed to generate report
        generateReport(highestLowestPhLevels);
    });
}

function generateReport(phLevelsByPlant, barPlantImageURL, barBayImageURL, barChartImageURL, lineChartImageURL) {
    // Get the current date and time
    var currentDate = new Date();
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    var dateString = currentDate.toLocaleDateString(undefined, options);
    var timeString = currentDate.toLocaleTimeString();
    var currentDateTime = dateString + ', ' + timeString;

    // Get the canvas elements for both bar and line charts
    var barPlants = document.getElementById('barChart3');
    var barBays = document.getElementById('barChart4');
    var barCanvas = document.getElementById('barChart2');
    var lineCanvas = document.getElementById('lineChart');

     // Get the chart data for both bar and line charts
     var barChart = Chart.getChart(barCanvas);
    var lineChart = Chart.getChart(lineCanvas)
    var barChartPlant = Chart.getChart(barPlants);
    var barChartBay = Chart.getChart(barBays);
    var barHighData = barChart.data.datasets[0].data;
    var barLowData = barChart.data.datasets[1].data;
    var labels = barChart.data.labels; // Assuming labels are available in the bar chart data

    // Calculate highest, lowest, and average pH levels for the bar chart
    var highestBar = Math.max(...barHighData);
    var lowestBar = Math.min(...barLowData);


    // Convert the canvas to base64 encoded image URLs
    var barChartImageURL = barCanvas.toDataURL();
    var lineChartImageURL = lineCanvas.toDataURL();
    var barPlantImageURL = barPlants.toDataURL();
    var barBayImageURL = barBays.toDataURL();

    // Get the filter values
    var fromDate = document.getElementById('fromDateInput').value;
    var toDate = document.getElementById('toDateInput').value;
    var selectedPlant = document.getElementById('filterDropdown2').value;


   var reportContent = `

   <div class="text-center align-items-center" style="border-bottom: 5px solid #000;">
                <h5 class="modal-title mx-auto" id="reportModalLabel" style="font-size: 20px; font-weight: bold;">
                    Schools Division Office - Quezon City<br>
                    ROSA L. SUSANO - NOVALICHES ELEMENTARY SCHOOL<br>
                    Quirino Highway, Gulod Novaliches, Quezon City<br><br>
                    Plant pH Level Descriptive Analytics Report<br><br>
                </h5>
            </div>

    <p>Date and Time: ${currentDateTime}</p>
    <h2 style="margin-bottom: 20px;">Trend Analysis of Plant pH Level Fluctuations</h2>
<p style="margin-bottom: 20px;">The purpose of this report is to examine the trend of pH level fluctuations within the specified time period for plants.</p>
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
    <div style="margin-right: 20px;">
        <p style="display: inline-block; margin-right: 5px;">From:</p>
        <p style="display: inline-block;">${fromDate}</p>
    </div>
    <div>
        <p style="display: inline-block; margin-right: 5px;">To:</p>
        <p style="display: inline-block;">${toDate}</p>
    </div>
    <div>
        <p style="display: inline-block; margin-right: 5px;">Selected Plant:</p>
        <p style="display: inline-block;">${selectedPlant}</p>
    </div>
</div>
`;
// Add the header row for the table
reportContent += `
    <table border="1" style="margin-bottom: 20px; text-align: center; width:100%;">
        <tr>
            <th class="text-center" style="padding: 10px;">Plants</th>
            <th class="text-center" style="padding: 10px;">Statistic</th>
            <th class="text-center" style="padding: 10px;">Percentage</th>
            <th class="text-center" style="padding: 10px;">Total</th>
            <th class="text-center" style="padding: 10px;">Bay</th>
        </tr>
`;

// Generate tables for each plant
Object.keys(phLevelsByPlant).forEach(function(plantName) {
    var highestPhLevel = phLevelsByPlant[plantName].highest;
    var lowestPhLevel = phLevelsByPlant[plantName].lowest;
    var bay = phLevelsByPlant[plantName].bay; // Assuming the bay information is available in phLevelsByPlant

    // Get the index of the current plant in the labels array
    var plantIndex = labels.indexOf(plantName);
    if (plantIndex !== -1) {
        // Retrieve highest and lowest pH levels for the current plant
        var highestBar = barHighData[plantIndex];
        var lowestBar = barLowData[plantIndex];

        // Calculate sum
        var sum = highestBar + lowestBar;

        // Calculate acidic and alkaline percentages
        var acidicPercentage = (lowestBar / sum) * 100;
        var alkalinePercentage = (highestBar / sum) * 100;


       // Add rows for each plant
    reportContent += `
        <tr class="text-center">
            <td class="text-center" rowspan="3" style="padding: 10px;">${plantName}</td>
            <td class="text-center" style="padding: 10px;">Highest pH Level: ${highestPhLevel.toFixed(1)}</td>
            <td class="text-center" style="padding: 10px; font-weight: bold; color: #FF7B5F;">Alkaline - ${alkalinePercentage.toFixed(2)}%</td>
            <td class="text-center" style="padding: 10px;">pH Level Highest: ${highestBar}</td>
            <td class="text-center" rowspan="3" style="padding: 10px;">${bay}</td>
        </tr>
        <tr>
            <td class="text-center" style="padding: 10px;">Lowest pH Level: ${lowestPhLevel.toFixed(1)}</td>
            <td class="text-center" style="padding: 10px; color: #0057b2;">Acidic -  ${acidicPercentage.toFixed(2)}%</td>
            <td class="text-center" style="padding: 10px;">pH Lvl Lowest: ${lowestBar}</td>
        </tr>
        <tr>
        </tr>

`;

    } else {
        // Handle case where plant name is not found in chart data
        console.error("Plant name not found in chart data:", plantName);
    }
});

reportContent += `</table>`;

reportContent += `<h3 style="margin-top: 20px; margin-bottom:20px;">Graphical Representation:</h3>
    <div style="display: flex; align-items: center;">
    <div style="margin-right: 40px;">
    <img src="${barChartImageURL}" alt="Bar Chart" style="height:250px; weight:250px;">
    </div>
    <img src="${lineChartImageURL}" alt="Line Chart" style="height:250px; weight:250px;">
    </div></div>
    <div style="display: flex; align-items: center;">
    <div style="margin-right: 40px;">
    <img src="${barPlantImageURL}" alt="Bar Chart" style="height:250px; weight:250px;">
    </div>
    <img src="${barBayImageURL}" alt="Line Chart" style="height:250px; weight:250px;">
    </div></div>


    `;




// Calculate upward and downward fluctuations based on highest and lowest pH levels
var upwardFluctuations = 0;
var downwardFluctuations = 0;

if (selectedPlant === 'all') {
    // If 'all' plants are selected, sum up all the highest and lowest bars
    Object.keys(phLevelsByPlant).forEach(function(plantName) {
        upwardFluctuations += barHighData[labels.indexOf(plantName)];
        downwardFluctuations += barLowData[labels.indexOf(plantName)];
    });
} else {
    // If a specific plant is selected, calculate fluctuations based on that plant only
    upwardFluctuations = highestBar;
    downwardFluctuations = lowestBar;
}

// Calculate total highest and lowest pH levels for all plants
var totalHighest = 0;
var totalLowest = 0;
var totalPlants = 0;

if (selectedPlant === 'all') {
    Object.keys(phLevelsByPlant).forEach(function(plantName) {
        totalHighest += barHighData[labels.indexOf(plantName)];
        totalLowest += barLowData[labels.indexOf(plantName)];
        totalPlants++;
    });
}


// Calculate the average pH level
var averagePhLevel = ((highestBar + lowestBar) / 2).toFixed(1);
// Calculate testing period duration
var testingPeriod = Math.abs(new Date(toDate) - new Date(fromDate)) / (1000 * 60 * 60 * 24); // in days
var options = { year: 'numeric', month: 'long', day: 'numeric' };
var fromDateFormatted = new Date(fromDate).toLocaleDateString(undefined, options);
var toDateFormatted = new Date(toDate).toLocaleDateString(undefined, options);


// Initialize variables to track lowest and highest pH levels among all plants
var overallLowestPhLevel = Infinity;
var overallHighestPhLevel = -Infinity;
var overallHighestBay = '';
var overallLowestBay = '';

// Loop through each plant to find the overall highest and lowest pH levels
Object.keys(phLevelsByPlant).forEach(function(plantName) {
    var highestPhLevel = phLevelsByPlant[plantName].highest;
    var lowestPhLevel = phLevelsByPlant[plantName].lowest;
    var bay = phLevelsByPlant[plantName].bay; // Assuming the bay information is available in phLevelsByPlant

    // Update overall highest pH level and corresponding bay if the current plant's highest pH level is greater
    if (highestPhLevel > overallHighestPhLevel) {
        overallHighestPhLevel = highestPhLevel;
        overallHighestBay = bay;
    }

    // Update overall lowest pH level and corresponding bay if the current plant's lowest pH level is lower
    if (lowestPhLevel < overallLowestPhLevel) {
        overallLowestPhLevel = lowestPhLevel;
        overallLowestBay = bay;
    }
});

// Calculate the average pH level
var averagePhLevel = ((overallHighestPhLevel + overallLowestPhLevel) / 2).toFixed(1);


// Display overall highest and lowest pH levels with corresponding bay information
reportContent += `
<h3 style="margin-top: 20px;">Interpretation:</h3>
<p>
    Based on our data analysis, we observed significant fluctuations in pH levels across different plants within the specified time period from ${fromDateFormatted} to ${toDateFormatted}.
    These fluctuations indicate changes in the acidity or alkalinity of the water, which can have profound effects on plant health and growth.
</p>

<p>
    Our analysis revealed ${upwardFluctuations} instances of upward pH level changes and ${downwardFluctuations} instances of downward changes during the time period of ${testingPeriod} days.
</p>

<p>
    The overall highest pH level recorded among all plants was ${overallHighestPhLevel.toFixed(1)}, observed in the ${overallHighestBay}.
    This high pH level could indicate alkaline water conditions, which might adversely affect the nutrient uptake by plants and lead to nutrient deficiencies.
</p>

<p>
    Conversely, the lowest pH level recorded was ${overallLowestPhLevel.toFixed(1)}, observed in the ${overallLowestBay}.
    A low pH level typically indicates acidic water conditions, which can hinder the availability of essential nutrients to plants and affect their overall growth and development.
</p>


`;


// Set the report content to the modal body
document.getElementById('reportModalBody').innerHTML = reportContent;

// Show the report modal
$('#reportModal').modal('show');

}


function printReport() {
    var modalContent = document.getElementById('reportModalBody').innerHTML;
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Plant pH Level Report</title><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"><style>@media print { .modal-footer, .modal-header { display: none; } }</style></head><body>' + modalContent + '</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function saveAsPDF() {
    var modalContent = document.getElementById('reportModalBody').innerHTML;

    // Create a new window with the modal content
    var printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write('<html><head><title>Plant pH Level Report</title><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"><style>@media print { .modal-footer, .modal-header { display: none; } }</style></head><body>' + modalContent + '</body></html>');
    printWindow.document.close();

    // Wait for content to be fully loaded before generating PDF
    printWindow.onload = function() {
        // Use html2pdf library to generate PDF
        html2pdf(printWindow.document.body, {
            margin: 10,
            filename: 'plant_pH_level_report.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { dpi: 192, letterRendering: true },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
            pagebreak: { mode: ['avoid-all'] } // Avoid page breaks within content
        }).then(function(pdf) {
            pdf.save(); // Save PDF
        });
    };
}


</script>


<!--
<script>
        document.addEventListener("DOMContentLoaded", function () {
        // Reference to your database
        var notificationsRef = firebase.database().ref("notifications");

        // Initialize arrays to store counts of high and low pH levels for each date
        var highCounts = {};
        var lowCounts = {};

        // Get the current date
        var currentDate = new Date();
        // Set the default 'From' date to the first day of the current month
        var fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        // Set the default 'To' date to the last day of the current month
        var toDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

        // Set the default values of the date inputs
        document.getElementById('fromDateInput').valueAsDate = fromDate;
        document.getElementById('toDateInput').valueAsDate = toDate;

        function updateCurrentData() {
        // Query Firebase to get current data
        notificationsRef.on("value", function (snapshot) {
            // Reset counts
            highCounts = {};
            lowCounts = {};

            // Populate the dropdown with unique plant names
            populatePlantsDropdown(snapshot);

            // Get the current month and year
            var currentDate = new Date();
            var currentMonth = currentDate.getMonth() + 1; // Adding 1 because getMonth() returns zero-based month index
            var currentYear = currentDate.getFullYear();

            // Iterate over the snapshot
            snapshot.forEach(function (childSnapshot) {
                var data = childSnapshot.val();
                var dateString = data.current_date;

                // Parse the date string into a Date object
                var date = new Date(dateString);
                var month = date.getMonth() + 1; // Adding 1 because getMonth() returns zero-based month index
                var year = date.getFullYear();

                // Check if the date matches the current month and year
                if (month === currentMonth && year === currentYear) {
                    // Count occurrences of high and low pH levels for each plant
                    if (data.status === "High") {
                        highCounts[data.plant_name] = highCounts[data.plant_name] || [];
                        highCounts[data.plant_name].push(date);
                    } else if (data.status === "Low") {
                        lowCounts[data.plant_name] = lowCounts[data.plant_name] || [];
                        lowCounts[data.plant_name].push(date);
                    }
                }
            });

            // Filter data based on selected plant
            var selectedPlant = document.getElementById("filterDropdown2").value;
            var filteredHighCounts = filterDataByPlant(highCounts, selectedPlant);
            var filteredLowCounts = filterDataByPlant(lowCounts, selectedPlant);

            // Update the charts with the filtered data
            updateBarChart(filteredHighCounts, filteredLowCounts);
            updateLineChart(filteredHighCounts, filteredLowCounts);
        });
    }


        // Function to filter data by date range and plant
        function filterDataByDateRange(data, fromDate, toDate, selectedPlant) {
            var filteredData = {};

            for (var plant in data) {
                if (selectedPlant === 'all' || plant === selectedPlant) {
                    var filteredDates = data[plant].filter(function (date) {
                        return (!fromDate || date >= fromDate) && (!toDate || date <= toDate);
                    });
                    filteredData[plant] = filteredDates.length;
                }
            }

            return filteredData;
        }

        // Function to populate the dropdown with unique plant names
        function populatePlantsDropdown(snapshot) {
            var dropdown = document.getElementById("filterDropdown2");
            dropdown.innerHTML = ''; // Clear existing options

            // Add 'All' option
            var optionAll = document.createElement("option");
            optionAll.text = "All Plants";
            optionAll.value = "all";
            dropdown.add(optionAll);

            // Fetch unique plant names from Firebase
            var plantsSet = new Set(); // Use a Set to store unique plant names
            snapshot.forEach(function (childSnapshot) {
                var plantName = childSnapshot.val().plant_name;
                if (plantName && !plantsSet.has(plantName)) {
                    plantsSet.add(plantName);
                    // Add plant option
                    var option = document.createElement("option");
                    option.text = plantName;
                    option.value = plantName;
                    dropdown.add(option);
                }
            });

            // Add event listener to handle plant dropdown selection
            dropdown.addEventListener('change', updateCharts);
        }

        // Function to update both charts
        function updateCharts() {
            var fromDate = new Date(document.getElementById("fromDateInput").value);
            var toDate = new Date(document.getElementById("toDateInput").value);
            var selectedPlant = document.getElementById("filterDropdown2").value;

            var filteredHighCounts = filterDataByDateRange(highCounts, fromDate, toDate, selectedPlant);
            var filteredLowCounts = filterDataByDateRange(lowCounts, fromDate, toDate, selectedPlant);

            updateBarChart(filteredHighCounts, filteredLowCounts);
            updateLineChart(filteredHighCounts, filteredLowCounts);
        }

        // Function to update the bar chart
        function updateBarChart(highCounts, lowCounts) {
            // Remove the previous chart if it exists
            if (window.activeBarChart) {
                window.activeBarChart.destroy();
            }

            // Extract labels and data
            var labels = Object.keys(highCounts);
            var highData = Object.values(highCounts);
            var lowData = Object.values(lowCounts);

            // Calculate maximum data value for dynamic scaling
            var maxData = Math.max(...highData, ...lowData);

            // Update the chart
            var barChart2Canvas = document.getElementById('barChart2').getContext('2d');
            var barChart2 = new Chart(barChart2Canvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'High pH Level',
                        backgroundColor: '#FF7B5F',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        data: highData,
                    }, {
                        label: 'Low pH Level',
                        backgroundColor: '#0057b2',
                        borderColor: 'rgba(60,141,188,0.8)',
                        data: lowData,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                offset: true
                            }
                        },
                        y: {
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                stepSize: Math.ceil(maxData / 5), // Adjust the step size dynamically based on the maximum value
                            }
                        }
                    },
                }
            });

            // Store the active chart instance
            window.activeBarChart = barChart2;
        }

        // Function to update the line chart
        function updateLineChart(highCounts, lowCounts) {
            // Remove the previous chart if it exists
            if (window.activeLineChart) {
                window.activeLineChart.destroy();
            }

            // Extract labels and data
            var labels = Object.keys(highCounts);
            var highData = Object.values(highCounts);
            var lowData = Object.values(lowCounts);

            // Calculate maximum data value for dynamic scaling
            var maxData = Math.max(...highData, ...lowData);

            // Update the chart
            var lineChartCanvas = document.getElementById('lineChart').getContext('2d');
            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Alkaline',
                        borderColor: '#FF7B5F',
                        backgroundColor: 'rgba(255, 123, 95, 0.2)',
                        data: highData,
                    }, {
                        label: 'Acidic',
                        borderColor: '#0057b2',
                        backgroundColor: 'rgba(0, 87, 178, 0.2)',
                        data: lowData,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                offset: true
                            }
                        },
                        y: {
                            ticks: {
                                beginAtZero: true,
                                stepSize: Math.ceil(maxData / 5), // Adjust the step size dynamically based on the maximum value
                            }
                        }
                    },
                }
            });

            // Store the active chart instance
            window.activeLineChart = lineChart;
        }

        // Add event listeners to date inputs to update the chart when dates change
        document.getElementById('fromDateInput').addEventListener('change', updateCharts);
        document.getElementById('toDateInput').addEventListener('change', updateCharts);

        // Call updateCurrentData to display current data
        updateCurrentData();
    });

</script> -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Reference to your database
    var notificationsRef = firebase.database().ref("notifications");

    // Initialize arrays to store counts of high and low pH levels for each date
    var highCounts = {};
    var lowCounts = {};

    // Get the current date
    var currentDate = new Date();
    // Set the default 'From' date to the first day of the current month
    var fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    // Set the default 'To' date to the last day of the current month
    var toDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
    // Set the default values of the date inputs
    document.getElementById('fromDateInput').valueAsDate = fromDate;
    document.getElementById('toDateInput').valueAsDate = toDate;

    // Function to retrieve current data from Firebase and update chart
    function updateCurrentData() {
        // Query Firebase to get current data
        notificationsRef.on("value", function (snapshot) {
            // Reset counts
            highCounts = {};
            lowCounts = {};

            // Populate the dropdown with unique plant names
            populatePlantsDropdown(snapshot);

            // Iterate over the snapshot
            snapshot.forEach(function (childSnapshot) {
                var data = childSnapshot.val();
                var dateString = data.current_date;

                // Parse the date string into a Date object
                var date = new Date(dateString);

                // Count occurrences of high and low pH levels for each plant
                if (data.status === "High") {
                    highCounts[data.plant_name] = highCounts[data.plant_name] || [];
                    highCounts[data.plant_name].push(date);
                } else if (data.status === "Low") {
                    lowCounts[data.plant_name] = lowCounts[data.plant_name] || [];
                    lowCounts[data.plant_name].push(date);
                }
            });

            // Update the charts
            updateCharts();
        });
    }

    // Function to filter data by date range and plant
    function filterDataByDateRange(data, fromDate, toDate, selectedPlant) {
        var filteredData = {};

        for (var plant in data) {
            if (selectedPlant === 'all' || plant === selectedPlant) {
                var filteredDates = data[plant].filter(function (date) {
                    return (!fromDate || date >= fromDate) && (!toDate || date <= toDate);
                });
                filteredData[plant] = filteredDates.length;
            }
        }

        return filteredData;
    }

    // Function to populate the dropdown with unique plant names
    function populatePlantsDropdown(snapshot) {
        var dropdown = document.getElementById("filterDropdown2");
        dropdown.innerHTML = ''; // Clear existing options

        // Add 'All' option
        var optionAll = document.createElement("option");
        optionAll.text = "All Plants";
        optionAll.value = "all";
        dropdown.add(optionAll);

        // Fetch unique plant names from Firebase
        var plantsSet = new Set(); // Use a Set to store unique plant names
        snapshot.forEach(function (childSnapshot) {
            var plantName = childSnapshot.val().plant_name;
            if (plantName && !plantsSet.has(plantName)) {
                plantsSet.add(plantName);
                // Add plant option
                var option = document.createElement("option");
                option.text = plantName;
                option.value = plantName;
                dropdown.add(option);
            }
        });

        // Add event listener to handle plant dropdown selection
        dropdown.addEventListener('change', updateCharts);
    }

    // Function to update both charts
    function updateCharts() {
        var fromDate = new Date(document.getElementById("fromDateInput").value);
        var toDate = new Date(document.getElementById("toDateInput").value);
        var selectedPlant = document.getElementById("filterDropdown2").value;

        var filteredHighCounts = filterDataByDateRange(highCounts, fromDate, toDate, selectedPlant);
        var filteredLowCounts = filterDataByDateRange(lowCounts, fromDate, toDate, selectedPlant);

        updateBarChart(filteredHighCounts, filteredLowCounts);
        updateLineChart(filteredHighCounts, filteredLowCounts);
    }

    // Function to update the bar chart
    function updateBarChart(highCounts, lowCounts) {
        // Remove the previous chart if it exists
        if (window.activeBarChart) {
            window.activeBarChart.destroy();
        }

        // Extract labels and data
        var labels = Object.keys(highCounts);
        var highData = Object.values(highCounts);
        var lowData = Object.values(lowCounts);

        // Calculate maximum data value for dynamic scaling
        var maxData = Math.max(...highData, ...lowData);

        // Update the chart
        var barChart2Canvas = document.getElementById('barChart2').getContext('2d');
        var barChart2 = new Chart(barChart2Canvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'High pH Level',
                    backgroundColor: '#FF7B5F',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    data: highData,
                }, {
                    label: 'Low pH Level',
                    backgroundColor: '#0057b2',
                    borderColor: 'rgba(60,141,188,0.8)',
                    data: lowData,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            offset: true
                        }
                    },
                    y: {
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            stepSize: Math.ceil(maxData / 5), // Adjust the step size dynamically based on the maximum value
                        }
                    }
                },
            }
        });

        // Store the active chart instance
        window.activeBarChart = barChart2;
    }

    // Function to update the line chart
    function updateLineChart(highCounts, lowCounts) {
        // Remove the previous chart if it exists
        if (window.activeLineChart) {
            window.activeLineChart.destroy();
        }

        // Extract labels and data
        var labels = Object.keys(highCounts);
        var highData = Object.values(highCounts);
        var lowData = Object.values(lowCounts);

        // Calculate maximum data value for dynamic scaling
        var maxData = Math.max(...highData, ...lowData);

        // Update the chart
        var lineChartCanvas = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Alkaline',
                    borderColor: '#FF7B5F',
                    backgroundColor: 'rgba(255, 123, 95, 0.2)',
                    data: highData,
                }, {
                    label: 'Acidic',
                    borderColor: '#0057b2',
                    backgroundColor: 'rgba(0, 87, 178, 0.2)',
                    data: lowData,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            offset: true
                        }
                    },
                    y: {
                        beginAtZero: true, // Start the y-axis scale from zero
                        ticks: {
                            stepSize: Math.ceil(maxData / 5), // Adjust the step size dynamically based on the maximum value
                        }
                    }
                },
            }
        });

        // Store the active chart instance
        window.activeLineChart = lineChart;
    }

    // Add event listeners to date inputs to update the chart when dates change
    document.getElementById('fromDateInput').addEventListener('change', updateCharts);
    document.getElementById('toDateInput').addEventListener('change', updateCharts);

    // Call updateCurrentData to display current data
    updateCurrentData();
    });

</script>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        // Reference to your database
        var notificationsRef = firebase.database().ref("notifications");

        // Initialize empty chart variable
        var barChart3;

        // Function to retrieve data from Firebase and update chart
        function updateChart(selectedPlant) {
            notificationsRef.once("value", function (snapshot) {
                // Initialize object to store pH levels by plant name
                var phLevelsByPlant = {};

                // Iterate over notifications
                snapshot.forEach(function (childSnapshot) {
                    var data = childSnapshot.val();

                    // Store pH level for current plant
                    phLevelsByPlant[data.plant_name] = phLevelsByPlant[data.plant_name] || [];
                    phLevelsByPlant[data.plant_name].push(parseFloat(data.ph_lvl));
                });

                // Filter data based on selected plant
                if (selectedPlant !== 'all') {
                    var filteredPhLevels = {};
                    filteredPhLevels[selectedPlant] = phLevelsByPlant[selectedPlant];
                    phLevelsByPlant = filteredPhLevels;
                }

                // Initialize arrays to store highest and lowest pH levels for each plant
                var highestPhLevels = [];
                var lowestPhLevels = [];
                var plantNames = [];

                // Iterate over data to calculate highest and lowest pH levels
                for (var plant in phLevelsByPlant) {
                    if (phLevelsByPlant.hasOwnProperty(plant)) {
                        var phLevels = phLevelsByPlant[plant];
                        var highest = Math.max(...phLevels);
                        var lowest = Math.min(...phLevels);
                        highestPhLevels.push(highest);
                        lowestPhLevels.push(lowest);
                        plantNames.push(plant);
                    }
                }

                // Find the minimum pH level among all plants
                var minPhLevel = Math.min(...lowestPhLevels);
                minPhLevel = minPhLevel < 1 ? 1 : minPhLevel; // Ensure the minimum pH level is at least 1

                // Create datasets for highest and lowest pH levels for each plant
                var datasets = [
                    {
                        label: 'Highest pH Level',
                        data: highestPhLevels,
                        backgroundColor: '#0057b2',
                        borderColor: 'rgba(60,141,188,0.8)',
                        borderWidth: 1
                    },
                    {
                        label: 'Lowest pH Level',
                        data: lowestPhLevels,
                        backgroundColor: '#FF7B5F',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        borderWidth: 1
                    }
                ];

                // Update chart data
                if (barChart3) {
                    barChart3.data.labels = plantNames;
                    barChart3.data.datasets = datasets;
                    barChart3.options.scales.y.min = 1; // Set minimum y-axis scale value to 1
                    barChart3.options.scales.y.max = 15; // Set maximum y-axis scale value to 15
                    barChart3.update();
                }
            });
        }

        // Populate dropdown menu with unique plant names
        function populatePlantsDropdown(snapshot) {
            var dropdown = document.getElementById("filterDropdown2");
            dropdown.innerHTML = ''; // Clear existing options

            // Add 'All Plants' option
            var optionAll = document.createElement("option");
            optionAll.text = "All Plants";
            optionAll.value = "all";
            dropdown.add(optionAll);

            // Fetch unique plant names from Firebase
            var plantsSet = new Set(); // Use a Set to store unique plant names
            snapshot.forEach(function (childSnapshot) {
                var plantName = childSnapshot.val().plant_name;
                if (plantName && !plantsSet.has(plantName)) {
                    plantsSet.add(plantName);
                    // Add plant option
                    var option = document.createElement("option");
                    option.text = plantName;
                    option.value = plantName;
                    dropdown.add(option);
                }
            });

            // Add event listener to handle plant dropdown selection
            dropdown.addEventListener('change', function () {
                var selectedPlant = dropdown.value;
                updateChart(selectedPlant);
            });
        }

        // Fetch data and populate dropdown menu when the page loads
        notificationsRef.once("value", function (snapshot) {
            populatePlantsDropdown(snapshot);
        });

        // Initialize the chart initially with default values
        var defaultData = [];
        var defaultLabels = [''];
        var defaultOptions = {
            scales: {
                y: {
                    beginAtZero: false, // Start from 1
                    min: 1, // Set minimum y-axis scale value to 1
                    max: 15 // Set maximum y-axis scale value to 15
                }
            },
            animation: {
                duration: 0 // Disable dataset animations
            }
        };
        barChart3 = new Chart('barChart3', {
            type: 'bar',
            data: {
                labels: defaultLabels,
                datasets: defaultData
            },
            options: defaultOptions
        });

        // Call the function to update the chart with default values
        updateChart('all');
    });

</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Reference to your database
        var notificationsRef = firebase.database().ref("notifications");

        // Initialize an object to store data by bay
        var dataByBay = {};

        // Function to retrieve current data from Firebase and populate dropdowns
        function updateCurrentDataBar() {
            notificationsRef.on("value", function (snapshot) {
                // Reset dataByBay
                dataByBay = {};

                // Iterate over the snapshot
                snapshot.forEach(function (childSnapshot) {
                    var data = childSnapshot.val();
                    var bay = data.bay;
                    var status = data.status;

                    // Create or update data entry for the specific bay and status
                    if (!dataByBay[bay]) dataByBay[bay] = { low: 0, high: 0 };
                    if (status === "Low") {
                        dataByBay[bay].low++;
                    } else if (status === "High") {
                        dataByBay[bay].high++;
                    }
                });

                // Update the bar chart
                updateBarChart(dataByBay);

                // Populate the dropdown for bays
                populateBaysDropdown(snapshot);
            });
        }

        // Function to update the bar chart
        function updateBarChart(data) {
            var ctx = document.getElementById('barChart4').getContext('2d');

            // Clear previous chart if exists
            if (window.myBar) {
                window.myBar.destroy();
            }

            // Extract data for chart
            var bayLabels = Object.keys(data);
            var lowLevels = bayLabels.map(function (bay) { return data[bay].low; });
            var highLevels = bayLabels.map(function (bay) { return data[bay].high; });

            // Create new chart
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: bayLabels,
                    datasets: [{
                        label: 'Low pH Level',
                        backgroundColor: '#0057b2',
                        borderColor: 'rgba(60,141,188,0.8)',
                        data: lowLevels,
                    },
                    {
                        label: 'High pH Level',
                        backgroundColor: '#FF7B5F',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        data: highLevels,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                offset: true
                            }
                        },
                        y: {
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Call updateCurrentDataBar to fetch data and update the bar chart
        updateCurrentDataBar();

        // Function to populate the dropdown with unique bay names
        function populateBaysDropdown(snapshot) {
            var dropdown = document.getElementById("Bays");
            dropdown.innerHTML = ''; // Clear existing options

            // Add 'All' option
            var optionAll = document.createElement("option");
            optionAll.text = "All Bays";
            optionAll.value = "all";
            dropdown.add(optionAll);

            // Fetch unique bay names from Firebase
            var baysSet = new Set(); // Use a Set to store unique bay names
            snapshot.forEach(function (childSnapshot) {
                var bay = childSnapshot.val().bay;
                if (bay && !baysSet.has(bay)) {
                    baysSet.add(bay);
                    // Add bay option
                    var option = document.createElement("option");
                    option.text = bay;
                    option.value = bay;
                    dropdown.add(option);
                }
            });

            // Add event listener to handle bay dropdown selection
            dropdown.addEventListener('change', filterData);
        }

        // Function to filter data based on dropdown selection
        function filterData() {
            var selectedBay = document.getElementById("Bays").value;

            // If selectedBay is 'all', then show all data
            if (selectedBay === 'all') {
                updateBarChart(dataByBay);
                return;
            }

            // Filter data based on selected bay
            var filteredData = {};
            for (var bay in dataByBay) {
                if (bay === selectedBay) {
                    filteredData[bay] = dataByBay[bay];
                }
            }

            // Update the bar chart with filtered data
            updateBarChart(filteredData);
        }
    });
</script>
