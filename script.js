$(document).ready(function() {
    $('#userTable').DataTable();
});
/**
 * General function to handle form submission using AJAX.
 * @param {string} formId - The ID of the form to submit
 * @param {string} url - The URL to submit the form data to
 * @param {function} callback - A callback to handle the response
 */
function handleFormSubmission(formId, url, callback) {
    var formData = $('#' + formId).serialize(); // Serialize form data
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (response) {
            if (callback && typeof callback === 'function') {
                callback(response);
            }
        },
        error: function () {
            Swal.fire('Error', 'An unexpected error occurred.', 'error');
        }
    });
}

/**
 * Handles the submission of the sign-up form.
 * @param {Event} event - The form submission event
 */
function handleSignUpFormSubmission(event) {
    event.preventDefault(); // Prevent the default form submission
    handleFormSubmission('signUpForm', 'b-signUp.php', function (response) {
        Swal.fire({
            title: response.status === 'error' ? 'Success!' : 'Error',
            text: response.message,
            icon: response.status
        }).then(() => {
            if (response.redirect) window.location.href = response.redirect;
        });
    });
}

/**
 * Handles the submission of the login form.
 * @param {Event} event - The form submission event
 */
function handleLoginFormSubmission(event) {
    event.preventDefault(); // Prevent the default form submission
    handleFormSubmission('loginForm', 'b-login.php', function (response) {
        Swal.fire({
            title: response.status === 'success' ? 'Success!' : 'Error',
            text: response.message,
            icon: response.status
        }).then(() => {
            if (response.redirect) window.location.href = response.redirect;
        });
    });
}

/**
 * Handles the submission of the login form.
 * @param {Event} event - The form submission event
 */

function handleFileUpload(event) {
    event.preventDefault(); // Prevent default form submission

    var formData = new FormData($('#uploadForm')[0]); // Get form data including file
    $.ajax({
        url: 'b-upload.php',
        type: 'POST',
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting contentType
        success: function(response) {
            Swal.fire({
                title: response.status === 'success' ? 'Success!' : 'Error',
                text: response.message,
                icon: response.status
            }).then(() => {
                if (response.status === 'success') {
                    location.reload(); // Reload the page on success
                }
            });
        },
        error: function() {
            Swal.fire('Error', 'An unexpected error occurred.', 'error');
        }
    });
}

// Handle file deletion using AJAX
function deleteFile(materialId) {
    console.log('deleteFile called with materialId: ' + materialId);  // Debug log
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this file?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Deleting file...');  // Debug log
            $.ajax({
                url: 'b-delete.php',
                type: 'GET',
                data: { material_id: materialId },
                success: function(response) {
                    console.log('Delete response: ', response);  // Debug log
                    Swal.fire({
                        title: response.status === 'success' ? 'Deleted!' : 'Error',
                        text: response.message,
                        icon: response.status
                    }).then(() => {
                        if (response.status === 'success') {
                            location.reload();
                        }
                    });
                },
                error: function() {
                    Swal.fire('Error', 'An unexpected error occurred while deleting the file.', 'error');
                }
            });
        }
    });
}

// Handle file editing using AJAX
function editFile(materialId) {
    console.log('editFile called with materialId: ' + materialId);  // Debug log
    $.ajax({
        url: 'b-update.php', // Placeholder for actual update script
        type: 'GET',
        data: { material_id: materialId },
        success: function(response) {
            console.log('Edit response: ', response);  // Debug log
            Swal.fire({
                title: 'Edit Success',
                text: 'Record was successfully updated!',
                icon: 'success'
            }).then(() => {
                location.reload();
            });
        },
        error: function() {
            Swal.fire('Error', 'An unexpected error occurred while editing.', 'error');
        }
    });
}

// Handle file deletion using AJAX
// Handle file deletion using AJAX
function deleteFile(materialId) {
    console.log('deleteFile called with materialId: ' + materialId);  // Debug log
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this file?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Deleting file...');  // Debug log
            $.ajax({
                url: 'b-delete.php', // URL of the PHP file to delete the record
                type: 'GET', // Use GET method
                data: { material_id: materialId }, // Pass the material ID
                success: function(response) {
                    console.log('Delete response: ', response);  // Debug log
                    let data = JSON.parse(response);  // Parse the JSON response
                    Swal.fire({
                        title: data.status === 'success' ? 'Deleted!' : 'Error',
                        text: data.message,
                        icon: data.status
                    }).then(() => {
                        if (data.status === 'success') {
                            // Remove the deleted file's row from the table without reloading the page
                            $('#fileRow' + materialId).remove();
                        }
                    });
                },
                error: function() {
                    Swal.fire('Error', 'An unexpected error occurred while deleting the file.', 'error');
                }
            });
        }
    });
}
/**
 * Handles the submission of the edit form using AJAX.
 * @param {Event} event - The form submission event.
 * @param {number} materialId - The ID of the material being edited.
 */
function handleEditFile(event, materialId) {
    event.preventDefault(); // Prevent default form submission

    // Create FormData to include file uploads
    var formData = new FormData($('#editForm')[0]);

    $.ajax({
        url: 'b-edit.php?material_id=' + materialId,
        type: 'POST',
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting contentType
        success: function(response) {
            Swal.fire({
                title: response.status === 'success' ? 'Success!' : 'Error',
                text: response.message,
                icon: response.status
            }).then(() => {
                if (response.status === 'success') {
                    window.location.href = 'upload.php'; // Redirect on success
                }
            });
        },
        error: function() {
            Swal.fire('Error', 'An unexpected error occurred.', 'error');
        }
    });
}
// script.js


/**
 * Function to handle feedback form submission using AJAX
 * @param {Event} event - The form submission event
 */
function submitFeedback(event) {
    event.preventDefault(); // Prevent default form submission

    var formData = $('#feedbackForm').serialize(); // Serialize form data

    $.ajax({
        url: 'b-feedback.php',  // PHP script to process the feedback
        type: 'POST',
        data: formData,
        success: function(response) {
            console.log('Raw response:', response); // Log raw response for debugging
        
            // No need to parse, response is already a JSON object
            var data = response;
        
            console.log('Parsed data:', data); // Log parsed data to check structure
        
            if (data.status && data.message) {
                Swal.fire({
                    title: data.status === 'success' ? 'Success!' : 'Error',
                    text: data.message,
                    icon: data.status
                }).then(() => {
                    if (data.status === 'success') {
                        // Optionally reload the feedbacks
                        $('#feedbackForm')[0].reset(); // Clear the form
                        location.reload(); // Reload the page
                    }
                });
            } else {
                // Handle case where response structure is unexpected
                Swal.fire('Error', 'Unexpected response format.', 'error');
            }
        }
        
    });
}
