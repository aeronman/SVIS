

<?php
include('../process/checkSuperAdminSession.php');

$id = $_SESSION['id'];
$fullName = $_SESSION['full_name'];
$profilePicture = $_SESSION['profile_picture'];
$qrImage = $_SESSION['qr_image'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Manage Violations</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css">
  <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../images/logo2.webp" />
  
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.php"><h4 class="text-dark">Super Admin</h4></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><h4 class="text-dark">SA</h4></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
              <img src="<?=$profilePicture?>" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="settings.php">
                <i class="ti-settings text-primary"></i> Settings
              </a>
              <a href="../process/logout.php" class="dropdown-item">
                <i class="ti-power-off text-primary"></i> Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
        
          <li class="nav-item">
            <a class="nav-link" href="accounts.php" aria-expanded="false" aria-controls="auth">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Accounts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="violations.php" aria-expanded="false" aria-controls="auth">
              <i class="icon-ban menu-icon"></i>
              <span class="menu-title">Violations</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="archived_accounts.php" aria-expanded="false" aria-controls="auth">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Archived Accounts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="archived_violation.php" aria-expanded="false" aria-controls="auth">
              <i class="icon-ban menu-icon"></i>
              <span class="menu-title">Archived Violations</span>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="manage_violations.php" aria-expanded="false" aria-controls="auth">
              <i class="icon-ban menu-icon"></i>
              <span class="menu-title">Manage Violations</span>
            </a>
          </li>
      
          <li class="nav-item">
            <a class="nav-link" href="logs.php">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Logs</span>
            </a>
          </li>
        </ul>
      </nav>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <h3 class="font-weight-bold">Welcome, <?=$fullName?></h3>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <h2>Violations and Sanctions</h2>
              <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addViolationModal">Add Violation</button>
              <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table id="violationsTable" class="table table-striped">
                  <thead>
                    <tr>
                      <th>Violation Name</th>
                      <th>Description</th>
                      <th>Offense Count</th>
                      <th>Sanction Details</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Rows will be populated from AJAX -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Modal for Adding Violation -->
          <div class="modal fade" id="addViolationModal" tabindex="-1" aria-labelledby="addViolationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addViolationModalLabel">Add Violation</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="addViolationForm">
                    <div class="form-group">
                      <label for="violationName">Violation Name</label>
                      <input type="text" class="form-control" id="violationName" name="violationName" required>
                    </div>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="offenseCount">Offense Count</label>
                      <select class="form-control" id="offenseCount" name="offenseCount">
                        <option value="1">1st Offense</option>
                        <option value="2">2nd Offense</option>
                        <option value="3">3rd Offense</option>
                        <option value="4">4th Offense</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="sanctionDetails">Sanction Details</label>
                      <textarea class="form-control" id="sanctionDetails" name="sanctionDetails" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Violation</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal for Editing Violation -->
          <div class="modal fade" id="editViolationModal" tabindex="-1" aria-labelledby="editViolationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editViolationModalLabel">Edit Violation</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="editViolationForm">
                    <input type="hidden" id="editViolationId" name="violation_id">
                    <div class="form-group">
                      <label for="editViolationName">Violation Name</label>
                      <input type="text" class="form-control" id="editViolationName" name="violationName" required>
                    </div>
                    <div class="form-group">
                      <label for="editDescription">Description</label>
                      <textarea class="form-control" id="editDescription" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="editOffenseCount">Offense Count</label>
                      <select class="form-control" id="editOffenseCount" name="offenseCount">
                        <option value="1">1st Offense</option>
                        <option value="2">2nd Offense</option>
                        <option value="3">3rd Offense</option>
                        <option value="4">4th Offense</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="editSanctionDetails">Sanction Details</label>
                      <textarea class="form-control" id="editSanctionDetails" name="sanctionDetails" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Violation</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {

   // Initialize DataTable
var table = $('#violationsTable').DataTable({
    ajax: {
        url: '../process/fetch_violations_and_sanctions.php', // Change to your AJAX URL
        dataSrc: ''
    },
    columns: [
        { data: 'violation_name' },
        { data: 'description' },
        { data: 'offense_count' },
        { data: 'sanction_details' },
        {
            data: null,
            render: function(data, type, row) {
                return `
                    <button class="btn btn-warning edit-btn" data-id="${row.violation_id}">Edit</button>
                    <button class="btn btn-danger delete-btn" data-id="${row.violation_id}">Delete</button>
                `;
            }
        }
    ],
    // Add buttons for exporting
    dom: 'Bfrtip', // Positioning of the buttons
    buttons: [
        {
            extend: 'excelHtml5',
            text: 'Export to Excel',
            className: 'btn btn-success',
            title: 'Violations and Sanctions',
            exportOptions: {
                columns: ':visible' // Specify which columns to export
            }
        },
        {
            extend: 'pdfHtml5',
            text: 'Export to PDF',
            className: 'btn btn-danger',
            title: 'Violations and Sanctions',
            exportOptions: {
                columns: ':visible' // Specify which columns to export
            }
        },
        {
            extend: 'print',
            text: 'Print Table',
            className: 'btn btn-info',
            title: 'Violations and Sanctions',
            exportOptions: {
                columns: ':visible' // Specify which columns to print
            }
        }
    ]
});
    // Handle Add Violation Form Submission
    $('#addViolationForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        $.post('../process/add_edit_violation.php', formData, function(response) {
            const data = JSON.parse(response);
            alert(data.message);
            if (data.status === 'success') {
                location.reload(); // Reload the table
            }
        });
    });
// Handle Edit Button Click
$('#violationsTable tbody').on('click', '.edit-btn', function() {
    const data = table.row($(this).parents('tr')).data();
    const violationId = data.violation_id;
    const violationName = data.violation_name;
    const description = data.description;
    const offenseCount = data.offense_count;
    const sanctionDetails = data.sanction_details;

    // Populate edit modal with data
    $('#editViolationId').val(violationId);
    $('#editViolationName').val(violationName);
    $('#editDescription').val(description);
    $('#editOffenseCount').val(offenseCount);
    $('#editSanctionDetails').val(sanctionDetails);

    // Show the edit modal
    $('#editViolationModal').modal('show');
});

// Handle Edit Violation Form Submission
$('#editViolationForm').submit(function(e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.post('../process/add_edit_violation.php', formData, function(response) {
        const data = JSON.parse(response);
        alert(data.message);
        if (data.status === 'success') {
            table.ajax.reload(); // Reload the DataTable
            $('#editViolationModal').modal('hide'); // Hide the edit modal
        }
    });
});

// Handle Delete Button Click
$('#violationsTable tbody').on('click', '.delete-btn', function() {
    const violationId = table.row($(this).parents('tr')).data().violation_id;
    if (confirm('Are you sure you want to delete this violation?')) {
        $.post('../process/delete_violations.php', { violation_id: violationId }, function(response) {
            const data = JSON.parse(response);
            alert(data.message);
            if (data.status === 'success') {
                table.ajax.reload(); // Reload the DataTable
            }
        });
    }
});

});

 </script>

      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
 


  <!-- plugins:js -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../vendors/chart.js/Chart.min.js"></script>
  <script src="../vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="../js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>
  <script src="../js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->

  <!-- JavaScript for handling modals and AJAX -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
</body>
</html>


