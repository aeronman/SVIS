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
});
