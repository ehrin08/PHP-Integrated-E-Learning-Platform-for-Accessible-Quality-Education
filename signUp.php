<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script> <!-- Include the reusable script -->
</head>

<body>
    <nav>
        <a href="index.php">
            <h3>EmpowerEd</h3>
        </a>
    </nav>
    <div class="front">
        <h4 style="padding: 40px;">Create Account</h4>
        <form id="signUpForm" onsubmit="handleSignUpFormSubmission(event)">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>

            <div class="center">
                <button type="submit" class="btns">Create Account</button>
            </div>
        </form>
    </div>

</body>

</html>
