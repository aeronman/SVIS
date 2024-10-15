<?php

require_once '../process/db_connection.php';
include('../process/checkFacultySession.php');
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
  <title>Add Violation</title>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- QR Code Scanner Library -->
    <script src="../node_modules/html5-qrcode/html5-qrcode.min.js"></script>
  <script src="ajax.js"></script>
 
  <style>
         .hidden {
            display: none;
        }
    </style>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.php"><h4 class="text-dark">Faculty</h4></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><h4 class="text-dark">F</h4></a>
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
          <li class="nav-item dropdown">
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
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="<?=$profilePicture?>" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>
              <a href="../process/logout.php" class="dropdown-item">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
          <li class="nav-item nav-settings d-none d-lg-flex">
            <a class="nav-link" href="#">
              <i class="icon-ellipsis"></i>
            </a>
          </li>
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
            <a class="nav-link" href="violations.php" aria-expanded="false" aria-controls="auth">
              <i class="icon-ban menu-icon"></i>
              <span class="menu-title">Violations</span>
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

        <div class="container mt-5">
                <h2>Add Violation</h2>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Manual Entry</h4>
                        <form id="manualEntryForm">
                            <div class="form-group">
                                <label for="studentId">Student ID</label>
                                <input type="text" class="form-control" id="studentId" name="studentId" required>
                            </div>
                            <button type="button" class="btn btn-primary" id="fetchDetails">Fetch Details</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h4>QR Code Scanner</h4>
                        <div id="scannerStatus">Scanner is not active.</div>
                        <div id="qr-reader" style="width: 100%;"></div>
                        <button type="button" class="btn btn-primary mt-2" id="startScanner">Start Scanner</button>
                        <button type="button" class="btn btn-secondary mt-2" id="stopScanner">Stop Scanner</button>
                    </div>
                </div>
                <div id="studentDetails" class="mt-4">
                    <!-- Student details will be displayed here -->
                </div>
                <div class="modal fade" id="violationModal" tabindex="-1" aria-labelledby="violationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="violationModalLabel">Add Violation</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form id="violationForm">
                                    <input type="hidden" name="studentId" id="violationStudentId">
                                    <div class="form-group">
                                        <label for="fullName">Full Name</label>
                                        <input type="text" class="form-control" id="fullName" name="fullName" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="section">Section</label>
                                        <input type="text" class="form-control" id="section" name="section" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="profilePicture">Profile Picture</label>
                                        <img id="profilePicture" src="" alt="Profile Picture" class="img-fluid">
                                    </div>
                                    <div class="form-group">
                                        <label for="violationType">Violation</label>
                                        <select class="form-control" id="violationType" name="violationType">
                                            <option value="improper_uniform">Improper Uniform</option>
                                            <option value="illegal_items">Illegal Items</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Violation</button>
                                </form>
                            </div>
                        </div>
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

  <script>
       console.log(Html5Qrcode);
       
        $(document).ready(function() {
            let html5QrCode;
            // Handle manual entry form submission
            $('#fetchDetails').click(function() {
                var studentId = $('#studentId').val();
                $.ajax({
                    url: '../process/fetch_student.php',
                    type: 'POST',
                    data: { id: studentId },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            $('#studentDetails').html(`
                                <div>
                                    <h5>Student Details</h5>
                                    <p><strong>Full Name:</strong> ${data.fullName}</p>
                                    <p><strong>Section:</strong> ${data.section}</p>
                                    <img src="${data.profilePicture}" alt="Profile Picture" class="img-fluid">
                                    <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#violationModal">Add Violation</button>
                                </div>
                            `);
                            $('#violationStudentId').val(studentId);
                            $('#fullName').val(data.fullName);
                            $('#section').val(data.section);
                            $('#profilePicture').attr('src', data.profilePicture);
                        } else {
                            alert(data.message);
                        }
                    }
                });
            });
            $('#startScanner').click(function() {
                $('#scannerStatus').text('Scanning...');
                
                html5QrCode = new Html5QrcodeScanner("qr-reader",{
                    qrbox:{
                        width:250,
                        height:250,
                    },
                    fps:20,
                });

                html5QrCode.render(success,error);
                
                    function success(decodedText, decodedResult) {
                        console.log(decodedText);
                        let studentId = decodedText.split(':')[1].trim();
                        $('#studentId').val(studentId);
                        $('#fetchDetails').click();
                        html5QrCode.clear().then(() => {
                            $('#scannerStatus').text('Scanner is not active.');
                        }).catch(err => {
                            console.error("Failed to stop the scan.", err);
                        });
                    }
                    function error (errorMessage) {
                    
                        console.error(`Error: ${errorMessage}`);
                    }
                
                $('#scannerStatus').text('Scanner is active.');
            });

            $('#stopScanner').click(function() {
                if (html5Qrcode) {
                    html5Qrcode.clear().then(() => {
                        $('#scannerStatus').text('Scanner is not active.');
                    }).catch(err => {
                        console.error("Failed to stop the scan.", err);
                    });
                }
            });

           
            // Handle violation form submission
            $('#violationForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '../process/submit_violation.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            alert(data.message);
                            $('#violationModal').modal('hide');
                        } else {
                            alert(data.message);
                        }
                    }
                });
            });
        });
    </script>

  
</body>

</html>

