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
  <title>Dashboard</title>
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

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

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
              <a class="dropdown-item" href="settings.php">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>
              <a href="../process/logout.php"class="dropdown-item">
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
          <div class="row">


        
                      <!-- Top Violation Tile (Clickable) -->
            <div class="col-md-6 mb-4 stretch-card transparent">
              <div class="card card-tale" id="topViolationTile" onclick="showTopViolationModal()">
                <div class="card-body">
                  <p class="mb-4">Top Violation</p>
                  <p id="violationType" class="fs-30 mb-2">Loading...</p>
                  <p id="violationCount">Count: 0</p>
                </div>
              </div>
            </div>

            <!-- Total Number of Students (Link to accounts.php) -->
            <div class="col-md-6 mb-4 stretch-card transparent">
              <div class="card card-dark-blue">
                <div class="card-body">
                  <a href="accounts.php" class="text-white">
                    <p class="mb-4">Total Number of Students</p>
                    <p id="totalStudents" class="fs-30 mb-2">Loading...</p>
                  </a>
                </div>
              </div>
            </div>

            <!-- Violations Today (Clickable) -->
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
              <div class="card card-light-blue" id="violationsTodayTile" onclick="showTodayViolationsModal()">
                <div class="card-body">
                  <p class="mb-4">Number of Violation (Today)</p>
                  <p id="violationsToday" class="fs-30 mb-2">Loading...</p>
                  <p id="violationPercentage">(0.00%)</p>
                </div>
              </div>
            </div>

            <!-- Violations This Month (Clickable) -->
            <div class="col-md-6 stretch-card transparent">
              <div class="card card-light-danger" id="violationsMonthTile" onclick="showMonthViolationsModal()">
                <div class="card-body">
                  <p class="mb-4">Number of Violations (This Month)</p>
                  <p id="violationsThisMonth" class="fs-30 mb-2">Loading...</p>
                </div>
              </div>
            </div>


                        <!-- Top Violation Modal -->
            <div id="topViolationModal" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Top Violation Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <table id="topViolationTable" class="table table-striped">
                      <!-- Table Head -->
                      <thead>
                        <tr>
                          <th>Violation Name</th>
                          <th>Count</th>
                        </tr>
                      </thead>
                      <!-- Table Body to be populated dynamically -->
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Today Violations Modal -->
            <div id="todayViolationsModal" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Today's Violations</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <table id="todayViolationsTable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Violation Name</th>
                          <th>Count</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Month Violations Modal -->
            <div id="monthViolationsModal" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">This Month's Violations</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <table id="monthViolationsTable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Violation Name</th>
                          <th>Count</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>


        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
       
        <!-- partial -->
      </div>
      <div class="row mt-4">
        <h4 class="centered">Visualize CICT Students Violation Through Graphs</h4>
                    <!-- Filters -->
<div class="col-12">
    <label for="monthFilter">Month:</label>
    <select id="monthFilter">
        <option value="">All</option>
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>

    <label for="yearFilter">Year:</label>
    <input type="number" id="yearFilter" placeholder="YYYY">

    <label for="studentYearFilter">Student Year:</label>
    <select id="studentYearFilter">
        <option value="">All</option>
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>
        <option value="4">4th Year</option>
    </select>

    <button class="btn btn-primary"id="filterButton">Generate Charts</button>
</div>

      </div>

      
<!-- Chart Containers -->
<div class="row">
    <canvas id="barChart"></canvas>

</div>
<div class="row">
<canvas id="pieChart"></canvas>
</div>

      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <script>
   function showTopViolationModal() {
    function showTopViolationModal() {
    $('#topViolationModal').modal('show');
    $.ajax({
        url: '../process/getTopViolations.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.status === 'success') {
                let rows = '';
                data.violations.forEach(function(violation) {
                    rows += `<tr>
                        <td>${violation.violation_type}</td>
                        <td>${violation.violation_count}</td>
                    </tr>`;
                });
                $('#topViolationTable tbody').html(rows); // Populate table with sorted violation data

                // Initialize or reinitialize DataTables
                if ($.fn.DataTable.isDataTable('#topViolationTable')) {
                    $('#topViolationTable').DataTable().destroy();
                }
                $('#topViolationTable').DataTable();
            } else {
                $('#topViolationTable tbody').html('<tr><td colspan="2">' + data.message + '</td></tr>');
            }
        },
        error: function() {
            $('#topViolationTable tbody').html('<tr><td colspan="2">Error fetching data.</td></tr>');
        }
    });
}

