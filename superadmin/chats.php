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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Chats</title>
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
<style>
    #chat-sidebar {
    width: 300px;
    border-right: 1px solid #ddd;
    overflow-y: auto;
}

.chat-item {
    display: flex;
    align-items: center;
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
}

.chat-item:hover {
    background-color: #f9f9f9;
}

.profile-pic {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    margin-right: 10px;
}

.chat-info {
    display: flex;
    flex-direction: column;
}

.student-name {
    font-weight: bold;
    font-size: 14px;
    margin: 0;
}

.message-preview {
    font-size: 12px;
    color: #888;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}
.chat-message {
    margin-bottom: 15px;
}

.chat-content {
    padding: 10px;
    width:70%;
    border-radius: 5px;
}

.chat-date {
    font-size: 0.75em;
    color: gray;
    text-align: right;
    margin-top: 2px;
}


        /* Basic styling for the chat layout */
        .chat-container { display: flex; }
        .chat-sidebar { width: 30%; border-right: 1px solid #ccc; padding: 20px; overflow-y: auto; }
       
        .message-right { justify-content: flex-end; background-color: #d0e9ff; padding: 10px; border-radius: 10px; }
        .message-left { justify-content: flex-start; background-color: #f1f1f1; padding: 10px; border-radius: 10px; }
        .message-box { display: flex; margin-top: auto; }
        .message-input { flex-grow: 1; padding: 10px; border-radius: 5px; }
        .send-btn { background-color: #007bff; color: white; border: none; padding: 10px; cursor: pointer; }
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
            <a class="nav-link" href="manage_violations.php" aria-expanded="false" aria-controls="auth">
              <i class="icon-ban menu-icon"></i>
              <span class="menu-title">Manage Violations</span>
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
          <div class="container-scroller">
        <div class="chat-container">
        <div id="chat-sidebar">
    <!-- JavaScript will populate this list -->
</div>


            <!-- Chat Content -->
            <div class="chat-content">
                <div id="chatMessages" style="flex-grow: 1; overflow-y: auto;">
                    <!-- Chat messages will load here dynamically -->
                </div>
                <div class="message-box">
                    <input type="text" id="messageInput" class="message-input" placeholder="Type your message">
                    <button class="send-btn" onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    let selectedStudentId = null;
// Load chat messages for selected student
function loadChat(studentId) {
    selectedStudentId = studentId;
    $.ajax({
        url: '../process/fetch_chats.php',
        method: 'GET',
        data: { student_id: studentId },
        dataType: 'json',
        success: function(data) {
            $('#chatMessages').empty();
            data.forEach(chat => {
                const alignClass = (chat.sent_by === '<?php echo $_SESSION['account_type']; ?>') ? 'message-right' : 'message-left';
                
                // Convert sent_date to readable date and time format
                const sentDate = new Date(chat.sent_date);
                const formattedDate = sentDate.toLocaleString('en-US', {
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric', 
                    hour: '2-digit', 
                    minute: '2-digit'
                });

                const messageHtml = `
                    <div class="chat-message ${alignClass}">
                        <div class="chat-content">${chat.content}</div>
                        <div class="chat-date">${formattedDate}</div>
                    </div>`;
                
                $('#chatMessages').append(messageHtml);
            });
            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
        }
    });
}

    // Send a message
function sendMessage() {
    const message = $('#messageInput').val();
    if (message && selectedStudentId) {
        $.ajax({
            url: '../process/send_message.php',
            method: 'POST',
            data: {
                student_id: selectedStudentId,
                message: message
            },
            success: function(response) {
                // Check response status
                if (response.status === 'success') {
                    loadChat(selectedStudentId); // Reload the chat after sending
                    $('#messageInput').val(''); // Clear input field
                } else {
                    console.error('Error sending message:', response.message);
                    alert('Failed to send message: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                alert('An error occurred while sending the message.');
            }
        });
    }
}
     

    $(document).ready(function() {
        // Load chat list grouped by student
        function loadChatList() {
            $.ajax({
                url: '../process/fetch_chat_list.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let sidebar = $('#chat-sidebar');
                    sidebar.empty(); // Clear any existing content

                    // Check if there are chats available
                    if (data.length === 0) {
                        sidebar.append('<div class="no-messages">No messages yet</div>'); // Display message if no chats
                        $('.message-box').hide(); // Hide the message input box
                    } else {
                        $('.message-box').show(); // Show the message input box
                        data.forEach(function(chat) {
                            const chatItem = $(`
                                <div class="chat-item" data-student-id="${chat.student_id}">
                                    <img src="${chat.profile_picture}" alt="Profile Picture" class="profile-pic">
                                    <div class="chat-info">
                                        <span class="student-name">${chat.student_name}</span>
                                        <p class="message-preview">${chat.last_message}</p>
                                    </div>
                                </div>
                            `);
                            sidebar.append(chatItem);
                        });

                           // Attach click event to each chat item
                            $('.chat-item').click(function() {
                                const studentId = $(this).data('student-id');
                                loadChat(studentId);  // Load chat messages for the selected student
                            });

                        // Automatically select the first chat if available
                        const firstChatItem = $('.chat-item').first();
                        if (firstChatItem.length) {
                            firstChatItem.click(); // Trigger click to load first chat messages
                            console.log('clicking fucker')
                        }
                    }

                 
                }
            });
        }

   
        
        // Load the chat list initially
        loadChatList();
    });
 


</script>

     <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <script>
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

