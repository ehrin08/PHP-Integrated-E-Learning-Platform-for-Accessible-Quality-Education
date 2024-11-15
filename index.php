<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EmpowerEd</title>
</head>

<body>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="student">Student</option>
            <option value="contributor">Contributor</option>
        </select>
        <br><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>