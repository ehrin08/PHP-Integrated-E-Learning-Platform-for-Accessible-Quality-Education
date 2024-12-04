<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h4 style="padding: 40px;">Login</h4>
        <form id="loginForm" onsubmit="return handleLoginFormSubmission(event)">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" class="form-control" required>

            <br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>

            <br><br>

            <button type="submit" class="btns">Login</button>
        </form>
    </div>

</body>

</html>
