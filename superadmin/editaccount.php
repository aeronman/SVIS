<?php

require_once '../process/db_connection.php';
include('../process/checkSuperAdminSession.php');
$id = $_SESSION['id'];
$fullName = $_SESSION['full_name'];
$profilePicture = $_SESSION['profile_picture'];
$qrImage = $_SESSION['qr_image'];

$accountid = $_GET['id'];

$conn = getDbConnection();

$sql = "SELECT * FROM accounts where id = $accountid";

if($stmt = $conn->prepare($sql)){
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $userType = $row['account_type'];
        $firstname = $row['first_name'];
        $middlename = $row['middle_name'];
        $lastname = $row['last_name'];
        $username = $row['username'];
        $profile_picture = $row['profile_picture'];
        $qr = $row['qr_image'];
        $advisory = $row['advisory_class'];
        $email = $row['email'];
        $section = $row['section'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit Account</title>
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
  <script src="ajax.js"></script>
  <!-- <script src="https://unpkg.com/html5-qrcode/"></script> --> 
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
        <a class="navbar-brand brand-logo mr-5" href="index.php"><h4 class="text-dark">Super Admin</h4></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><h4 class="text-dark">SA</h4></a>
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
        
          <li class="nav-item active">
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

          <form id="dynamicForm">
                        <div class="form-group">
                            <label for="accountType">Account Type</label>
                            <select class="form-control" id="accountType" disabled>
                                <option value="">Select Account Type</option>
                                <option value="student" <?php echo ($userType == 'student') ? 'selected' : ''; ?>>Student</option>
                                <option value="admin" <?php echo ($userType == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="superadmin" <?php echo ($userType == 'superadmin') ? 'selected' : ''; ?>>Superadmin</option>
                                <option value="clerk" <?php echo ($userType == 'clerk') ? 'selected' : ''; ?>>Clerk</option>
                                <option value="faculty" <?php echo ($userType == 'faculty') ? 'selected' : ''; ?>>Faculty</option>
                            </select>
                        </div>

                        <!-- Fields for Student -->
                        <div id="studentFields" class="hidden">
                            <div class="form-group">
                                <label for="studentId">Student ID</label>
                                <input type="text" class="form-control" id="studentId" placeholder="Enter student ID" value="<?php if($userType == 'student'){ echo $accountid;}?>" disabled>
                            </div>
                            
                            <!-- First Name Field -->
                            <div class="form-group">
                                <label for="studentFirstName">First Name</label>
                                <input type="text" class="form-control" id="studentFirstName" placeholder="Enter first name" value="<?php if($userType == 'student'){ echo $firstname;}?>">
                            </div>
                            
                            <!-- Middle Name Field -->
                            <div class="form-group">
                                <label for="studentMiddleName">Middle Name</label>
                                <input type="text" class="form-control" id="studentMiddleName" placeholder="Enter middle name" value="<?php if($userType == 'student'){ echo $middlename;}?>">
                            </div>
                            
                            <!-- Last Name Field -->
                            <div class="form-group">
                                <label for="studentLastName">Last Name</label>
                                <input type="text" class="form-control" id="studentLastName" placeholder="Enter last name" value="<?php if($userType == 'student'){ echo $lastname;}?>">
                            </div>
                            
                            <!-- Section Field -->
                            <div class="form-group">
                                <label for="studentSection">Section</label>
                                <input type="text" class="form-control" id="studentSection" placeholder="Enter section" value="<?php if($userType == 'student'){ echo $section;}?>">
                            </div>
                            
                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="studentEmail">Email</label>
                                <input type="email" class="form-control" id="studentEmail" placeholder="Enter email" value="<?php if($userType == 'student'){ echo $email;}?>">
                            </div>
                        
                            
                        </div>

                        <!-- Fields for Admin -->
                        <div id="adminFields" class="hidden">
                            <div class="form-group">
                                <label for="adminID">Staff ID</label>
                                <input type="text" class="form-control" id="adminID" placeholder="Enter staff ID" value="<?php if($userType == 'admin'){ echo $accountid;}?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="adminFirstName">First Name</label>
                                <input type="text" class="form-control" id="adminFirstName" placeholder="Enter first name" value="<?php if($userType == 'admin'){ echo $firstname;}?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="adminMiddleName">Middle Name</label>
                                <input type="text" class="form-control" id="adminMiddleName" placeholder="Enter middle name" value="<?php if($userType == 'admin'){ echo $middlename;}?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="adminLastName">Last Name</label>
                                <input type="text" class="form-control" id="adminLastName" placeholder="Enter last name" value="<?php if($userType == 'admin'){ echo $lastname;}?>">
                            </div>
                            
            
                        </div>
                        <!-- Fields for Super Admin -->
                        <div id="superAdminFields" class="hidden">
                          <div class="form-group">
                                <label for="superAdminID">Staff ID</label>
                                <input type="text" class="form-control" id="superAdminID" placeholder="Enter staff ID" value="<?php if($userType == 'superadmin'){ echo $accountid;}?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="superAdminFirstName">First Name</label>
                                <input type="text" class="form-control" id="superAdminFirstName" placeholder="Enter first name" value="<?php if($userType == 'superadmin'){ echo $firstname;}?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="superAdminMiddleName">Middle Name</label>
                                <input type="text" class="form-control" id="superAdminMiddleName" placeholder="Enter middle name" value="<?php if($userType == 'superadmin'){ echo $middlename;}?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="superAdminLastName">Last Name</label>
                                <input type="text" class="form-control" id="superAdminLastName" placeholder="Enter last name" value="<?php if($userType == 'superadmin'){ echo $lastname;}?>">
                            </div>
                         
                        </div>
                        <!-- Fields for Clerk -->
                        <div id="clerkFields" class="hidden">
                            <div class="form-group">
                                    <label for="clerkID">Staff ID</label>
                                    <input type="text" class="form-control" id="clerkID" placeholder="Enter staff ID" value="<?php if($userType == 'clerk'){ echo $accountid;}?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="clerkFirstName">First Name</label>
                                <input type="text" class="form-control" id="clerkFirstName" placeholder="Enter first name" value="<?php if($userType == 'clerk'){ echo $firstname;}?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="clerkMiddleName">Middle Name</label>
                                <input type="text" class="form-control" id="clerkMiddleName" placeholder="Enter middle name" value="<?php if($userType == 'clerk'){ echo $middlename;}?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="clerkLastName">Last Name</label>
                                <input type="text" class="form-control" id="clerkLastName" placeholder="Enter last name" value="<?php if($userType == 'clerk'){ echo $lastname;}?>">
                            </div>
                            
                        
                        </div>
                        <!-- Fields for Faculty -->
                        <div id="facultyFields" class="hidden">
                            <!-- Faculty ID Field -->
                            <div class="form-group">
                                <label for="facultyId">Faculty ID</label>
                                <input type="text" class="form-control" id="facultyId" placeholder="Enter faculty ID" value="<?php if($userType == 'faculty'){ echo $accountid;}?>" disabled>
                            </div>

                            <!-- First Name Field -->
                            <div class="form-group">
                                <label for="facultyFirstName">First Name</label>
                                <input type="text" class="form-control" id="facultyFirstName" placeholder="Enter first name" value="<?php if($userType == 'faculty'){ echo $firstname;}?>">
                            </div>
                            
                            <!-- Middle Name Field -->
                            <div class="form-group">
                                <label for="facultyMiddleName">Middle Name</label>
                                <input type="text" class="form-control" id="facultyMiddleName" placeholder="Enter middle name" value="<?php if($userType == 'faculty'){ echo $middlename;}?>">
                            </div>
                            
                            <!-- Last Name Field -->
                            <div class="form-group">
                                <label for="facultyLastName">Last Name</label>
                                <input type="text" class="form-control" id="facultyLastName" placeholder="Enter last name" value="<?php if($userType == 'faculty'){ echo $lastname;}?>"> 
                            </div>
                            
                         
                            
                            <!-- Advisory Class Field -->
                            <div class="form-group">
                                <label for="facultyAdvisoryClass">Advisory Class</label>
                                <input type="text" class="form-control" id="facultyAdvisoryClass" placeholder="Enter advisory class">
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary" id="submitEditAccountForm">Edit Account</button>
          </form>

    


    
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

  <!-- End custom js for this page-->
  <script>
        document.addEventListener('DOMContentLoaded', function() {
        const accountTypeSelect = document.getElementById('accountType');
        const fields = {
            student: document.getElementById('studentFields'),
            admin: document.getElementById('adminFields'),
            superadmin: document.getElementById('superAdminFields'),
            clerk: document.getElementById('clerkFields'),
            faculty: document.getElementById('facultyFields')
        };

        // Function to show/hide fields based on the selected account type
        function updateFieldsBasedOnSelection() {
            const selectedType = accountTypeSelect.value;

            // Hide all fields initially
            for (const key in fields) {
                if (fields[key]) {
                    fields[key].classList.add('hidden');
                }
            }

            // Show the corresponding fields for the selected account type
            if (fields[selectedType]) {
                fields[selectedType].classList.remove('hidden');
            }
        }

        // Run once when the page loads to show the pre-selected fields
        updateFieldsBasedOnSelection();

       
    });

    </script>
</body>

</html>

