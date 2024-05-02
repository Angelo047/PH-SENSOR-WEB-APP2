<?php
include('admin_auth.php');
include('includes/header.php');
include('includes/navbar.php');


// Retrieve the id parameter from the URL
$plant_id = isset($_GET["id"]) ? $_GET["id"] : null;
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

    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php
        $uid = $_SESSION['verified_user_id'];
        $user = $auth->getUser($uid);
        ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="col-md-12">
          <div class="card card-outline">
            <div class="card-header">
              <h2 class="card-title">
              Narrative Report
            </h2>
            </div>

            <?php
                    if(isset($_GET['id']))
                    {
                        $key_child = $_GET['id'];

                        $ref_table = 'plants';
                        $getData = $database->getReference($ref_table)->getChild($key_child)->getValue();

                        $currentDateTime = date('F j, Y'); // You can customize the format

                        if($getData > 0)
                        {
                            ?>
                                      <!-- /.card-header -->
            <div class="card-body" id="compose-textarea">
            <form class="form-horizontal" method="POST" action="">
                <input type="hidden" name="plant_id" value="<?= $plant_id ?>">
              <div class="row">
                <center>
                    <p>Schools Divisions Office - Quezon City</p>
                    <p><strong>ROSA L. SUSANO - NOVALICHES ELEMENTARY SCHOOL</strong></p>
                    <p><i> Quirino Highway, Gulod, Novaliches, Quezon City </i></p>
                    <br>
                    <h2>NARRATIVE REPORT</h2>
                    <br>
                </center>

                <p><strong>Date of Report:</strong> <?php echo $currentDateTime; ?></p>
                <p><strong>Prepared by:</strong> <?=$user->displayName;?></p>

                <br>
                <hr style = width:95%;>
                <br>

                <div class="column">
                  <h3>Plant Information</h3>
                  <p><strong>Plant Name:</strong> <?= $getData['plant_name']; ?></p>
                  <p><strong>Required pH Level:</strong> <?= $getData['ph_lvl_low']; ?>-<?= $getData['ph_lvl_high']; ?></p>
                </div>
                <div class="column">
                  <h3>Cultivation Timeline</h3>
                  <p><strong>Date Planted:</strong> <?= $getData['date_planted']; ?></p>
                  <p><strong>
                  <?php
                    if ($getData['plant_status'] == 'Withered') {
                        echo 'Withered Date: ';
                        } elseif ($getData['plant_status'] == 'Harvested') {
                        echo 'Harvested Date: ';
                         } else {
                          echo 'Estimated Date Harvested: ';
                        }
                    ?>

                  </strong><?= ($getData['plant_status'] == 'Withered' || $getData['plant_status'] == 'Harvested') ? date('M d, Y', strtotime($getData['claim_date'])) : date('M d, Y', strtotime($getData['date_harvest'])) ?></p>
                </div>
              </div>

              <?php
            // Retrieve the draft data if the plant ID is set
            if ($plant_id != '') {
                $draftData = $database->getReference('drafts/' . $plant_id)->getValue();
            } else {
                $draftData = null;
            }
            ?>

              <br>
              <h3>Plant Status</h3>
              <p><strong>Current Health Status:</strong> <?= $getData['plant_status']; ?></p>
              <label for="recentChanges"><strong>Recent Changes: </strong></label>
              <textarea class="form-control" id="recentChanges" name="recentChanges" required><?=(isset($draftData['recentChanges']) ? $draftData['recentChanges'] : '') ?></textarea>


              <h3>Challenges and Solutions</h3>
              <div class="row">
                <div class="column">
                  <label for="Challenges"><strong>Challenges Encountered: </strong></label>
                  <textarea class="form-control" id="Challenges" rows="2" cols="50" maxlength="250" required><?= (isset($draftData['Challenges']) ? $draftData['Challenges'] : '') ?></textarea>
                </div>
                <div class="column">
                  <label for="Solutions"><strong>Solutions Implemented: </strong></label>
                  <textarea class="form-control" id="Solutions" rows="2" cols="50" maxlength="250" required><?= (isset($draftData['Solutions']) ? $draftData['Solutions'] : '') ?></textarea>
                </div>
              </div>


              <h3>Recommendations</h3>
              <div class="row">
                <div class="column">
                  <label for="Improvements"><strong>Improvements: </strong></label>
                  <textarea class="form-control" id="Improvements" rows="2" cols="50" maxlength="250" required><?= (isset($draftData['Improvements']) ? $draftData['Improvements'] : '') ?></textarea>
                </div>
                <div class="column">
                  <label for="Practices"><strong>Best Practices: </strong></label>
                  <textarea class="form-control" id="Practices" rows="2" cols="50" maxlength="250" required><?= (isset($draftData['Practices']) ? $draftData['Practices'] : '') ?></textarea>
                </div>
              </div>



            </form>
          </div>

            <!-- /.card-body -->

          <div class="card-footer">
              <div class="float-right">
                  <button type="button" class="btn btn-primary mr-2" id="pdf-button" onclick="GeneratePdf()">
                      <i class="fas fa-save"></i> PDF
                  </button>
              </div>
          </div>


            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
</div>
</div>
<!-- ./wrapper -->
<?php

}else{
    $_SESSION['status'] = "Invalid ID!";
    header('Location: index.php');
    exit();
}

}else{
$_SESSION['status'] = "No Record Found!";
header('Location: index.php');
exit();
}

