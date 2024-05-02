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

        form {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #3b71ca;
        }

        p {
            margin-bottom: 3px;
        }

        textarea {
            width: 100%;
            height: 80px; /* Set the desired height for textarea */
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 8px;
            resize: none;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-top:0;
        }

        .column {
            width: 48%;
            padding-left: 8px;
        }

        .two-columns {
            display: flex;
            justify-content: space-between;
        }

        .two-columns .column {
            width: 48%;
            padding-left: 8px;
        }


</style>



<!-- Modal for displaying the report -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="">
                    <input type="hidden" name="plant_id" value="<?= $plant_id ?>">
                    <div class="row">
                        <center>
                            <p>Schools Divisions Office - Quezon City</p>
                            <p><strong>ROSA L. SUSANO - NOVALICHES ELEMENTARY SCHOOL</strong></p>
                            <p><i> Quirino Highway, Gulod, Novaliches, Quezon City </i></p>
                            <br>
                            <h2>STABILIZING WATER PH LEVEL REPORT</h2>
                            <br>
                        </center>
                        <div class="column">
                            <p><strong>Date of Report:</strong> <?php $currentDateTime = date('F j, Y'); echo $currentDateTime; ?></p>
                            <p><strong>Prepared by:</strong> <?=$user->displayName;?></p>
                        </div>
                    </div>

                    <hr style="width:95%;">

                    <div class="row">
                        <div class="column">
                            <label for="from">From: <span id="fromDateHolder"></span></label>
                        </div>
                        <div class="column">
                            <label for="to">To: <span id="toDateHolder"></span></label>
                        </div>
                        <div class="column">
                            <label for="status">Status: <span id="statusFilterHolder"></span></label>
                        </div>
                        <div class="column">
                            <label for="plant">Plant: <span id="plantFilterHolder"></span></label>
                        </div>
                    </div>





                    <br>

                    <div class="row">
                        <div class="column">
                            <h3>Summary of Statistics for pH Levels</h3>
                            <p><strong>Mean:</strong> <span id="meanPH"></span></p>
                            <p><strong>Median:</strong> <span id="medianPH"></span></p>
                            <p><strong>Minimum:</strong> <span id="minPH"></span></p>
                            <p><strong>Maximum:</strong> <span id="maxPH"></span></p>
                        </div>

                        <div class="column">
                            <h3>Frequency Counts</h3>
                            <br>
                            <p><strong>Numbers of Log:</strong> <span id="numLogged"></span></p>
                            <p><strong>Low Status:</strong> <span id="LowStatus"></span></p>
                            <p><strong>High Status:</strong> <span id="HighStatus"></span></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="column">
                            <h3>Plant-specific Analysis</h3>
                            <p><strong>Plants with High pH Level:</strong> <span id="highPHPlants"></span></p>
                            <textarea id="highPHPlantsDetails" readonly></textarea>
                        </div>

                        <div class="column">
                            <h3></h3>
                            <br>
                            <p style="margin-top:10px"><strong>Plants with Low pH Level:</strong> <span id="lowPHPlants"></span></p>
                            <textarea id="lowPHPlantsDetails" readonly></textarea>
                        </div>
                    </div>



                    <h3>Status Analysis</h3>
                    <p><strong>Percentage of Activities categorized as:</strong> <span id="statanalysis"></p>
                            <p><strong>Low pH:</strong> <span id="lowpHstat"></span></p>
                            <p><strong>High pH:</strong> <span id="highpHstat"></span></p>

                </form>

            </div>

            <div class="modal-body" id="reportModalBody">
                <!-- Report content will be dynamically generated here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary mr-2" data-dismiss="modal" onclick="closeModal()">Close</button>
                <button type="button" class="btn btn-primary mr-2" id="pdf-button" onclick="GeneratePdf()">
                    <i class="fas fa-save"></i> PDF
                </button>
                <!-- <button type="button" class="btn btn-primary mr-2" id="print-button" onclick="printPage()">
                    <i class="fas fa-print"></i> Print
                </button> -->
            </div>

        </div>

        <div class="card-footer">
            <div class="float-right">
            </div>
        </div>

    </div>
</div>


<!-- Hidden div to hold the modal content for PDF generation -->
<div id="hiddenDiv" style="display: none;"></div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">


<!-- JavaScript code for updating modal content -->
<script>
    // Function to generate PDF
    function GeneratePdf() {
        // Get the content of the modal dynamically
        var content = $('#reportModal .modal-body').html();

        // Generate PDF from the retrieved content
        html2pdf().from(content).save();
    }

    // Function to print the page
    function printPage() {
    // Clone the modal content
    var modalContent = $('#reportModal .modal-body').html();

    // Create a temporary hidden element in the main document
    var tempElement = document.createElement('div');
    tempElement.style.display = 'none';

    // Set the content and styles of the temporary element
    tempElement.innerHTML = modalContent;
    tempElement.style.backgroundColor = 'white'; // Set background color

    // Append the temporary element to the document body
    document.body.appendChild(tempElement);

    // Print the temporary element
    window.print();

    // Remove the temporary element from the document body after printing
    document.body.removeChild(tempElement);
}



    // Function to close the modal
    function closeModal() {
        $('#reportModal').modal('hide');
    }
</script>