<?php
include 'db_config.php'; // Include database configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username)) {
        echo "Please enter a username";
    } elseif (empty($password)) {
        echo "Please enter a password";
    } else {
        // Check if username already exists
        $sql_check = "SELECT * FROM users WHERE username='$username'";
        $result_check = mysqli_query($conn, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            echo "Username already taken. Please choose another one.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hash')";
            if (mysqli_query($conn, $sql)) {
                echo "You are now registered!";
                header("Location: loginsystem.php"); // Redirect to login page
                exit(); // Ensure no further code is executed
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
    mysqli_close($conn); // Close the connection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        h1 {
            color: brown;
            text-align: center;
            font-size: 100px;
        }
        div {
            color: black;
            text-align: left;
        }
    </style>
</head>
<body style="background-color: aquamarine;">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1>Register here</h1>
        <div>
            Username: <br>
            <input type="text" name="username" required>
        </div>
        <div>
            Password: <br>
            <input type="password" name="password" required>
            <br>
            <input type="submit" name="Register" value="Register">
            <br>
        </div>
    </form>
</body>
</html>
