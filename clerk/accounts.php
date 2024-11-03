<?php
include('../process/checkClerkSession.php');
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
  <title>Accounts</title>
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
    </style>
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.php"><h4 class="text-dark">Clerk</h4></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><h4 class="text-dark">C</h4></a>
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
              <a class="dropdown-item" href="settings.php">
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
            <a class="nav-link" href="chats.php" aria-expanded="false" aria-controls="auth">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Chats</span>
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
            <button type="button" class="btn btn-inverse-success btn-fw" data-toggle="modal" data-target="#myModal">
                Add Student Account
            </button>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="dynamicForm">
                        <div class="form-group">
                            <label for="accountType">Account Type</label>
                            <select class="form-control" id="accountType">
                                <option value="">Select Account Type</option>
                                <option value="student">Student</option>
                            </select>
                        </div>



                       <!-- Fields for Student -->
                      <div id="studentFields" class="hidden">
                          <div class="form-group">
                              <label for="studentId">Student ID</label>
                              <input type="text" class="form-control" id="studentId" placeholder="Enter student ID">
                          </div>
                          
                          <!-- First Name Field -->
                          <div class="form-group">
                              <label for="studentFirstName">First Name</label>
                              <input type="text" class="form-control" id="studentFirstName" placeholder="Enter first name">
                          </div>
                          
                          <!-- Middle Name Field -->
                          <div class="form-group">
                              <label for="studentMiddleName">Middle Name</label>
                              <input type="text" class="form-control" id="studentMiddleName" placeholder="Enter middle name">
                          </div>
                          
                          <!-- Last Name Field -->
                          <div class="form-group">
                              <label for="studentLastName">Last Name</label>
                              <input type="text" class="form-control" id="studentLastName" placeholder="Enter last name">
                          </div>
                           <!-- Course Field -->
                           <div class="form-group">
                              <label for="studentCourse">Course</label>
                              <input type="text" class="form-control" id="studentCourse" placeholder="Enter course">
                          </div>
                          
                          <!-- Year Field -->
                          <div class="form-group">
                              <label for="studentYear">Year</label>
                              <select class="form-control" id="studentYear">
                                  <option value="">Select Year</option>
                                  <option value="1">First Year</option>
                                  <option value="2">Second Year</option>
                                  <option value="3">Third Year</option>
                                  <option value="4">Fourth Year</option>
                              </select>
                          </div>
                          
                          <!-- Section Field -->
                          <div class="form-group">
                              <label for="studentSection">Section</label>
                              <input type="text" class="form-control" id="studentSection" placeholder="Enter section">
                          </div>
                          
                          <!-- Email Field -->
                          <div class="form-group">
                              <label for="studentEmail">Email</label>
                              <input type="email" class="form-control" id="studentEmail" placeholder="Enter email">
                          </div>
                            <!-- Guardian Name Field -->
                            <div class="form-group">
                              <label for="guardianName">Guardian Name</label>
                              <input type="text" class="form-control" id="guardianName" placeholder="Enter guardian name">
                          </div>

                          <!-- Guardian Contact Number Field -->
                          <div class="form-group">
                              <label for="guardianContactNumber">Guardian Contact Number</label>
                              <input type="text" class="form-control" id="guardianContactNumber" placeholder="Enter guardian contact number">
                          </div>
                          <!-- Username Field -->
                          <div class="form-group">
                              <label for="studentUsername">Username</label>
                              <input type="text" class="form-control" id="studentUsername" placeholder="Enter username">
                          </div>
                          
                          <!-- Password Field -->
                          <div class="form-group">
                              <label for="studentPassword">Password</label>
                              <input type="password" class="form-control" id="studentPassword" placeholder="Enter password">
                          </div>
                          
                          <!-- Profile Picture Field -->
                          <div class="form-group">
                              <label for="studentProfilePicture">Profile Picture</label>
                              <input type="file" class="form-control-file" id="studentProfilePicture" accept="image/*">
                              <div class="mt-2">
                                  <img id="studentProfilePreview" src="" alt="Profile Picture Preview" style="display:none; max-width: 200px; height: auto;">
                              </div>
                          </div>          
                      </div>



                        <button type="submit" class="btn btn-primary" id="submitAccountForm">Create Account</button>
                    </form>
                    <div id="modalAlertContainer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
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
            <h4 class="card-title">Accounts</h4>
            
            <!-- Dropdown Filter -->
          <div class="form-group">
              <label for="accountTypeFilter">Filter by Account Type</label>
              <select class="form-control" id="accountTypeFilter">
                  <option value="student" selected>Student</option>
              </select>
          </div>


            <div class="table-responsive">
                <table class="table table-hover" id="accountsTable">
                    <thead>
                        <tr id="tableHeaders">
                            <!-- Headers will be updated based on account type -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated by AJAX -->
                    </tbody>
                </table>
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

  <script>
