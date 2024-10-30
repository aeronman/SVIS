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
        function showModalAlert(message, type) {
            var alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                                ${message}
                                 <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`;
            $('#modalAlertContainer').html(alertHtml);
        }
    
        function closeModal() {
            $('#myModal').modal('hide');
        }
        function checkIdExists(accountType, idValue, callback) {
            $.ajax({
                url: '../process/checkId.php', // PHP file to check ID existence
                type: 'POST',
                data: {
                    accountType: accountType,
                    id: idValue
                },
                success: function (response) {
                    var jsonResponse = JSON.parse(response);
                    callback(jsonResponse.exists);
                },
                error: function (xhr, status, error) {
                    console.error('Error checking ID:', error);
                    callback(false);
                }
            });
        }
        // Function to check if email exists in the accounts table
        function checkEmailExists(email, callback) {
            $.ajax({
                url: '../process/checkEmailExists.php',
                type: 'POST',
                data: { email: email },
                success: function (response) {
                    callback(response.exists); // Pass true or false to the callback
                },
                error: function () {
                    showModalAlert('Error checking email existence.', 'danger');
                }
            });
        }

        // Function to validate guardian contact number
        function isValidGuardianContact(contact) {
            // Check if the contact is 11 digits and starts with '09'
            var regex = /^09\d{9}$/;
            return regex.test(contact);
        }
        
        
        if (accountType === 'student') {
            ajaxUrl = '../process/createStudentAccount.php';
            var profilePictureFile = $('#studentProfilePicture')[0].files[0];
            var studentId = $('#studentId').val();
            var guardianContact = $('#guardianContact').val(); // Get guardian contact number
            var email = $('#studentEmail').val();

            // Check if Student ID exists
            checkIdExists('student', studentId, function (exists) {
            if (exists) {
                showModalAlert('Student ID already exists. Please use a different ID.', 'danger');
                return;
            }
            
            checkEmailExists(email, function (exists) {
                if (exists) {
                    showModalAlert('Email already exists. Please use a different email.', 'danger');
                    return;
                }
        
     
        
                // Validate guardian contact number
                if (!isValidGuardianContact(guardianContact)) {
                    showModalAlert('Guardian contact number must be 11 digits long and start with 09.', 'danger');
                    return;
                }
        
                // Proceed with QR Code generation and form submission
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
        
                    // Prepare form data
                    var formData = new FormData();
                    formData.append('accountType', 'student');
                    formData.append('studentId', studentId);
                    formData.append('firstName', $('#studentFirstName').val());
                    formData.append('middleName', $('#studentMiddleName').val());
                    formData.append('lastName', $('#studentLastName').val());
                    formData.append('section', $('#studentSection').val());
                    formData.append('email', $('#studentEmail').val());
                    formData.append('username', $('#studentUsername').val());
                    formData.append('password', $('#studentPassword').val());
                    formData.append('course', $('#studentCourse').val());
                    formData.append('year', $('#studentYear').val());
                    formData.append('guardianName', $('#guardianName').val());
                    formData.append('guardianContact', guardianContact); // Append guardian contact
        
                    if (profilePictureFile) {
                        readFileAsBase64(profilePictureFile, function (profilePicBase64) {
                            formData.append('profilePicture', profilePicBase64);
                            formData.append('qrImage', qrImageData);
                            submitForm(ajaxUrl, formData, studentPreview, qrcodeContainer);
                        });
                    } else {
                        formData.append('qrImage', qrImageData);
                        submitForm(ajaxUrl, formData, studentPreview, qrcodeContainer);
                    }
                }, 500); // Delay to ensure QR code is generated
            });

         });
        }
        
        else if (accountType === 'admin') {
            ajaxUrl = '../process/createAdminAccount.php';
            var profilePictureFile = $('#adminProfilePicture')[0].files[0];
            var adminId = $('#adminID').val(); // Admin ID check
            var email = $('#adminEmail').val();
        
            // Check if Admin ID exists
            checkIdExists('admin', adminId, function (exists) {
                if (exists) {
                    showModalAlert('Admin ID already exists. Please use a different ID.', 'danger');
                    return;
                }
                checkEmailExists(email, function (exists) {
                    if (exists) {
                        showModalAlert('Email already exists. Please use a different email.', 'danger');
                        return;
                    }
                // Proceed with form submission
                var formData = new FormData();
                formData.append('accountType', 'admin');
                formData.append('adminID', adminId);
                formData.append('firstName', $('#adminFirstName').val());
                formData.append('middleName', $('#adminMiddleName').val());
                formData.append('lastName', $('#adminLastName').val());
                formData.append('email', $('#adminEmail').val());
                formData.append('username', $('#adminUsername').val());
                formData.append('password', $('#adminPassword').val());
        
                if (profilePictureFile) {
                    readFileAsBase64(profilePictureFile, function (profilePicBase64) {
                        formData.append('profilePicture', profilePicBase64);
                        submitForm(ajaxUrl, formData, adminPreview);
                    });
                } else {
                    submitForm(ajaxUrl, formData, adminPreview);
                }
            });
            });
        } else if (accountType === 'superadmin') {
            ajaxUrl = '../process/createSuperadminAccount.php';
            var profilePictureFile = $('#superAdminProfilePicture')[0].files[0];
            var superAdminId = $('#superAdminID').val(); // Super Admin ID check
            var email = $('#superAdminEmail').val();
        
            // Check if Super Admin ID exists
            checkIdExists('superadmin', superAdminId, function (exists) {
                if (exists) {
                    showModalAlert('Super Admin ID already exists. Please use a different ID.', 'danger');
                    return;
                }
                 
            checkEmailExists(email, function (exists) {
                if (exists) {
                    showModalAlert('Email already exists. Please use a different email.', 'danger');
                    return;
                }
                // Proceed with form submission
                var formData = new FormData();
                formData.append('accountType', 'superadmin');
                formData.append('superAdminID', superAdminId);
                formData.append('firstName', $('#superAdminFirstName').val());
                formData.append('middleName', $('#superAdminMiddleName').val());
                formData.append('lastName', $('#superAdminLastName').val());
                formData.append('email', $('#superAdminEmail').val());
                formData.append('username', $('#superAdminUsername').val());
                formData.append('password', $('#superAdminPassword').val());
        
                if (profilePictureFile) {
                    readFileAsBase64(profilePictureFile, function (profilePicBase64) {
                        formData.append('profilePicture', profilePicBase64);
                        submitForm(ajaxUrl, formData, superAdminPreview);
                    });
                } else {
                    submitForm(ajaxUrl, formData, superAdminPreview);
                }
            });
        });
        
        } else if (accountType === 'clerk') {
            ajaxUrl = '../process/createClerkAccount.php';
            var profilePictureFile = $('#clerkProfilePicture')[0].files[0];
            var clerkId = $('#clerkID').val(); // Clerk ID check
            var email = $('#clerkEmail').val();
        
            // Check if Clerk ID exists
            checkIdExists('clerk', clerkId, function (exists) {
                if (exists) {
                    showModalAlert('Clerk ID already exists. Please use a different ID.', 'danger');
                    return;
                }
                 
            checkEmailExists(email, function (exists) {
                if (exists) {
                    showModalAlert('Email already exists. Please use a different email.', 'danger');
                    return;
                }
                // Proceed with form submission
                var formData = new FormData();
                formData.append('accountType', 'clerk');
                formData.append('clerkID', clerkId);
                formData.append('firstName', $('#clerkFirstName').val());
                formData.append('middleName', $('#clerkMiddleName').val());
                formData.append('lastName', $('#clerkLastName').val());
                formData.append('email', $('#clerkEmail').val());
                formData.append('username', $('#clerkUsername').val());
                formData.append('password', $('#clerkPassword').val());
        
                if (profilePictureFile) {
                    readFileAsBase64(profilePictureFile, function (profilePicBase64) {
                        formData.append('profilePicture', profilePicBase64);
                        submitForm(ajaxUrl, formData, clerkPreview);
                    });
                } else {
                    submitForm(ajaxUrl, formData, clerkPreview);
                }
            });
        });
        }
        else if (accountType === 'faculty') {
            ajaxUrl = '../process/createFacultyAccount.php';
            var profilePictureFile = $('#facultyrofilePicture')[0].files[0];
            var facultyId = $('#facultyId').val(); 
            var email = $('#facultyEmail').val();
        
            // Check if Clerk ID exists
            checkIdExists('faculty', facultyId, function (exists) {
                if (exists) {
                    showModalAlert('Faculty ID already exists. Please use a different ID.', 'danger');
                    return;
                }
                 
            checkEmailExists(email, function (exists) {
                if (exists) {
                    showModalAlert('Email already exists. Please use a different email.', 'danger');
                    return;
                }
                // Proceed with form submission
                var formData = new FormData();
                formData.append('accountType', 'faculty');
                formData.append('facultyId', facultyId);
                formData.append('firstName', $('#facultyFirstName').val());
                formData.append('middleName', $('#facultyMiddleName').val());
                formData.append('lastName', $('#facultyLastName').val());
                formData.append('email', $('#facultyEmail').val());
                formData.append('username', $('#facultyUsername').val());
                formData.append('password', $('#facultyPassword').val());
        
                if (profilePictureFile) {
                    readFileAsBase64(profilePictureFile, function (profilePicBase64) {
                        formData.append('profilePicture', profilePicBase64);
                        submitForm(ajaxUrl, formData, facultyPreview);
                    });
                } else {
                    submitForm(ajaxUrl, formData, facultyPreview);
                }
            });
        });
        }
        
        // Function to handle form submission
        function submitForm(ajaxUrl, formData, previewElement, qrcodeContainer) {
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
                    if (previewElement) {
                        previewElement.src = '';
                        previewElement.style.display = 'none';
                    }
                    if (qrcodeContainer) {
                        document.body.removeChild(qrcodeContainer);
                    }
                },
                error: function (xhr, status, error) {
                    closeModal(); // Close the modal before showing the alert
                    showAlert('An error occurred: ' + xhr.responseText, 'danger');
                }
            });
        }
        
    });
    
    $('#submitEditAccountForm').click(function (e) {
        console.log("submitEdit");
        e.preventDefault(); // Prevent the default form submission
    
        var accountType = $('#accountType').val();
        var formData = new FormData();
        var ajaxUrl = '';
    
        // Function to check if email exists in the accounts table
        function checkEmailExists(email, callback) {
            $.ajax({
                url: '../process/checkEmailExists.php',
                type: 'POST',
                data: { email: email },
                success: function (response) {
                    var data = JSON.parse(response);
                    callback(data.exists); // Pass true or false to the callback
                },
                error: function () {
                    showModalAlert('Error checking email existence.', 'danger');
                    callback(null); // Pass null if there's an error
                }
            });
        }
    
        function handleAjaxResponse(response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.status == "success") {
                $('#alertContainer').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${jsonResponse.message}
                        <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            } else {
                $('#alertContainer').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${jsonResponse.message}
                        <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
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
    
        var email = '';
        if (accountType === 'student') {
            ajaxUrl = '../process/editStudentAccount.php';
            email = $('#studentEmail').val();
            formData.append('accountType', 'student');
            formData.append('studentId', $('#studentId').val());
            formData.append('firstName', $('#studentFirstName').val());
            formData.append('middleName', $('#studentMiddleName').val());
            formData.append('lastName', $('#studentLastName').val());
            formData.append('course' , $('#studentCourse').val());
            formData.append('year', $('#studentYear').val());
            formData.append('section', $('#studentSection').val());
            formData.append('email', email);
            formData.append('guardianName', $('#guardianName').val());
            formData.append('guardianContact', $('#guardianContactNumber').val());
        } else if (accountType === 'admin') {
            ajaxUrl = '../process/editAdminAccount.php';
            email = $('#adminEmail').val();
            formData.append('accountType', 'admin');
            formData.append('adminID', $('#adminID').val());
            formData.append('firstName', $('#adminFirstName').val());
            formData.append('middleName', $('#adminMiddleName').val());
            formData.append('lastName', $('#adminLastName').val());
            formData.append('email', email);
        } else if (accountType === 'superadmin') {
            ajaxUrl = '../process/editSuperAdminAccount.php';
            email = $('#superAdminEmail').val();
            formData.append('accountType', 'superadmin');
            formData.append('superAdminID', $('#superAdminID').val());
            formData.append('firstName', $('#superAdminFirstName').val());
            formData.append('middleName', $('#superAdminMiddleName').val());
            formData.append('lastName', $('#superAdminLastName').val());
            formData.append('email', email);
        } else if (accountType === 'clerk') {
            ajaxUrl = '../process/editClerkAccount.php';
            email = $('#clerkEmail').val();
            formData.append('accountType', 'clerk');
            formData.append('clerkID', $('#clerkID').val());
            formData.append('firstName', $('#clerkFirstName').val());
            formData.append('middleName', $('#clerkMiddleName').val());
            formData.append('lastName', $('#clerkLastName').val());
            formData.append('email', email);
        } else if (accountType === 'faculty') {
            ajaxUrl = '../process/editFacultyAccount.php';
            email = $('#facultyEmail').val();
            formData.append('accountType', 'faculty');
            formData.append('facultyId', $('#facultyId').val());
            formData.append('firstName', $('#facultyFirstName').val());
            formData.append('middleName', $('#facultyMiddleName').val());
            formData.append('lastName', $('#facultyLastName').val());
            formData.append('advisoryClass', $('#facultyAdvisoryClass').val());
            formData.append('email', email);
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
    
        // Check if the email already exists before proceeding
        checkEmailExists(email, function(exists) {
            if (exists) {
                $('#alertContainer').html(`
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        This email is already in use. Please use a different email.
                        <button type="button" class="btn-close border-0 bg-transparent position-absolute top-0 end-0" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            } else {
                // Submit the form data via AJAX if email does not exist
                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: handleAjaxResponse,
                    error: handleAjaxError
                });
            }
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
