<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav>
        <a href="index.php">
            <h3>EmpowerEd</h3>
        </a>
    </nav>
    <div class="front">
        <h4 style="padding: 40px;">Create Account</h4>
        <form id="signUpForm">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
            <br><br>
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <br><br>
            <div class="center">
                <button type="submit" class="btns">Create Account</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#signUpForm').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                const formData = {
                    username: $('#username').val(),
                    email: $('#email').val(),
                    password: $('#password').val()
                };

                $.ajax({
                    url: 'b-signUp.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('body').html(response); // Render SweetAlert or page redirection
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred: ' + error,
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