document.addEventListener('DOMContentLoaded', function () {

    const accountTypeFilter = document.getElementById('accountTypeFilter');

   
    function fetchAccounts(accountType) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../process/fetchAccountsClerk.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);

            // Destroy existing DataTable before updating data
            if ($.fn.DataTable.isDataTable('#accountsTable')) {
                $('#accountsTable').DataTable().clear().destroy();
            }

            // Insert headers and rows into the table
            document.querySelector('#accountsTable thead #tableHeaders').innerHTML = response.headers;
            document.querySelector('#accountsTable tbody').innerHTML = response.rows;

            $('#accountsTable').DataTable({
                "processing": true,
                "searching": true,
                "paging": true,
                "ordering": true,
                "order": [], // Disable initial sorting
                dom: 'Bfrtip', // Enable buttons in the DOM
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Accounts Data',
                        exportOptions: {
                            columns: function (idx, data, node) {
                                // Exclude columns with images and the last column
                                const isImageColumn = $('img', node).length > 0;
                                const isLastColumn = idx === $('#accountsTable thead th').length - 1;
                                return !isImageColumn && !isLastColumn;
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Accounts Data',
                        exportOptions: {
                            columns: function (idx, data, node) {
                                // Exclude columns with images and the last column
                                const isImageColumn = $('img', node).length > 0;
                                const isLastColumn = idx === $('#accountsTable thead th').length - 1;
                                return !isImageColumn && !isLastColumn;
                            }
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Accounts Data',
                        exportOptions: {
                            columns: function (idx, data, node) {
                                // Exclude columns with images and the last column
                                const isImageColumn = $('img', node).length > 0;
                                const isLastColumn = idx === $('#accountsTable thead th').length - 1;
                                return !isImageColumn && !isLastColumn;
                            }
                        }
                    }
                ]
            });
        }
    };
    xhr.send('accountType=' + encodeURIComponent(accountType));
}

    // Preload student accounts on page load
    if (accountTypeFilter.value == "student") {
        fetchAccounts('student'); // Fetch and load student accounts
    }

    // Event listener for dropdown change to fetch selected account type
    accountTypeFilter.addEventListener('change', function () {
        fetchAccounts(this.value);
    });
});



function confirmDelete(id) {
    // Set the id in the hidden input field in the delete form
    document.getElementById('deleteId').value = id;
    
    // Show the delete confirmation modal
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
} 
</script>
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

            accountTypeSelect.addEventListener('change', function() {
                // Hide all fields initially
                for (const key in fields) {
                    if (fields[key]) fields[key].classList.add('hidden');
                }

                // Show fields based on selected account type
                const selectedType = this.value;
                if (fields[selectedType]) {
                    fields[selectedType].classList.remove('hidden');
                }
            });
        });
        document.getElementById('studentProfilePicture').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('studentProfilePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
    document.getElementById('adminProfilePicture').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('adminProfilePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
    document.getElementById('superAdminProfilePicture').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('superAdminProfilePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
    document.getElementById('clerkProfilePicture').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('clerkProfilePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
    document.getElementById('facultyProfilePicture').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('facultyProfilePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
    </script>
</body>

</html>

