<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <head>
        <style>
            /* General Reset */
            * {
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            /* Navigation Bar */
            nav {
                text-align: center;
                padding: 20px;
                box-shadow: 0 0.5px 10px 4px #dddddd;
            }

            nav a,
            nav a:hover {
                text-decoration: none;
                color: #ff8032;
            }

            /* Body Layout */
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #f9f9f9;
            }

            /* Container for Squares */
            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 0;
                padding: 0;
                /* Reduced gap between squares */
            }

            /* Square Styles */
            .square {
                width: 400px;
                /* Increased width */
                height: 400px;
                /* Increased height */
                display: flex;
                justify-content: center;
                align-items: center;
                border: 1px solid #ccc;
                background-color: white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            /* Image Inside Square */
            .square img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 10px;
            }

            /* Button Container */
            .btn-container {
                display: flex;
                flex-direction: column;
                gap: 20px;
                /* Space between buttons */
                align-items: center;
            }

            /* Button Styles */
            .btn-container a {
                display: inline-block;
                text-align: center;
                text-decoration: none;
                padding: 15px;
                border: none;
                color: white;
                background-color: #ff8032;
                border-radius: 5px;
                font-size: 18px;
                transition: all 0.3s ease;
                width: 200px;
                /* Increased button width */
                text-transform: uppercase;
            }

            .btn-container a:hover {
                background-color: #ff9d5c;
                transform: scale(1.05);
            }
        </style>

    <body>
        <div class="container">
            <div class="square">
                <img src="./source/empowered.jpg" alt="">
            </div>
            <div class="square">
                <div class="btn-container">
                    <a href="login.php">Login</a>
                    <a href="signUp.php">Sign Up</a>
                </div>
            </div>
        </div>
    </body>

</html>