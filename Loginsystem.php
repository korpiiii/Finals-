<?php
session_start();
include 'db_config.php'; // Include database configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header("Location: ordersystem.php");
                exit();
            } else {
                echo "Incorrect password!";
            }
        } else {
            echo "No user found with that username!";
        }
    } else {
        echo "Missing username or password";
    }
    mysqli_close($conn); // Close the connection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        h1 {
            color: brown;
            text-align: center;
            font-size: 100px;
        }
        h4 {
            color: black;
            text-align: center;
        }
        div {
            color: black;
            text-align: center;
        }
    </style>
</head>
<body style="background-color: aquamarine;">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1>Harbi's <br> Restaurant</h1>
        <h4>Login here</h4>
        <div>
            <input type="text" id="username" name="username" placeholder="Username" required>
        </div>
        <div>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <br>
            <input type="submit" name="login" value="Login">
            <br>
        </div>
        <div>
            <a href="registration.php" target="_self">Register</a>
        </div>
    </form>
</body>
</html>
