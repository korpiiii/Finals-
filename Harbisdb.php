<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    
<form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
   
           
        <div>
            <input type="text" id="username" name="username" placeholder="username">
        </div>

        <div>
            <input type="password" id="password" name="password" placeholder="password">
        <br>
            <input type="submit"  name="login" value="login">
            <br>
            
        </div>
        
        

        <div></div>


</body>
</html>


<?php

//PASSWORD HASH 
//          hashing = transforming sensitive data (password)  into letters, numbers, and/or symbols
//          via a mathematical process. (similar to encryption)
//          Hides the original data from 3rd parties.

$password = "blitz112";

$hash = password_hash($password, PASSWORD_DEFAULT);


if(password_verify("blitz112", $hash)){
    echo "You are logged in! <br>";
}
else { echo"Incorrect password!";
}
?>

<?php

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "harbisdb";
$conn ="";

try {
    $conn = mysqli_connect($db_server,
                       $db_user,
                       $db_pass,
                       $db_name);
}
catch(mysqli_sql_exception) {
    echo "Could not connect!";
}

if($conn){ 
    echo"You are connected!";
}


?>