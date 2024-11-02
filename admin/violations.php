<?php
  include('../process/checkAdminSession.php');
  $id = $_SESSION['id'];
  $fullName = $_SESSION['full_name'];
  $profilePicture = $_SESSION['profile_picture'];
  $qrImage = $_SESSION['qr_image'];



  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Violations</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/logo2.webp" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.dataTables.min.css">
    <script src="ajax.js"></script>
    <style>
          .hidden {
              display: none;
          }
    
          th, td {
              padding: 15px;
              text-align: left;
          }
          th {
              background-color: #f2f2f2;
              font-weight: bold;
              height: 12px; /* Adjust header row height */
          }
          tr {
              height: 50px; /* Adjust row height */
          }
      
      </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo mr-5" href="index.php"><h4 class="text-dark">Admin</h4></a>
          <a class="navbar-brand brand-logo-mini" href="index.php"><h4 class="text-dark">A</h4></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span> 
          </button>
          <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
              <div class="input-group">
                <!-- <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                  <span class="input-group-text" id="search">
                    <i class="icon-search"></i>
                  </span>
                </div> -->
                <!-- <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search"> -->
              </div>
            </li>
          </ul>
          <ul class="navbar-nav navbar-nav-right">
            <!-- <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="icon-bell mx-0"></i>
                <span class="count"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="ti-info-alt mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Application Error</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      Just now
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="ti-settings mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      Private message
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="ti-user mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      2 days ago
                    </p>
                  </div>
                </a>
              </div>
            </li> -->
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                <img src="<?=$profilePicture?>" alt="profile"/>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <a href="settings.php" class="dropdown-item">
                  <i class="ti-settings text-primary"></i>
                  Settings
                </a>
                <a href="../process/logout.php" class="dropdown-item">
                  <i class="ti-power-off text-primary"></i>
                  Logout
                </a>
              </div>
            </li>
            <!-- <li class="nav-item nav-settings d-none d-lg-flex">
              <a class="nav-link" href="#">
                <i class="icon-ellipsis"></i>
              </a>
            </li> -->
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        <div class="theme-setting-wrapper">
          <div id="settings-trigger"><i class="ti-settings"></i></div>
          <div id="theme-settings" class="settings-panel">
            <i class="settings-close ti-close"></i>
            <p class="settings-heading">SIDEBAR SKINS</p>
            <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
            <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
            <p class="settings-heading mt-2">HEADER SKINS</p>
            <div class="color-tiles mx-0 px-4">
              <div class="tiles success"></div>
              <div class="tiles warning"></div>
              <div class="tiles danger"></div>
              <div class="tiles info"></div>
              <div class="tiles dark"></div>
              <div class="tiles default"></div>
            </div>
          </div>
        </div>
        
        <!-- partial -->
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
            <li class="nav-item active">
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
        
       
            <li class="nav-item">
              <a class="nav-link" href="logs.php">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Logs</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome, <?=$fullName?></h3>
                    
                  </div>
                  <div class="col-12 col-xl-4">
                  <!-- <div class="justify-content-end d-flex">
                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                      <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                      </button>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                        <a class="dropdown-item" href="#">January - March</a>
                        <a class="dropdown-item" href="#">March - June</a>
                        <a class="dropdown-item" href="#">June - August</a>
                        <a class="dropdown-item" href="#">August - November</a>
                      </div>
                    </div>
                  </div> -->
                  </div>
                </div>
              </div>
            </div>
            <div id="alertContainer"></div>
            <div class="col-lg-12 grid-margin stretch-card" style="display: flex; justify-content: right;">
              <a href="addviolation.php"><button type="button" class="btn btn-inverse-danger btn-fw">
                  Create Violation Record
              </button></a>
          </div>
      

    
            <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Archive</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                Are you sure you want to archive this record?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                  <input type="hidden" name="id" id="deleteId" value="">
                  <button type="submit" class="btn btn-danger">Archive</button>
                </form>
              </div>
            </div>
          </div>
        </div>



      <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
          <div class="card-body">
          
              <h2>Violation Records</h2>
              <table id="violationsTable" class="display" style="width:100%">
                  <thead>
                      <tr>
                          <th>Record No</th>
                          <th>Full Name</th>
                          <th>Course, Year & Section</th>
                          <th>Violation Type</th>
                          <th>Offense Number</th>
                          <th>Sanction</th>
                          <th>Status</th>
                          <th>Date Recorded</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      <!-- Data will be loaded here by DataTables -->
                  </tbody>
              </table>
          
          </div>
      </div>
  </div>
  <div class="modal fade" id="violationModal" tabindex="-1" aria-labelledby="violationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="violationModalLabel">Edit Violation</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="violationForm">
    <input type="hidden" id="record_id" name="record_id">
    <div class="form-group">
        <label for="violationType">Violation</label>
        <select class="form-control" id="violationType" name="violationType">
            <!-- Options populated dynamically -->
        </select>
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
        <label for="sanction">Sanction</label>
        <p id="sanction" class="form-control" readonly></p>
        <input type="hidden" id="sanction_id" name="sanction_id">
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status">
            <option value="pending">Pending</option>
            <option value="rendering">Rendering</option>
            <option value="completed">Completed</option>
        </select>
    </div>
    <div class="form-group">
        <label for="date_of_offense">Date of Offense</label>
        <input type="date" class="form-control" id="date_of_offense" name="date_of_offense">
    </div>
    <button type="button" id="saveChangesButton" class="btn btn-primary">Save Changes</button>
    <button class="btn btn-danger btn-sm" onclick="deleteViolation($('#record_id').val())">Archive</button>
