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


    .ph-value {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .ph-value-text {
        font-size: 3rem;
        font-weight: bold;
        text-align: center;
    }

    .ph-value-number {
        font-size: 10rem;
        font-weight: bold;
        text-align: center;
    }

    .switch {
        position: relative;
        display: block;
        vertical-align: top;
        width: 120px;
        height: 50px;
        padding: 3px;
        margin: 0 10px 10px 0;
        background: linear-gradient(to bottom, #eeeeee, #FFFFFF 25px);
        background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF 25px);
        border-radius: 18px;
        box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
        cursor: pointer;
        box-sizing:content-box;
    }
    .switch-input {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        box-sizing:content-box;
    }
    .switch-label {
        position: relative;
        display: block;
        height: inherit;
        font-size: 10px;
        text-transform: uppercase;
        background: #eceeef;
        border-radius: inherit;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
        box-sizing:content-box;
    }
    .switch-label:before, .switch-label:after {
        position: absolute;
        top: 50%;
        margin-top: -.5em;
        line-height: 1;
        -webkit-transition: inherit;
        -moz-transition: inherit;
        -o-transition: inherit;
        transition: inherit;
        box-sizing:content-box;
    }
    .switch-label:before {
        content: attr(data-off);
        right: 11px;
        color: #aaaaaa;
        text-shadow: 0 1px rgba(255, 255, 255, 0.5);
    }
    .switch-label:after {
        content: attr(data-on);
        left: 11px;
        color: #FFFFFF;
        text-shadow: 0 1px rgba(0, 0, 0, 0.2);
        opacity: 0;
    }
    .switch-input:checked ~ .switch-label {
        background-color: #3f51b5;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
    }
    .switch-input:checked ~ .switch-label:before {
        opacity: 0;
    }
    .switch-input:checked ~ .switch-label:after {
        opacity: 1;
    }
    .switch-handle {
        position: absolute;
        top: 4px;
        left: 4px;
        width: 38px;
        height: 48px;
        background: linear-gradient(to bottom, #FFFFFF 40%, #f0f0f0);
        background-image: -webkit-linear-gradient(top, #FFFFFF 40%, #f0f0f0);
        border-radius: 100%;
        box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
    }
    .switch-handle:before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -6px 0 0 -6px;
        width: 12px;
        height: 12px;
        background: linear-gradient(to bottom, #eeeeee, #FFFFFF);
        background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF);
        border-radius: 6px;
        box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
    }
    .switch-input:checked ~ .switch-handle {
        left: 94px;
        box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
    }

    /* Transition
    ========================== */
    .switch-label, .switch-handle {
        transition: All 0.3s ease;
        -webkit-transition: All 0.3s ease;
        -moz-transition: All 0.3s ease;
        -o-transition: All 0.3s ease;
    }

    .card {
        height: 410px; /* Adjust the height as needed */
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
                    showConfirmButton: false,
                    timer: 3000 // Close the alert after 3 seconds
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
                    showConfirmButton: false,
                    timer: 3000 // Close the alert after 3 seconds
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
            <div class="row">
                <div class="col">
                    <ol class="breadcrumb float-sm-left">
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_GET['id'])) {
        $key_child = $_GET['id'];

        $ref_table = 'plants';
        $getData = $database->getReference($ref_table)->getChild($key_child)->getValue();

        if ($getData > 0) {
            ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-3">
                        <!-- Main content -->
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="card">
                                    <div class="card-header">
                                        <?= $getData['plant_name']; ?>
                                    </div>
                                    <div class="card-body text-center">
                                        <?php
                                        // Check if the 'plant_photo' key exists in the data
                                        if (isset($getData['plant_photo'])) {
                                            $plantPhotoURL = $getData['plant_photo'];
                                            ?>
                                            <img src="<?= $plantPhotoURL ?>" alt="Plant Photo" style="max-width: 300px; height:300px;">
                                            <?php
                                        } else {
                                            ?>
                                            <p>No plant photo available</p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                        <!-- INFO -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card mb-2">
                                <div class="card-header">
                                    PLANT INFORMATION
                                </div>
                                <div class="card-body">
                                    <form class="row g-3" method="post" action="code.php">
                                        <!-- Plant Name -->
                                        <div class="col-md-6">
                                            <label for="plantName">Plant Name</label>
                                            <input type="text" class="form-control" id="plant_name" name="plant_name" placeholder="Lettuce" value="<?= $getData['plant_name']; ?>" readonly>
                                        </div>
                                        <!-- Required pH Level -->
                                        <div class="col-md-3">
                                        <label for="plantName">Required pH lvl</label>
                                            <label for="ph_lvl_low"></label>
                                            <input type="text" class="form-control text-center" id="ph_lvl_low" name="ph_lvl_low" placeholder="Low pH Level" value="<?= $getData['ph_lvl_low']; ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                        <label for="plantName" class="text-white">level</label>
                                            <label for="ph_lvl_high"></label>
                                            <input type="text" class="form-control text-center" id="ph_lvl_high" name="ph_lvl_high" placeholder="High pH Level" value="<?= $getData['ph_lvl_high']; ?>" readonly>
                                        </div>
                                        <!-- Date Planted -->
                                        <div class="col-md-6">
                                            <label>Date Planted</label>
                                            <div class="input-group date">
                                            <input type="text" class="form-control" id="date_planted" name="date_planted" value="<?= date('M d, Y', strtotime($getData['date_planted'])); ?>" readonly>
                                                <div class="input-group-append" data-target="#reservationdate">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Estimated Date Harvested -->
                                        <div class="col-md-6">
                                            <label>
                                                <?php
                                                if ($getData['plant_status'] == 'Withered') {
                                                    echo 'Withered Date';
                                                } elseif ($getData['plant_status'] == 'Harvested') {
                                                    echo 'Harvested Date';
                                                } else {
                                                    echo 'Estimated Date Harvested';
                                                }
                                                ?>
                                            </label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" id="dateHarvested" readonly value="<?= ($getData['plant_status'] == 'Withered' || $getData['plant_status'] == 'Harvested') ? date('M d, Y', strtotime($getData['claim_date'])) : date('M d, Y', strtotime($getData['date_harvest'])) ?>" >
                                                <div class="input-group-append" data-target="#reservationdate">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label>BAY</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" id="bay" name="bay" placeholder="bay" value="<?= $getData['bay']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Placement</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" id="nft" name="nft" placeholder="nft"  value="<?= $getData['nft']; ?>" readonly>
                                            </div>
                                        </div>

                                        <?php
                                        $isWitheredOrHarvested = ($getData['plant_status'] == 'Withered' || $getData['plant_status'] == 'Harvested');
                                        $isPlanted = ($getData['plant_status'] == 'Planted');
                                        ?>
                                        <div class="col-md-6">
                                            <label>Plant Status</label>
                                            <select class="form-control" name="plant_status" id="plantStatusSelect" name="plant_status" <?= $isWitheredOrHarvested ? 'disabled' : '' ?>>
                                                <option value="" disabled>Select Plant Status</option>
                                                <option value="Planted" <?= $isPlanted ? 'selected' : '' ?>>Planted</option>
                                                <option value="Harvested" <?= ($getData['plant_status'] == 'Harvested') ? 'selected' : '' ?>>Harvested</option>
                                                <option value="Withered" <?= ($getData['plant_status'] == 'Withered') ? 'selected' : '' ?>>Withered</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $key_child ?>">
                                        <div class="col-md-12 text-right mb-3">
                                            <button type="submit" class="btn btn"  style="background-color: #3f51b5 !important; color:white;" id="updateStatusButton" <?= ($isWitheredOrHarvested || $isPlanted) ? 'disabled' : '' ?>>Update Status</button>
                                        </div>



                                    </form>
                                </div>
                            </div>
                        </div>


                            <div class="col-lg-2 col-md-6 mt-6">
                                <div class="card">
                                    <div class="card-header">
                                        PUMP CONTROL
                                    </div>
                                    <div class="card-body" style="min-height: 330px;">
                                        <!-- Switch for Relay 1 -->
                                        <div class="mb-4 text-center">
                                            <label for="relay1Checkbox">Higher pH Level</label>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <label class="switch">
                                                    <input class="switch-input" type="checkbox" id="relay1Checkbox" checked onchange="toggleRelay(1)" />
                                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                                    <span class="switch-handle"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Switch for Relay 2 -->
                                        <div class="text-center">
                                            <label for="relay2Checkbox">Lower pH Level</label>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <label class="switch">
                                                    <input class="switch-input" type="checkbox" id="relay2Checkbox" checked onchange="toggleRelay(2)" />
                                                    <span class="switch-label" data-on="On" data-off="Off"></span>
                                                    <span class="switch-handle"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3">
    <div class="text-center">
        <input id="knob" type="text" class="knob" value="39" data-skin="tron" data-thickness="0.2" data-width="250" data-height="250" data-fgColor="#3f51b5" readonly>
        <div class="knob-label"><b>Days before Harvest</b></div>
    </div>
</div>

        <?php

    } else {
        $_SESSION['status'] = "Invalid ID!";
        header('Location: index.php');
        exit();
    }

} else {
    $_SESSION['status'] = "No Record Found!";
    header('Location: index.php');
    exit();
}

?>

<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';


    $database = $factory->createDatabase();

    $plantId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($plantId) {
        $plantInfoRef = $database->getReference('/plants')->getChild($plantId);
        $plantInfo = $plantInfoRef->getValue();

        if ($plantInfo) {
            $requiredLowPhLevel = $plantInfo['ph_lvl_low'];
            $requiredHighPhLevel = $plantInfo['ph_lvl_high'];

            // Perform the pH level check and notification creation
            function checkPhLevel($requiredLowPhLevel, $requiredHighPhLevel, $database, $plantInfo) {
                $phSensorDataRef = $database->getReference('/phSensorData');
                $latestPhSensorData = $phSensorDataRef->orderByKey()->limitToLast(1)->getSnapshot()->getValue();
                $latestPhValue = reset($latestPhSensorData);
            }

            // Call the pH level check function
        } else {
            echo 'Plant information not found.' . PHP_EOL;
        }
    } else {
        echo 'Invalid plant ID.' . PHP_EOL;
    }
?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-md-6">
                <!-- Interactive2 data -->
                <div class="card  card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <!-- <i class="fa-solid fa-scale-unbalanced-flip"></i> -->
                            Current pH Level
                        </h3>
                        <div class="card-tools">
                            <div id="realtime2">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="ph-value"></div>
                    </div>
                    <!-- /.card-body-->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-lg-9 col-md-6">
                <!-- Interactive chart -->
                <div class="card  card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <!-- <i class="far fa-chart-bar"></i> -->
                          Water pH Level
                        </h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="interactive" style="height: 300px;"></div>
                    </div>
                    <!-- /.card-body-->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    </div>
    </div>

</section>


</div>
</div>
</div>
</div>




<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>


<script>
            // Initialize Firebase
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

        // Get a reference to the Firebase database
        var database = firebase.database();

        // Function to update UI based on relay status
        function updateUI(relayNumber, relayStatus, disabled) {
            const checkboxId = `relay${relayNumber}Checkbox`;
            const checkbox = document.getElementById(checkboxId);

            // Update checkbox state based on relay status
            checkbox.checked = relayStatus === 'on';

            // Disable the checkbox if disabled is true
            checkbox.disabled = disabled;

            // Update the switch label for correct display
            const switchLabel = checkbox.nextElementSibling;
            switchLabel.dataset.on = relayStatus === 'on' ? 'On' : 'Off';
            switchLabel.dataset.off = relayStatus === 'on' ? 'Off' : 'On';
        }



            // Function to get the status of the other relay
            function getOtherRelayStatus(currentRelayNumber) {
                const otherRelayNumber = currentRelayNumber === 1 ? 2 : 1;
                const otherRelayStatusRef = database.ref(`/relay/${otherRelayNumber}/switch`);

                return otherRelayStatusRef.once('value').then(snapshot => {
                    return snapshot.val();
                });
            }

            // Function to toggle Relay
            function toggleRelay(relayNumber) {
                const relayRef = database.ref(`/relay/${relayNumber}`);
                relayRef.once('value').then(snapshot => {
                    const currentStatus = snapshot.child('switch').val();
                    const disabled = snapshot.child('disabled').val();

                    // If the current relay is disabled, exit
                    if (disabled) return;

                    const newStatus = currentStatus === 'on' ? 'off' : 'on';

                    relayRef.child('switch').set(newStatus)
                        .then(() => {
                            updateUI(relayNumber, newStatus, disabled);
                            console.log(`Switch ${relayNumber} toggled successfully.`);
                        })
                        .catch(error => {
                            console.error(`Error toggling switch ${relayNumber}: ${error.message}`);
                        });
                });
            }


        // Monitor changes in the relay status and update the UI
        function monitorRelayStatus(relayNumber) {
            const relayRef = database.ref(`/relay/${relayNumber}`);
            const disabledRef = database.ref(`/relay/${relayNumber}/disabled`);

            relayRef.on('value', snapshot => {
                const relayStatus = snapshot.child('switch').val();

                // Get the disabled status of the relay
                disabledRef.once('value').then(disabledSnapshot => {
                    const disabled = disabledSnapshot.val();
                    updateUI(relayNumber, relayStatus, disabled);

                    });
                });
            }

            // Call monitorRelayStatus for each relay you want to monitor
            monitorRelayStatus(1);
            monitorRelayStatus(2);

                    // Disable the other switch if one is turned on
                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        const relayNumber = this.id === 'relay1Checkbox' ? 1 : 2;
                        const otherRelayNumber = relayNumber === 1 ? 2 : 1;
                        const otherSwitch = document.getElementById(`relay${otherRelayNumber}Checkbox`);
                        if (this.checked) {
                            otherSwitch.disabled = true;
                        } else {
                            // Check the status of the other switch in Firebase
                            const otherRelayStatusRef = database.ref(`/relay/${otherRelayNumber}/switch`);
                            otherRelayStatusRef.once('value').then(snapshot => {
                                const otherSwitchStatus = snapshot.val();
                                if (otherSwitchStatus === 'off') {
                                    otherSwitch.disabled = false;
                                }
                            });
                        }
                    });
                });

        // Function to check pH level and control switches
        function checkAndUpdateSwitches() {
            // Get current pH level data from Firebase
            database.ref('/phSensorData').once('value').then(snapshot => {
                const phSensorData = snapshot.val();
                const latestPhValue = phSensorData ? phSensorData[Object.keys(phSensorData).pop()] : null;

                if (!latestPhValue) return; // If no pH data available, exit

                // Get plant pH level range from Firebase or any other source
                const plantId = <?php echo json_encode($plantId); ?>;
                database.ref(`/plants/${plantId}`).once('value').then(plantSnapshot => {
                    const plantInfo = plantSnapshot.val();
                    if (!plantInfo || !('ph_lvl_low' in plantInfo) || !('ph_lvl_high' in plantInfo)) return; // If plant info incomplete, exit

                    const requiredLowPhLevel = plantInfo['ph_lvl_low'];
                    const requiredHighPhLevel = plantInfo['ph_lvl_high'];

                    // Determine if pH level is within the acceptable range
                    if (latestPhValue >= requiredLowPhLevel && latestPhValue <= requiredHighPhLevel) {
                        // pH level is within the acceptable range, turn off relay 1 and relay 2
                        database.ref('/relay/1/disabled').set(true);
                        database.ref('/relay/2/disabled').set(true);
                        // Also turn off the switch under relay
                        database.ref('/relay/1/switch').set('off');
                        database.ref('/relay/2/switch').set('off');

                    } else {
                        // pH level is outside the acceptable range, enable the switches
                        database.ref('/relay/1/disabled').set(false);
                        database.ref('/relay/2/disabled').set(false);
                        database.ref('/relay/1/switch').set('off');
                        database.ref('/relay/2/switch').set('off');
                    }
                });
            });
        }


        // Call the function to check pH level and control switches
        checkAndUpdateSwitches();