?>

<?php
include('includes/footer.php');
?>

<!-- Include the jsPDF library -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"integrity= "sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"crossorigin="anonymous"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2pdf.js@0.10.1/dist/html2pdf.bundle.js"></script>

<script>
$(document).ready(function() {
    // Auto-save data every 10 seconds
    setInterval(saveData, 1000);

    function saveData() {
        var plant_id = <?= json_encode($plant_id) ?>;
        var recentChanges = $('#recentChanges').val().trim();
        var bay_systemOverview = $('#bay_systemOverview').val().trim();
        var bay_performance = $('#bay_performance').val().trim();
        var nft_systemOverview = $('#nft_systemOverview').val().trim();
        var nft_performance = $('#nft_performance').val().trim();
        var Challenges = $('#Challenges').val().trim();
        var Solutions = $('#Solutions').val().trim();
        var Improvements = $('#Improvements').val().trim();
        var Practices = $('#Practices').val().trim();


        if (recentChanges != '' ||
            bay_systemOverview != '' ||
            bay_performance != '' ||
            nft_systemOverview != '' ||
            nft_performance != '' ||
            nft_performance != '' ||
            Challenges != '' ||
            Solutions != '' ||
            Practices != ''
        ) {
            $.ajax({
                url: 'save_draft.php',
                type: 'post',
                data: {
                    plant_id: plant_id,
                    recentChanges: recentChanges,
                    bay_systemOverview: bay_systemOverview,
                    bay_performance: bay_performance,
                    nft_systemOverview: nft_systemOverview,
                    nft_performance: nft_performance,
                    Challenges: Challenges,
                    Solutions: Solutions,
                    Improvements: Improvements,
                    Practices: Practices,
                },
                success: function(response) {
                    $(plant_id).val(response);
                }
            });
        }
    }
});
</script>


<script>

		// Function to GeneratePdf
    function GeneratePdf() {
  var element = document.getElementById('compose-textarea');
  html2pdf(element, {
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2, scrollY: 0 },
    filename: 'Narrative_Report.pdf'
  });
}


function printPage() {
    // Hide unnecessary elements before printing
    $('.content-wrapper').addClass('print-mode'); // Add a class to the content wrapper for print mode styling
    $('.card-footer').hide(); // Hide the card footer buttons
    $('.navbar').hide(); // Hide the navbar
    $('.content-header').hide(); // Hide the content header
    window.print(); // Print the page
    // Show the hidden elements after printing
    $('.content-wrapper').removeClass('print-mode');
    $('.card-footer').show();
    $('.navbar').show();
    $('.content-header').show();
}



</script>