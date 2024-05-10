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


    /* Define the font style for card title */
    .card-title {
        font-size: 18px;
        font-weight: bold;
        color: #333; /* Adjust color as needed */
    }

    /* Define the font style for the rest of the content */
    .card-body p {
        font-size: 16px;
        color: #666; /* Adjust color as needed */
    }
</style>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0"></h1>
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
        <div class="row">
            <!-- Centered column -->
            <div class="col-md-6 mx-auto">
                <!-- general form elements -->
                <div class="card card">
                    <div class="card-header">
                        <h3 class="card-title">All Notifications</h3>
                    </div>
                    <div class="card-body">
                      <!-- Notifications cards -->
                      <?php
                      $ref_table = 'notifications';
                      $fetchdata = $database->getReference($ref_table)->orderByKey()->getValue();

                      if (!empty($fetchdata)) {
                          // Reverse the array to display latest notification first
                          $fetchdata = array_reverse($fetchdata);
                          foreach ($fetchdata as $key => $row) {
                              ?>
                              <div class="card card-secondary notification-card">
                                  <a href="plant-info?id=<?= $row['plant_id']; ?>">
                                      <div class="card-header">
                                          <h3 class="card-title"><?= $row['plant_name']; ?></h3>
                                      </div>
                                      <div class="card-body">
                                          <div class="row">
                                              <div class="col-md-2">
                                                  <img src="<?= $row['plant_photo']; ?>" class="img-circle img-fluid" width="100" alt="plant Image">
                                              </div>
                                              <div class="col-md-10">
                                                  <p><?= $row['message']; ?></p>
                                                  <p><?= $row['current_date']; ?></p>
                                              </div>
                                          </div>
                                      </div>
                                  </a>
                              </div>
                              <?php
                          }
                          // Provide "See More" functionality
                          ?>
                          <div class="text-center">
                              <a href="#" class="btn see-more-btn" style="background-color:#3f51b5; color:white;">See More</a>
                          </div>
                          <?php
                      } else {
                          ?>
                          <div class="alert alert-info" role="alert">
                              No Record Found
                          </div>
                          <?php
                      }
                      ?>
                  </div>

                        <!-- /.Notifications cards -->
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div>
</section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all notification cards
        var notificationCards = document.querySelectorAll('.notification-card');
        // Get the "See More" button
        var seeMoreButton = document.querySelector('.see-more-btn');

        // Hide all notification cards except the latest 5
        for (var i = 0; i < notificationCards.length; i++) {
            if (i >= 5) {
                notificationCards[i].style.display = 'none';
            }
        }

        // Add click event listener to the "See More" button
        seeMoreButton.addEventListener('click', function(event) {
            event.preventDefault();
            // Toggle the visibility of all notification cards
            for (var i = 0; i < notificationCards.length; i++) {
                notificationCards[i].style.display = notificationCards[i].style.display === 'none' ? '' : 'none';
            }
            // Change the button text based on the current visibility
            seeMoreButton.textContent = seeMoreButton.textContent === 'See More' ? 'See Less' : 'See More';
        });
    });
</script>



  <?php
  include('includes/footer.php');
  ?>