</script>


<script>
        // Function to check if switches should be disabled
        function checkSwitch() {
            // Make an AJAX request to your PHP script with a plant ID
            var plantId = <?php echo json_encode($plantId); ?>;
            $.ajax({
                url: 'switch_row.php',
                method: 'GET',
                data: { id: plantId },
                success: function(response) {
                    console.log(response);

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // Set an interval to periodically check for switch status
        setInterval(checkSwitch, 60000); // 1000 milliseconds = 1 second, adjust as needed
</script>


<?php
include('includes/footer.php');
?>

<script>
// Use JavaScript to periodically check the server for notifications
function checkNotifications() {
    // Make an AJAX request to your PHP script with a plant ID
    var plantId = <?php echo json_encode($plantId); ?>;

    $.ajax({
        url: 'fetch_data.php',
        method: 'GET',
        data: { id: plantId },
        success: function(response) {
            // Display the result in the console (you can modify this part)
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Set an interval to periodically check for notifications
setInterval(checkNotifications, 10000); // 3000 milliseconds = 3 seconds, adjust as needed
</script>



<!-- FLOT CHARTS -->
<script src="plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="plugins/flot/plugins/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="plugins/flot/plugins/jquery.flot.pie.js"></script>
<!-- AdminLTE for demo purposes -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>


<!-- RealTime Ph lvl Chart -->

<script>
$(function () {
    var maxDataPoints = 15; // Update max data points to 15
    var chart;

    function updateChart() {
        $.ajax({
            url: 'ph-sensor-result.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data) {
                    var phValues = Object.values(data);
                    var startIndex = Math.max(0, phValues.length - maxDataPoints);
                    var slicedPhValues = phValues.slice(startIndex);

                    var xValues = Array.from({ length: slicedPhValues.length }, (_, i) => i + 1); // Start x-axis from 1

                    var trace = {
                        x: xValues,
                        y: slicedPhValues,
                        type: 'scatter',
                        mode: 'lines+markers+text', // Add text to the lines and markers
                        line: { width: 2, shape: 'spline' },
                        text: slicedPhValues.map(value => value.toFixed(1)), // Format pH result to one decimal place
                        textposition: 'top center', // Position of the text
                        fill: 'tozeroy',
                        fillcolor: 'rgba(60, 141, 188, 0.2)',
                        marker: { color: '#3c8dbc' }
                    };

                    // Clear existing chart
                    if (chart) {
                        Plotly.purge('interactive');
                    }

                    chart = Plotly.newPlot('interactive', [trace], {
                        margin: { t: 0, b: 40, l: 30, r: 10 },
                        xaxis: { range: [1, slicedPhValues.length] }, // Start x-axis from 1
                        yaxis: { range: [Math.min(...slicedPhValues) - 0.1, 15] } // Set max value of y-axis to 15
                    });
                }
            },
            complete: function () {
                setTimeout(updateChart, 1500);
            }
        });
    }

    updateChart();

    $('#realtime .btn').click(function () {
        if ($(this).data('toggle') === 'on') {
            updateChart();
        } else {
            clearTimeout(updateChart);
        }
    });
});
</script>


<!-- jQuery Knob -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>

<script>
$(function () {
    /* jQueryKnob */
    $('#knob').knob({
        draw: function () {
            // "tron" case
            if (this.$.data('skin') == 'tron') {
                var a = this.angle(this.cv) // Angle
                ,
                    sa = this.startAngle // Previous start angle
                ,
                    sat = this.startAngle // Start angle
                ,
                    ea // Previous end angle
                ,
                    eat = sat + a // End angle
                ,
                    r = true

                this.g.lineWidth = this.lineWidth

                this.o.cursor && (sat = eat - 0.3) && (eat = eat + 0.3)

                if (this.o.displayPrevious) {
                    ea = this.startAngle + this.angle(this.value)
                    this.o.cursor && (sa = ea - 0.3) && (ea = ea + 0.3)
                    this.g.beginPath()
                    this.g.strokeStyle = this.previousColor
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
                    this.g.stroke()
                }

                this.g.beginPath()
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
                this.g.stroke()

                this.g.lineWidth = 2
                this.g.beginPath()
                this.g.strokeStyle = this.o.fgColor
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
                this.g.stroke()

                return false
            }
        }
    });

    function updateDaysBeforeHarvest() {
        // Get the date_harvest value from the HTML element or use the one retrieved from your PHP code
        var dateHarvest = new Date($('#dateHarvested').val());

        // Calculate the difference in days between the current date and date_harvest
        var currentDate = new Date();
        var daysBeforeHarvest = Math.ceil((dateHarvest - currentDate) / (1000 * 60 * 60 * 24));

        // Update the Knob chart with the calculated value
        $('#knob').val(daysBeforeHarvest).trigger('change');
        $('.knob-label').html('<b>Days before Harvest</b>');
    }

    updateDaysBeforeHarvest(); // Initial update

    // Set up a timer to update the Knob chart every 24 hours (adjust as needed)
    setInterval(updateDaysBeforeHarvest, 24 * 60 * 60 * 1000); // 24 hours in milliseconds
});
</script>


<!-- Realtime Ph Lvl DATA-->
<script>
    $(function () {
        function updateData() {
            $.ajax({
                url: 'ph-sensor-result.php', // Update with the correct endpoint
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        var phValues = Object.values(data);
                        var latestPhValue = phValues[phValues.length - 1];

                        // Format pH value to one whole number and one decimal
                        latestPhValue = parseFloat(latestPhValue).toFixed(1);

                        // Update the text element with the latest pH value and pH level text
                        $('.ph-value').html('<div class="ph-value-text">pH level</div><div class="ph-value-number">' + latestPhValue + '</div>');
                    }
                },
                complete: function () {
                    setTimeout(updateData, 1500);
                }
            });
        }

        // Start updating data
        updateData();

        // Toggle chart updating
        $('#realtime2 .btn').click(function () {
            if ($(this).data('toggle') === 'on') {
                updateData();
            } else {
                // Clear the update interval
                clearTimeout(updateData);
            }
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Reference to your database
        var notificationsRef = firebase.database().ref("notifications");

        // Initialize an object to store data by bay and plant
        var dataByBayAndPlant = {};

        // Function to retrieve current data from Firebase and populate dropdowns
        function updateCurrentDataBar() {
            notificationsRef.on("value", function (snapshot) {
                // Reset dataByBayAndPlant
                dataByBayAndPlant = {};

                // Iterate over the snapshot
                snapshot.forEach(function (childSnapshot) {
                    var data = childSnapshot.val();
                    var bay = data.bay_name;
                    var plant = data.plant_name;
                    var status = data.status;

                    // Create or update data entry for the specific bay, plant, and status
                    if (!dataByBayAndPlant[bay]) dataByBayAndPlant[bay] = {};
                    if (!dataByBayAndPlant[bay][plant]) dataByBayAndPlant[bay][plant] = { low: 0, high: 0 };
                    if (status === "Low") {
                        dataByBayAndPlant[bay][plant].low++;
                    } else if (status === "High") {
                        dataByBayAndPlant[bay][plant].high++;
                    }
                });

                // Update the bar chart
                updateBarChart(dataByBayAndPlant);
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
            var plantLabels = Object.keys(data[bayLabels[0]]); // Assuming the first bay has all plants

            var datasets = [];
            plantLabels.forEach(function (plant) {
                var lowData = [];
                var highData = [];
                bayLabels.forEach(function (bay) {
                    if (data[bay][plant]) {
                        lowData.push(data[bay][plant].low || 0);
                        highData.push(data[bay][plant].high || 0);
                    } else {
                        lowData.push(0);
                        highData.push(0);
                    }
                });
                datasets.push({
                    label: plant + ' (Low)',
                    backgroundColor: '#0057b2',
                    borderColor: 'rgba(60,141,188,0.8)',
                    data: lowData,
                });
                datasets.push({
                    label: plant + ' (High)',
                    backgroundColor: '#FF7B5F',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    data: highData,
                });
            });

            // Create new chart
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: bayLabels,
                    datasets: datasets,
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
                }
            });
        }

        // Call updateCurrentDataBar to fetch data and update the bar chart
        updateCurrentDataBar();

        // Add event listeners to dropdowns for filtering
        document.getElementById("Plants").addEventListener('change', filterData);
        document.getElementById("Bays").addEventListener('change', filterData);

        // Function to filter data based on dropdown selection
        function filterData() {
            var selectedPlant = document.getElementById("Plants").value;
            var selectedBay = document.getElementById("Bays").value;

            // If both are 'all', then show all data
            if (selectedPlant === 'all' && selectedBay === 'all') {
                updateBarChart(dataByBayAndPlant);
                return;
            }

            // Filter data based on selected plant and bay
            var filteredData = {};
            if (selectedBay !== 'all') {
                if (selectedPlant === 'all') {
                    filteredData = dataByBayAndPlant[selectedBay] || {};
                } else {
                    filteredData[selectedBay] = dataByBayAndPlant[selectedBay] ? { [selectedPlant]: dataByBayAndPlant[selectedBay][selectedPlant] } : {};
                }
            } else {
                if (selectedPlant === 'all') {
                    filteredData = dataByBayAndPlant;
                } else {
                    for (var bay in dataByBayAndPlant) {
                        if (dataByBayAndPlant[bay][selectedPlant]) {
                            filteredData[bay] = { [selectedPlant]: dataByBayAndPlant[bay][selectedPlant] };
                        }
                    }
                }
            }

            // Update the bar chart with filtered data
            updateBarChart(filteredData);
        }
    });
</script>
