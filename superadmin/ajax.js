$(document).ready(function () {
    $('#submitAccountForm').click(function (e) {
        e.preventDefault(); // Prevent the default form submission
    
        var accountType = $('#accountType').val();
        var formData = new FormData();
        var ajaxUrl = '';
        const studentPreview = document.getElementById('studentProfilePreview');
        const adminPreview = document.getElementById('adminProfilePreview');
        const superAdminPreview = document.getElementById('superAdminProfilePreview');
        const facultyPreview = document.getElementById('facultyProfilePreview');
        const clerkPreview = document.getElementById('clerkProfilePreview');
    
        function readFileAsBase64(file, callback) {
            var reader = new FileReader();
            reader.onload = function (event) {
                callback(event.target.result);
            };
            reader.readAsDataURL(file);
        }
    
        function showAlert(message, type) {
            var alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                                ${message}
                                 <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`;
            $('#alertContainer').html(alertHtml);
        }
    
        function closeModal() {
            $('#myModal').modal('hide');
        }
    
        if (accountType === 'student') {
            ajaxUrl = '../process/createStudentAccount.php';
            var profilePictureFile = $('#studentProfilePicture')[0].files[0];
            var studentId = $('#studentId').val();
    
            // Generate QR Code with Student ID
            var qrText = 'Student ID: ' + studentId;
            var qrcodeContainer = document.createElement('div');
            qrcodeContainer.id = 'qrcode'; // Set an ID for easy reference
            document.body.appendChild(qrcodeContainer);
    
            new QRCode(qrcodeContainer, {
                text: qrText,
                width: 128,
                height: 128
            });
    
            setTimeout(function () {
                var qrImage = document.querySelector("#qrcode img").src;
                var qrImageData = qrImage.split(',')[1]; // Remove the "data:image/png;base64," part
    
                if (profilePictureFile) {
                    readFileAsBase64(profilePictureFile, function (profilePicBase64) {
                        formData.append('accountType', 'student');
                        formData.append('studentId', studentId);
                        formData.append('firstName', $('#studentFirstName').val());
                        formData.append('middleName', $('#studentMiddleName').val());
                        formData.append('lastName', $('#studentLastName').val());
                        formData.append('section', $('#studentSection').val());
                        formData.append('email', $('#studentEmail').val());
                        formData.append('username', $('#studentUsername').val());
                        formData.append('password', $('#studentPassword').val());
                        formData.append('profilePicture', profilePicBase64);
                        formData.append('qrImage', qrImageData);
    
                        $.ajax({
                            url: ajaxUrl,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                closeModal(); // Close the modal before showing the alert
                                var jsonResponse = JSON.parse(response);
                                if (jsonResponse.success) {
                                    showAlert(jsonResponse.success, 'success');
                                } else if (jsonResponse.error) {
                                    showAlert(jsonResponse.error, 'danger');
                                }
                                $('#dynamicForm')[0].reset();
                                studentPreview.src = '';
                                studentPreview.style.display = 'none';
                                document.body.removeChild(qrcodeContainer);
                            },
                            error: function (xhr, status, error) {
                                closeModal(); // Close the modal before showing the alert
                                showAlert('An error occurred: ' + xhr.responseText, 'danger');
                            }
                        });
                    });
                } else {
                    formData.append('accountType', 'student');
                    formData.append('studentId', studentId);
                    formData.append('firstName', $('#studentFirstName').val());
                    formData.append('middleName', $('#studentMiddleName').val());
                    formData.append('lastName', $('#studentLastName').val());
                    formData.append('section', $('#studentSection').val());
                    formData.append('email', $('#studentEmail').val());
                    formData.append('username', $('#studentUsername').val());
                    formData.append('password', $('#studentPassword').val());
                    formData.append('qrImage', qrImageData);
    
                    $.ajax({
                        url: ajaxUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            closeModal(); // Close the modal before showing the alert
                            var jsonResponse = JSON.parse(response);
                            if (jsonResponse.success) {
                                showAlert(jsonResponse.success, 'success');
                            } else if (jsonResponse.error) {
                                showAlert(jsonResponse.error, 'danger');
                            }
                            $('#dynamicForm')[0].reset();
                            studentPreview.src = '';
                            studentPreview.style.display = 'none';
                            document.body.removeChild(qrcodeContainer);
                        },
                        error: function (xhr, status, error) {
                            closeModal(); // Close the modal before showing the alert
                            showAlert('An error occurred: ' + xhr.responseText, 'danger');
                        }
                    });
                }
            }, 500); // Delay to ensure QR code is generated
    
        } else if (accountType === 'admin') {
            ajaxUrl = '../process/createAdminAccount.php';
            var profilePictureFile = $('#adminProfilePicture')[0].files[0];
    
            if (profilePictureFile) {
                readFileAsBase64(profilePictureFile, function (profilePicBase64) {
                    formData.append('accountType', 'admin');
                    formData.append('adminID', $('#adminID').val());
                    formData.append('firstName', $('#adminFirstName').val());
                    formData.append('middleName', $('#adminMiddleName').val());
                    formData.append('lastName', $('#adminLastName').val());
                    formData.append('username', $('#adminUsername').val());
                    formData.append('password', $('#adminPassword').val());
                    formData.append('profilePicture', profilePicBase64);
    
                    $.ajax({
                        url: ajaxUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            closeModal(); // Close the modal before showing the alert
                            var jsonResponse = JSON.parse(response);
                            if (jsonResponse.success) {
                                showAlert(jsonResponse.success, 'success');
                            } else if (jsonResponse.error) {
                                showAlert(jsonResponse.error, 'danger');
                            }
                            $('#dynamicForm')[0].reset();
                            adminPreview.src = '';
                            adminPreview.style.display = 'none';
                        },
                        error: function (xhr, status, error) {
                            closeModal(); // Close the modal before showing the alert
                            showAlert('An error occurred: ' + xhr.responseText, 'danger');
                        }
                    });
                });
            } else {
                formData.append('accountType', 'admin');
                formData.append('adminID', $('#adminID').val());
                formData.append('firstName', $('#adminFirstName').val());
                formData.append('middleName', $('#adminMiddleName').val());
                formData.append('lastName', $('#adminLastName').val());
                formData.append('username', $('#adminUsername').val());
                formData.append('password', $('#adminPassword').val());
    
                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        closeModal(); // Close the modal before showing the alert
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            showAlert(jsonResponse.success, 'success');
                        } else if (jsonResponse.error) {
                            showAlert(jsonResponse.error, 'danger');
                        }
                        $('#dynamicForm')[0].reset();
                        adminPreview.src = '';
                        adminPreview.style.display = 'none';
                    },
                    error: function (xhr, status, error) {
                        closeModal(); // Close the modal before showing the alert
                        showAlert('An error occurred: ' + xhr.responseText, 'danger');
                    }
                });
            }
    
        } else if (accountType === 'superadmin') {
            ajaxUrl = '../process/createSuperadminAccount.php';
            var profilePictureFile = $('#superAdminProfilePicture')[0].files[0];
    
            if (profilePictureFile) {
                readFileAsBase64(profilePictureFile, function (profilePicBase64) {
                    formData.append('accountType', 'superadmin');
                    formData.append('superAdminID', $('#superAdminID').val());
                    formData.append('firstName', $('#superAdminFirstName').val());
                    formData.append('middleName', $('#superAdminMiddleName').val());
                    formData.append('lastName', $('#superAdminLastName').val());
                    formData.append('username', $('#superAdminUsername').val());
                    formData.append('password', $('#superAdminPassword').val());
                    formData.append('profilePicture', profilePicBase64);
    
                    $.ajax({
                        url: ajaxUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            closeModal(); // Close the modal before showing the alert
                            var jsonResponse = JSON.parse(response);
                            if (jsonResponse.success) {
                                showAlert(jsonResponse.success, 'success');
                            } else if (jsonResponse.error) {
                                showAlert(jsonResponse.error, 'danger');
                            }
                            $('#dynamicForm')[0].reset();
                            superAdminPreview.src = '';
                            superAdminPreview.style.display = 'none';
                        },
                        error: function (xhr, status, error) {
                            closeModal(); // Close the modal before showing the alert
                            showAlert('An error occurred: ' + xhr.responseText, 'danger');
                        }
                    });
                });
            } else {
                formData.append('accountType', 'superadmin');
                formData.append('superAdminID', $('#superAdminID').val());
                formData.append('firstName', $('#superAdminFirstName').val());
                formData.append('middleName', $('#superAdminMiddleName').val());
                formData.append('lastName', $('#superAdminLastName').val());
                formData.append('username', $('#superAdminUsername').val());
                formData.append('password', $('#superAdminPassword').val());
    
                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        closeModal(); // Close the modal before showing the alert
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            showAlert(jsonResponse.success, 'success');
                        } else if (jsonResponse.error) {
                            showAlert(jsonResponse.error, 'danger');
                        }
                        $('#dynamicForm')[0].reset();
                        superAdminPreview.src = '';
                        superAdminPreview.style.display = 'none';
                    },
                    error: function (xhr, status, error) {
                        closeModal(); // Close the modal before showing the alert
                        showAlert('An error occurred: ' + xhr.responseText, 'danger');
                    }
                });
            }
        }
        else if (accountType === 'clerk') {
            ajaxUrl = '../process/createClerkAccount.php';
            var profilePictureFile = $('#clerkProfilePicture')[0].files[0];

            if (profilePictureFile) {
                readFileAsBase64(profilePictureFile, function (profilePicBase64) {
                    formData.append('accountType', 'clerk');
                    formData.append('clerkID', $('#clerkID').val());
                    formData.append('firstName', $('#clerkFirstName').val());
                    formData.append('middleName', $('#clerkMiddleName').val());
                    formData.append('lastName', $('#clerkLastName').val());
                    formData.append('username', $('#clerkUsername').val());
                    formData.append('password', $('#clerkPassword').val());
                    formData.append('profilePicture', profilePicBase64);

                    $.ajax({
                        url: ajaxUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            closeModal(); // Close the modal before showing the alert
                            var jsonResponse = JSON.parse(response);
                            if (jsonResponse.success) {
                                showAlert(jsonResponse.success, 'success');
                            } else if (jsonResponse.error) {
                                showAlert(jsonResponse.error, 'danger');
                            }
                            $('#dynamicForm')[0].reset();
                            clerkPreview.src = '';
                            clerkPreview.style.display = 'none';
                        },
                        error: function (xhr, status, error) {
                            closeModal(); // Close the modal before showing the alert
                            showAlert('An error occurred: ' + xhr.responseText, 'danger');
                        }
                    });
                });
            } else {
                formData.append('accountType', 'clerk');
                formData.append('clerkID', $('#clerkID').val());
                formData.append('firstName', $('#clerkFirstName').val());
                formData.append('middleName', $('#clerkMiddleName').val());
                formData.append('lastName', $('#clerkLastName').val());
                formData.append('username', $('#clerkUsername').val());
                formData.append('password', $('#clerkPassword').val());

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        closeModal(); // Close the modal before showing the alert
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            showAlert(jsonResponse.success, 'success');
                        } else if (jsonResponse.error) {
                            showAlert(jsonResponse.error, 'danger');
                        }
                        $('#dynamicForm')[0].reset();
                        clerkPreview.src = '';
                        clerkPreview.style.display = 'none';
                    },
                    error: function (xhr, status, error) {
                        closeModal(); // Close the modal before showing the alert
                        showAlert('An error occurred: ' + xhr.responseText, 'danger');
                    }
                });
            }

        } else if (accountType === 'faculty') {
            ajaxUrl = '../process/createFacultyAccount.php';
            var profilePictureFile = $('#facultyProfilePicture')[0].files[0];

            if (profilePictureFile) {
                readFileAsBase64(profilePictureFile, function (profilePicBase64) {
                    formData.append('accountType', 'faculty');
                    formData.append('facultyId', $('#facultyId').val());
                    formData.append('firstName', $('#facultyFirstName').val());
                    formData.append('middleName', $('#facultyMiddleName').val());
                    formData.append('lastName', $('#facultyLastName').val());
                    formData.append('username', $('#facultyUsername').val());
                    formData.append('password', $('#facultyPassword').val());
                    formData.append('advisoryClass', $('#facultyAdvisoryClass').val());
                    formData.append('profilePicture', profilePicBase64);

                    $.ajax({
                        url: ajaxUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            closeModal(); // Close the modal before showing the alert
                            var jsonResponse = JSON.parse(response);
                            if (jsonResponse.success) {
                                showAlert(jsonResponse.success, 'success');
                            } else if (jsonResponse.error) {
                                showAlert(jsonResponse.error, 'danger');
                            }
                            $('#dynamicForm')[0].reset();
                            facultyPreview.src = '';
                            facultyPreview.style.display = 'none';
                        },
                        error: function (xhr, status, error) {
                            closeModal(); // Close the modal before showing the alert
                            showAlert('An error occurred: ' + xhr.responseText, 'danger');
                        }
                    });
                });
            } else {
                formData.append('accountType', 'faculty');
                formData.append('facultyId', $('#facultyId').val());
                formData.append('firstName', $('#facultyFirstName').val());
                formData.append('middleName', $('#facultyMiddleName').val());
                formData.append('lastName', $('#facultyLastName').val());
                formData.append('username', $('#facultyUsername').val());
                formData.append('password', $('#facultyPassword').val());
                formData.append('advisoryClass', $('#facultyAdvisoryClass').val());

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        closeModal(); // Close the modal before showing the alert
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            showAlert(jsonResponse.success, 'success');
                        } else if (jsonResponse.error) {
                            showAlert(jsonResponse.error, 'danger');
                        }
                        $('#dynamicForm')[0].reset();
                        facultyPreview.src = '';
                        facultyPreview.style.display = 'none';
                    },
                    error: function (xhr, status, error) {
                        closeModal(); // Close the modal before showing the alert
                        showAlert('An error occurred: ' + xhr.responseText, 'danger');
                    }
                });
            }
        } 
    });
    

    $('#submitEditAccountForm').click(function (e) {
        console.log("submitEdit");
        e.preventDefault(); // Prevent the default form submission
    
        var accountType = $('#accountType').val();
        var formData = new FormData();
        var ajaxUrl = '';
    
        function handleAjaxResponse(response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.status == "success") {
                // Display success alert
                $('#alertContainer').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${jsonResponse.message}
                        <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            } else {
                // Display error alert
                $('#alertContainer').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${jsonResponse.message}
                        <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                `);
            }
        }
    
        function handleAjaxError(xhr, status, error) {
            $('#alertContainer').html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    An error occurred: ${xhr.responseText}
                    <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            `);
        }
    
        if (accountType === 'student') {
            ajaxUrl = '../process/editStudentAccount.php';
            var studentId = $('#studentId').val();
    
            formData.append('accountType', 'student');
            formData.append('studentId', studentId);
            formData.append('firstName', $('#studentFirstName').val());
            formData.append('middleName', $('#studentMiddleName').val());
            formData.append('lastName', $('#studentLastName').val());
            formData.append('section', $('#studentSection').val());
            formData.append('email', $('#studentEmail').val());
    
        } else if (accountType === 'admin') {
            ajaxUrl = '../process/editAdminAccount.php';
            formData.append('accountType', 'admin');
            formData.append('adminID', $('#adminID').val());
            formData.append('firstName', $('#adminFirstName').val());
            formData.append('middleName', $('#adminMiddleName').val());
            formData.append('lastName', $('#adminLastName').val());
    
        } else if (accountType === 'superadmin') {
            ajaxUrl = '../process/editSuperAdminAccount.php';
            formData.append('accountType', 'superadmin');
            formData.append('superAdminID', $('#superAdminID').val());
            formData.append('firstName', $('#superAdminFirstName').val());
            formData.append('middleName', $('#superAdminMiddleName').val());
            formData.append('lastName', $('#superAdminLastName').val());
    
        } else if (accountType === 'clerk') {
            ajaxUrl = '../process/editClerkAccount.php';
            formData.append('accountType', 'clerk');
            formData.append('clerkID', $('#clerkID').val());
            formData.append('firstName', $('#clerkFirstName').val());
            formData.append('middleName', $('#clerkMiddleName').val());
            formData.append('lastName', $('#clerkLastName').val());
    
        } else if (accountType === 'faculty') {
            ajaxUrl = '../process/editFacultyAccount.php';
            formData.append('accountType', 'faculty');
            formData.append('facultyId', $('#facultyId').val());
            formData.append('firstName', $('#facultyFirstName').val());
            formData.append('middleName', $('#facultyMiddleName').val());
            formData.append('lastName', $('#facultyLastName').val());
            formData.append('advisoryClass', $('#facultyAdvisoryClass').val());
            
        } else {
            $('#alertContainer').html(`
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Please select an account type.
                    <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            `);
            return;
        }
    
        // Submit the form data via AJAX
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: handleAjaxResponse,
            error: handleAjaxError
        });
    });
    $('#deleteForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var form = $(this);
        var formData = form.serialize(); // Serialize the form data

        $.ajax({
            url: '../process/deleteAccount.php', // PHP file to handle the request
            type: 'POST',
            data: formData,
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status == "success") {
                    $('#deleteModal').modal('hide'); // Close the modal
                    // Show success alert
                    $('#alertContainer').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${jsonResponse.message}
                            <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                    </div>`);
                     // Reload the page after a short delay
                    setTimeout(function() {
                        location.reload();
                    }, 1000); 
                } else if (jsonResponse.status == "error") {
                    $('#alertContainer').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${jsonResponse.message}
                       <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                    </div>`);
                }
            },
            error: function(xhr, status, error) {
                $('#deleteModal').modal('hide'); // Close the modal
                $('#alertContainer').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    An error occurred: ${xhr.responseText}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`);
            }
        });
    });
    
});
