$(document).ready(function () {
    $('#submitLoginForm').click(function () {
        var username = $('#exampleInputEmail1').val();
        var password = $('#exampleInputPassword1').val();

        $.ajax({
            url: 'process/login.php',
            type: 'POST',
            data: {
                username: username,
                password: password
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    window.location.href = result.redirect;
                } else {
                    alert(result.message);
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });

    $('#submitForgotPassword').on('click', function() {
        const email = $('#emailInput').val();
    
        $.ajax({
          url: 'process/forgotPassword.php',
          type: 'POST',
          data: { email: email },
          dataType: 'json',
          success: function(response) {
            const messageElement = $('#forgotPasswordMessage');
            if (response.success) {
              messageElement.removeClass('text-danger').addClass('text-success');
              messageElement.text('Temporary password sent to your email.');
            } else {
              messageElement.removeClass('text-success').addClass('text-danger');
              messageElement.text(response.message || 'Email not found.');
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX error:', error);
          }
        });
      });
    
});