</form>

            </div>
        </div>
    </div>
</div>


 


          
      
    
        
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
      
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../vendors/chart.js/Chart.min.js"></script>
    <script src="../vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="../js/dataTables.select.min.js"></script>
    
      <!-- DataTables Buttons for Export -->
      <script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.print.min.js"></script>

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

    <script>
         $(document).ready(function() {
          $('#violationsTable').DataTable({
    "ajax": {
        "url": "../process/fetch_violations.php",
        "type": "GET",
        "dataSrc": "data"
    },
    "columns": [
        { "data": "record_id" },
        { "data": "full_name" },
        { "data": "cys" },
        { "data": "violation_name" },
        { "data": "offense_count" },
        { 
            "data": "sanction_details",
            "render": function(data, type, row) {
                return data ? data : 'No sanction';
            }
        },
        { "data": "status" },
        { "data": "date_of_offense" },
        {
            "data": null,
            "render": function(data, type, row) {
                return `
                    <button class="btn btn-info btn-sm" onclick="editViolation('${row.record_id}')">View</button>
                
                `;
            }
        }
    ],
    "processing": true,
    "searching": true,
    "paging": true,
    "ordering": true,
    "order": [], // Disable initial sorting
    dom: 'Bfrtip', // Enable buttons in the DOM
    buttons: [
        {
            extend: 'excelHtml5',
            title: 'Violations Data',
            exportOptions: {
                columns: function (idx, data, node) {
                    // Exclude the last column (index of last column is total columns - 1)
                    const isLastColumn = idx === $('#violationsTable thead th').length - 1;
                    return !isLastColumn;
                }
            }
        },
        {
            extend: 'pdfHtml5',
            title: 'Violations Data',
            exportOptions: {
                columns: function (idx, data, node) {
                    const isLastColumn = idx === $('#violationsTable thead th').length - 1;
                    return !isLastColumn;
                }
            }
        },
        {
            extend: 'print',
            title: 'Violations Data',
            exportOptions: {
                columns: function (idx, data, node) {
                    const isLastColumn = idx === $('#violationsTable thead th').length - 1;
                    return !isLastColumn;
                }
            }
        }
    ]
});


              // Fetch violations to populate the violation dropdown
            function fetchViolations() {
                $.ajax({
                    url: '../process/fetch_violations_dropdown.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#violationType').empty();
                        $.each(data, function(index, violation) {
                            $('#violationType').append($('<option>', {
                                value: violation.violation_id,
                                text: violation.violation_name
                            }));
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching violations:', error);
                    }
                });
            }

            // Fetch sanction details based on violation and offense count
            function fetchSanction(violationId, offenseCount) {
                $.ajax({
                    url: '../process/fetch_sanction.php',
                    type: 'GET',
                    data: {
                        violationId: violationId,
                        offenseCount: offenseCount
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#sanction').text(data.sanction_details || 'No sanction');
                        $('#sanction_id').val(data.sanction_id);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching sanction:', error);
                    }
                });
            }

            // Event listeners to update sanction based on selected violation and offense count
            $('#violationType').change(function() {
                fetchSanction($(this).val(), $('#offenseCount').val());
            });

            $('#offenseCount').change(function() {
                fetchSanction($('#violationType').val(), $(this).val());
            });

            // Initialize modal with fetched violations when opened
            $('#violationModal').on('show.bs.modal', function() {
                fetchViolations();
            });

            $('#saveChangesButton').on('click', function(e) {
                  e.preventDefault(); // Prevent form submission

                  // Gather data from the form
                  const violationData = {
                      record_id: $('#record_id').val(),
                      violation_id: $('#violationType').val(),
                      offense_count: $('#offenseCount').val(),
                      sanction_id: $('#sanction_id').val(),
                      status: $('#status').val(),
                      date_of_offense: $('#date_of_offense').val()
                  };

                  // AJAX request to save changes
                  $.ajax({
                      url: '../process/update_violation.php', // Your PHP file to update the violation
                      type: 'POST',
                      data: violationData,
                      dataType: 'json',
                      success: function(response) {
                          if (response.status === 'success') {
                              alert('Violation updated successfully!');
                              $('#violationsTable').DataTable().ajax.reload(); // Refresh the table
                              $('#violationModal').modal('hide'); // Close the modal
                          } else {
                              alert('Error: ' + response.message);
                          }
                      },
                      error: function(xhr, status, error) {
                          console.error('Error updating violation:', error);
                      }
                  });
              });
          });


                    // Populate modal fields and open modal for editing
            function editViolation(record_id) {
                // Fetch violation data by violation_no
                $.ajax({
                    url: '../process/fetch_single_violation.php',
                    type: 'GET',
                    data: { record_id: record_id },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'success') {
                            const violation = data.data;

                            // Fill in the form fields
                            $('#record_id').val(violation.record_id);
                            $('#violationType').val(violation.violation_id).trigger('change');
                            $('#offenseCount').val(violation.offense_count).trigger('change');
                            $('#sanction').text(violation.sanction_details);
                            $('#sanction_id').val(violation.sanction_id);
                            $('#status').val(violation.status);
                            $('#date_of_offense').val(violation.date_of_offense);

                            // Show the modal
                            $('#violationModal').modal('show');
                        } else {
                            alert('Failed to load violation data.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching violation:', error);
                    }
                });
            }

            

          function deleteViolation(record_id) {
              // Handle delete functionality here
              if (confirm('Are you sure you want to delete the record with violation number : ' + record_id + '?')) {
                $.ajax({
                  url: '../process/delete_violation.php',
                  type: 'POST',
                  data: { record_id: record_id },
                  dataType: 'json',  // Ensure jQuery interprets the response as JSON
                  success: function(response) {
                      console.log(response);  // Debugging the full response
                      if (response.status === 'success') {
                          alert('Record has been archived successfully.');
                          $('#violationsTable').DataTable().ajax.reload();
                      } else {
                          alert('Failed to delete violation record.');
                      }
                  },
                  error: function() {
                      alert('An error occurred while deleting the violation Record.');
                  }
              });

              }
          }
      </script>
  <script>


  function confirmDelete(id) {
      // Set the id in the hidden input field in the delete form
      document.getElementById('deleteId').value = id;
      
      // Show the delete confirmation modal
      var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
      deleteModal.show();
  } 
  </script>
  
  </body>

  </html>

