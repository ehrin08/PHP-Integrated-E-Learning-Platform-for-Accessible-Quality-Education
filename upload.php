<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
</head>

<body>
    <h1>Upload File</h1>
    <form action="b-upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="document" required>
        <br>
        <label for="title">Title: </label>
        <input type="text" name="title" id="title" required>
        <br><br>
        <button type="submit"> Submit</button>
    </form>
    <br>
    <a href="home.php">Home</a>

</body>

</html>