<?php
session_start();

// Redirect if the user is already logged in
if (isset($_SESSION["user"])) {
    // Redirect to index.php and exit to prevent further code execution
    header("Location: index.php");
    exit; // Make sure to stop further script execution
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    require_once "database.php"; // Include database connection

    // Prepare and execute query to check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    // Check if the user exists
    if ($user) {
        // Verify the password using password_verify
        if (password_verify($password, $user["password"])) {
            // Start session and store user info
            $_SESSION["user"] = "yes";
            // Redirect to the index page after successful login
            header("Location: index.php");
            exit; // Make sure to stop further script execution
        } else {
            // Show error message if the password does not match
            $error_message = "<div class='alert alert-danger'>Password does not match</div>";
        }
    } else {
        // Show error message if the email does not match
        $error_message = "<div class='alert alert-danger'>Email does not match</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        // Display error message if any
        if (isset($error_message)) {
            echo $error_message;
        }
        ?>

        <!-- Login form -->
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control" required>
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>

        <!-- Link to the registration page if not registered -->
        <div><p>Not registered yet? <a href="registration.php">Register Here</a></p></div>
    </div>
</body>
</html>
