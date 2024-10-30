<?php
include('process/checkIfLoggedIn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="/vendors/feather/feather.css">
  <link rel="stylesheet" href="/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/logo2.webp" />
</head>

<style>
  .content-wrapper {
    background-image: url("images/BG.webp") !important;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  .auth-form-light {
    background-color: rgba(0, 0, 0, 0.5) !important;
    border-radius: 8px;
  }

  .brand-logos {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .brand-logo {
    flex: 1;
  }

  .brand-logo img {
    max-width: 100px;
    height: auto;
  }
</style>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logos d-flex justify-content-center mb-4">
                <div class="brand-logo d-flex  justify-content-center align-items-center mx-2">
                  <img src="images/logo2.webp" alt="logo">
                </div>
                <div class="brand-logo d-flex  justify-content-center align-items-center mx-2">
                  <img src="images/logo.webp" alt="logo">
                </div>
              </div>

              <form id="loginForm" class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg text-white" id="exampleInputEmail1" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg text-white" id="exampleInputPassword1" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <button type="button" id="submitLoginForm" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">

                  </div>
                  <a href="#" class="auth-link text-white" data-toggle="modal" data-target="#forgotPasswordModal">Forgot password?</a>

                </div>
              </form>

              <!-- Forgot Password Modal -->
              <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="forgotPasswordLabel">Forgot Password</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                    <form id="forgotPasswordForm">
                          <div class="form-group">
                            <label for="emailInput">Enter your email address</label>
                            <input type="email" class="form-control" id="emailInput" placeholder="Email" required>
                          </div>
                          <div id="forgotPasswordMessage" class="text-danger mt-2"></div>
                          <button type="button" class="btn btn-primary" id="submitForgotPassword">Submit</button>
                        </form>

                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  
  <!-- Your custom script -->
  <script src="login.js"></script>
</body>

</html>
