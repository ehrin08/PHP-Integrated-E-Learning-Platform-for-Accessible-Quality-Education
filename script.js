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