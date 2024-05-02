<style>
  /* Custom CSS to adjust the width of the notification dropdown */
  .dropdown-menu-lg {
    min-width: 300px; /* Adjust the width as needed */
  }
  .btn-default:hover {
    background-color: #007bff; /* Primary color on hover */
    color: #fff; /* Text color on hover */
  }
  .content-wrapper {
    padding-top: 56px; /* Adjust according to your topbar height */
    padding-bottom: 50px; /* Add padding to the bottom of the content */
  }
    .sidebar {
    width: 250px; /* Adjust sidebar width */
    position: fixed;
    height: 100%;
    overflow-y: auto;
  }
  .nav-item .nav-link {
    background-color: transparent;
  }
  .nav-item.active a {
            color: blue; /* Change color as needed */
            /* Add any other styling for active state */
        }
  .nav-item mr-5 {
    box.shadow: none;
  }

</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>



<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
  <!-- Notif Dropdown Menu -->
  <li class="nav-item dropdown">
    <a id="notification-bell" class="nav-link mr-3" data-toggle="dropdown" href="#">
    <i class="fas fa-bell fa-2 mr-3 mt-2"></i>
      <span id="notification-count" class="badge badge-danger navbar-badge"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notifications-container">
      <div class="dropdown-header" style="background-color:#2C3090;">
        <p class="text-white">Notifications</p>
        <span class="float-right text-muted text-sm"></span>
      </div>
      <div id="notifications-list"></div>
      <a href="all_notification" class="dropdown-footer" style="text-align: center; color:#2C3090;">See All Notifications</a>
    </div>
  </li>


      <?php
        $uid = $_SESSION['verified_user_id'];
        $user = $auth->getUser($uid);

        $userRecord = $auth->getUser($uid);

          // Get the user's creation timestamp
          $creationTimestamp = $userRecord->metadata->createdAt->getTimestamp();

          // Convert timestamp to a human-readable date
          $creationDate = date('M d, Y', $creationTimestamp);

        ?>


<li class="nav-item dropdown user user-menu mr-5">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <?php if ($user->photoUrl !== null) : ?>
            <img src="<?= $user->photoUrl ?>" class="user-image img-fluid rounded-circle elevation-2" alt="User Image">
        <?php else : ?>
            <img src="dist/img/default.png" class="user-image img-fluid rounded-circle elevation-2" alt="User Image">
        <?php endif; ?>
        <span class="hidden-xs"><?= $user->displayName; ?></span>
    </a>

    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- User image -->
        <li class="user-header" style="background-color:#2C3090;">
            <?php if ($user->photoUrl !== null) : ?>
                <img src="<?= $user->photoUrl ?>" class="img-fluid rounded-circle elevation-2" alt="User Image">
            <?php else : ?>
                <img src="dist/img/default.png" class="user-image img-fluid rounded-circle elevation-2" alt="User Image">
            <?php endif; ?>
            <p class="text-white">
                <?= $user->displayName; ?>
                <small>Member since <?= $creationDate; ?></small>
            </p>
        </li>


    <?php
        // Generate a unique token or hash for each user
        $token = hash('sha256', $user->uid); // You can use any hashing algorithm here
        ?>
        <!-- User footer with links -->
        <li class="user-footer">
            <div class="text-center">
                <a href="my-profile" class="btn btn-default btn-flat">Profile</a><br>
                <a href="../logout" class="btn btn-default btn-flat">Sign out</a>
            </div>
        </li>
    </ul>
</li>

  </ul>
  </nav>

  <aside class="main-sidebar sidebar">

    <!-- Sidebar -->
    <div class="sidebar">
       <!-- Brand Logo -->
    <a href="#" class="brand-link text-center">
        <br>
        <img src="pics/logo.png" alt="Logo" class="" style="height: 100px; width: 100px;">
        <h3 style="color: #2C3090; padding-top: 20px;">RLS-NES</h3>
    </a>
    <br>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                <a href="./" class="nav-link">
                <i class="fa-regular fa-objects-column"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                <a href="plants" class="nav-link">
                <i class="fa-solid fa-seedling"></i>
                        <p>Plants</p>
                    </a>
                </li>
                     <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="fa-solid fa-pencil"></i>
                            <p>Maintenance</p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                            <a href="plants_details" class="nav-link">
                                <p style="margin-left: 30px;">PLANTS DETAILS</p>
                                </a>
                            </li>

                            <li class="nav-item">
                            <a href="bay_nft" class="nav-link">
                                <p style="margin-left: 30px;">BAY AND PLACEMENT</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                <li class="nav-item">
                <a href="activities" class="nav-link">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <p>Activities</p>
                    </a>
                </li>
                <?php
                // Redirect unauthorized users to another page
                $uid = $verifiedIdToken->claims()->get('sub');
                $claims = $auth->getUser($uid)->customClaims;
                if(isset($claims['admin']) == true){ ?>


                    <br>
                    <li class="nav-header">USERS</li>
                    <li class="nav-item">
                        <a href="user" class="nav-link">
                            <i class="fa-solid fa-user-group"></i>
                            <p>Manage Users</p>
                        </a>
                    </li>
                    <?php }?>

                    <li class="nav-item">
                    <a href="my-profile" class="nav-link">
                        <i class="fa-solid fa-user-gear"></i>
                        <p>
                            Account Settings
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<script>
  var scrolling = false;
  window.addEventListener("scroll", function() {
    var sidebar = document.querySelector(".sidebar");
    if (window.innerWidth <= 768 && !scrolling) { // Check for mobile device and no scrolling
      sidebar.classList.add("hide");
    }
  });

  window.addEventListener("touchstart", function() {
    scrolling = true;
    var sidebar = document.querySelector(".sidebar");
    if (window.innerWidth <= 768) { // Check for mobile device
      sidebar.classList.add("hide");
    }
  });

  window.addEventListener("touchend", function() {
    scrolling = false;
  });
</script>