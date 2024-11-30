<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <nav>
        <a href="home.php">
            <h3>EmpowerEd</h3>
        </a>
    </nav>
    <div class="front">
        <h3 style="padding: 40px;">Upload File</h3>
        <form action="b-upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="document" class="form-control" required accept=".pdf">

            <br>
            <input type="text" name="title" id="title" placeholder="Title" required class="form-control">
            <button type="submit" class="btns-h"> Submit</button>
        </form>

    </div>
</body>

</html>