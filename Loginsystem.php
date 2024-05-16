<?php
session_start();
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

    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
    <h1> Harbi's </h1>
            <h4>Login here</h4>
        <div>
            <input type="text" id="username" name="username" placeholder="username">
        </div>

        <div>
            <input type="password" id="password" name="password" placeholder="password">
        <br>
            <input type="submit"  name="login" value="login">
            <br>
            
        </div>
        
        

        <div>

        <a href="Harbisdb.php" target="_self"> 
            Register
        </a>

        </div>



    </form>

</body>
</html>

<?php 

if($_SERVER["REQUEST_METHOD"] == "POST"){
   


if (isset($_POST["login"])) {
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["password"] = $_POST["password"];

    if(!empty($_POST["username"]) && 
        !empty($_POST["password"])) {

            $_SESSION["username"] = $_POST["username"];
            $_SESSION["password"] = $_POST["password"];

        header("Location: Ordersystem.php");

   
}
else {
    echo " Missing username/password <br>";
}
}
}





?>