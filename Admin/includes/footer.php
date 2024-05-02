<footer class="main-footer text-center">
      <strong>Copyright &copy; 2023-2024</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
      </div>
    </footer>
  </div>
</section>
</div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- JavaScript function to toggle dark mode -->

<script>
  const darkModeButton = document.getElementById('darkModeButton');
  const body = document.body;

  darkModeButton.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
  });
</script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.5/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.5/firebase-database.js"></script>


<script>
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

var notificationsRef = firebase.database().ref('notifications');

var latestNotifications = [];

notificationsRef.on('child_added', function(snapshot) {
  var notification = snapshot.val();

  if (!notification.isRead) {
    // Update the notification count only for unread notifications
    var notificationCount = parseInt($('#notification-count').text());
    $('#notification-count').text(notificationCount + 1);
  }

  // Only add unread notifications to the latestNotifications array
  if (!notification.isRead) {
    latestNotifications.unshift({ id: snapshot.key, ...notification });
    latestNotifications = latestNotifications.slice(0, 5);
  }

  $('#notifications-list').empty();

  for (var i = 0; i < latestNotifications.length; i++) {
    var notificationItem = latestNotifications[i];
    $('#notifications-list').append(
      '<a href="plant-info?id=' + notificationItem.plant_id + '" class="dropdown-item" data-notification-id="' + notificationItem.id + '">' +
      '<div class="callout callout-success">' +
      '<div class="media">' +
      '<img src="' + notificationItem.plant_photo + '" alt="User Avatar" class="img-size-50 mr-3 img-circle">' +
      '<div class="media-body">' +
      '<h3 class="dropdown-item-title">' +
      '<strong>' + notificationItem.plant_name + '</strong><br>' +
      '<p class="text-sm text-muted">' + notificationItem.message + '</p>' +
      '<p class="text-sm text-muted">' + notificationItem.current_date + '</p>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</a>' +
      '<div class="dropdown-divider"></div>'
    );
  }

  // Show or hide the notification count based on the number of notifications
  if (latestNotifications.length > 0) {
    $('#notification-count').text('(' + latestNotifications.length + ')');
  } else {
    $('#notification-count').text('');
  }
});

// Add click event to mark all notifications as read
$('#notification-bell').on('click', function() {
  // Mark all unread notifications as read in the Firebase Realtime Database
  notificationsRef.once('value', function(snapshot) {
    snapshot.forEach(function(childSnapshot) {
      var notificationId = childSnapshot.key;
      var notification = childSnapshot.val();

      if (!notification.isRead) {
        notificationsRef.child(notificationId).update({
          isRead: 1
        });
      }
    });
  });

  // Reset the notification count
  $('#notification-count').text('');
});



</script>

<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<script>
  $(function () {
    $("#example1").DataTable({
      "paging": false, // Disable pagination
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": false,
    "autoWidth": false,
    "responsive": false,

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#myTable').DataTable({
    "paging": false, // Disable pagination
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": false,
    "autoWidth": false,
    "responsive": false
    })

//     $('#myTable').DataTable({
//       "paging": false, // Disable pagination
//         "lengthChange": true,
//         "searching": false,
//         "ordering": true,
//         "info": false,
//         "autoWidth": true,
//         "responsive": false
// });
$(document).ready(function() {
    $('#myTable2').DataTable({
        "paging": false, // Disable pagination
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": true,
        "responsive": false
    });

    });
    $('#myTable3').DataTable({
      "paging": false, // Disable pagination
    "lengthChange": true,
    "searching": false,
    "ordering": true,
    "info": false,
    "autoWidth": true,
    "responsive": false,

    });
    $('#myTable4').DataTable({
      "paging": false, // Disable pagination
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": false,

    });
    $('#myTable5').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": false,
    });
    $('#myTable6').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": false,
    });
    $('#myTable7').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": false,
    });
  });
</script>

</body>
</html>