function showTodayViolationsModal() {
    $('#todayViolationsModal').modal('show');
    $.ajax({
        url: '../process/getTodaysViolation.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.status === 'success') {
                let rows = '';
                data.violations.forEach(function(violation) {
                    rows += `<tr>
                        <td>${violation.violation_type}</td>
                        <td>${violation.violation_count}</td>
                    </tr>`;
                });
                $('#todayViolationsTable tbody').html(rows);

                if ($.fn.DataTable.isDataTable('#todayViolationsTable')) {
                    $('#todayViolationsTable').DataTable().destroy();
                }
                $('#todayViolationsTable').DataTable();
            } else {
                $('#todayViolationsTable tbody').html('<tr><td colspan="2">' + data.message + '</td></tr>');
            }
        },
        error: function() {
            $('#todayViolationsTable tbody').html('<tr><td colspan="2">Error fetching data.</td></tr>');
        }
    });
}

function showMonthViolationsModal() {
    $('#monthViolationsModal').modal('show');
    $.ajax({
        url: '../process/getMonthViolation.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.status === 'success') {
                let rows = '';
                data.violations.forEach(function(violation) {
                    rows += `<tr>
                        <td>${violation.violation_type}</td>
                        <td>${violation.violation_count}</td>
                    </tr>`;
                });
                $('#monthViolationsTable tbody').html(rows);

                if ($.fn.DataTable.isDataTable('#monthViolationsTable')) {
                    $('#monthViolationsTable').DataTable().destroy();
                }
                $('#monthViolationsTable').DataTable();
            } else {
                $('#monthViolationsTable tbody').html('<tr><td colspan="2">' + data.message + '</td></tr>');
            }
        },
        error: function() {
            $('#monthViolationsTable tbody').html('<tr><td colspan="2">Error fetching data.</td></tr>');
        }
    });
}


        $(document).ready(function() {


          function fetchViolationsData(month, year, studentYear) {
        $.ajax({
            url: '../process/getViolationsData.php',
            method: 'GET',
            data: {
                month: month,
                year: year,
                student_year: studentYear
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    renderCharts(response.data);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error fetching data.');
            }
        });
    }

    function renderCharts(data) {
        const labels = data.map(item => item.violation_name);
        const counts = data.map(item => item.violation_count);

        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Violation Counts',
                    data: counts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Violation Percentages',
                    data: counts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            }
        });
    }

    $('#filterButton').on('click', function() {
        const month = $('#monthFilter').val();
        const year = $('#yearFilter').val();
        const studentYear = $('#studentYearFilter').val();

        fetchViolationsData(month, year, studentYear);
    });
            // Ajax call to fetch the top violation
            $.ajax({
                url: '../process/top_violation.php', // PHP file to fetch data from
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Update the HTML with the violation type and count
                        $('#violationType').text(response.violation_type);
                        $('#violationCount').text('Count: ' + response.violation_count + ' (30 days)');
                    } else {
                        $('#violationType').text('No violations found');
                        $('#violationCount').text('Count: 0 (30 days)');
                    }
                },
                error: function() {
                    $('#violationType').text('Error fetching data');
                    $('#violationCount').text('Count: 0 (30 days)');
                }
            });

            $.ajax({
                url: '../process/total_students.php', // Path to PHP file that fetches data
                type: 'GET',
                dataType: 'json', // Expecting JSON response
                success: function(response) {
                    if (response.status === 'success') {
                        // Update the card with the fetched student count
                        $('#totalStudents').text(response.total_students);
                    } else {
                        $('#totalStudents').text('Error fetching data');
                    }
                },
                error: function() {
                    $('#totalStudents').text('Error fetching data');
                }
            });
            $.ajax({
                url: '../process/fetch_todays_violation.php', // PHP file that fetches today's violations
                type: 'GET',
                dataType: 'json', // Expecting JSON response
                success: function(response) {
                    if (response.status === 'success') {
                        // Update the card with the fetched count and percentage
                        $('#violationsToday').text(response.total_violations_today);
                        $('#violationPercentage').text(response.percentage + '% (This Month)');
                    } else {
                        $('#violationsToday').text('Error fetching data');
                        $('#violationPercentage').text('N/A');
                    }
                },
                error: function() {
                    $('#violationsToday').text('Error fetching data');
                    $('#violationPercentage').text('N/A');
                }
            });
        
            // Ajax request to fetch this month's violations
            $.ajax({
                url: '../process/fetch_montly_violations.php', // PHP file to fetch this month's violations
                type: 'GET',
                dataType: 'json', // Expecting JSON response
                success: function(response) {
                    if (response.status === 'success') {
                        // Update the card with the total number of violations for this month
                        $('#violationsThisMonth').text(response.total_violations_month);
                    } else {
                        $('#violationsThisMonth').text('Error fetching data');
                    }
                },
                error: function() {
                    $('#violationsThisMonth').text('Error fetching data');
                }
            });
          

            

        });
    </script>

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
</body>

</html>

