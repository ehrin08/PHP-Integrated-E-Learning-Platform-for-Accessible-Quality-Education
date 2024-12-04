/**
 * General function to handle form submission using AJAX (for all forms).
 * @param {string} formId - The ID of the form to submit
 * @param {string} url - The URL to submit the form data to
 * @param {function} callback - A callback to handle the response
 * @param {boolean} isFileUpload - Flag to handle file upload (default false)
 */
function handleFormSubmission(formId, url, callback, isFileUpload = false) {
    var form = $('#' + formId)[0]; // Get the form element
    var formData;

    if (isFileUpload) {
        formData = new FormData(form); // Use FormData for file upload
    } else {
        formData = $('#' + formId).serialize(); // Serialize form data for non-file forms
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: !isFileUpload, // Do not process data for file upload
        contentType: isFileUpload ? false : 'application/x-www-form-urlencoded', // Set the correct content type for file upload
        success: function(response) {
            if (callback && typeof callback === 'function') {
                callback(response);
            }
        },
        error: function() {
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
 * Handles the submission of the file upload form.
 * @param {Event} event - The form submission event
 */
function handleFileUploadFormSubmission(event) {
    event.preventDefault(); // Prevent the default form submission
    handleFormSubmission('uploadForm', 'b-upload.php', function(response) {
        Swal.fire({
            title: response.status === 'success' ? 'Success!' : 'Error',
            text: response.message,
            icon: response.status
        }).then(() => {
            if (response.redirect) window.location.href = response.redirect;
            else location.reload(); // Reload the page to show the new file
        });
    }, true); // Pass true to indicate this is a file upload
}