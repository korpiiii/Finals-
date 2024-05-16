<?php
session_start();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order System</title>
</head>
<body style="background-color: aquamarine;">
    <h1 style="color: brown;"> Welcome to Harbi's </h1>

    <!--logout-->
    <form action="Ordersystem.php" method="post">
        <input type="submit" name="logout" value="logout">
    </form>

    <ul>
        <li>Adobo - 30 PHP</li>
        <li>Sinigang - 40 PHP</li>
        <li>Menudo - 50 PHP</li>
        <li>Sisig - 60 PHP</li>
    </ul>
    <form action="orderSystem.php" method="post">
        <label for="order">Choose your order:</label>
        <select name="order">
            <option value="Adobo">Adobo</option>
            <option value="Sinigang">Sinigang</option>
            <option value="Menudo">Menudo</option>
            <option value="Sisig">Sisig</option>
        </select><br><br>
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity"><br><br>
        <label for="cash">Cash:</label>
        <input type="text" name="cash"><br><br>
        <input type="submit" value="Submit">
    </div>
</body>
</html>

<?php

echo $_SESSION["username"] . "<br>";
echo $_SESSION["password"] . "<br>";

    if(isset($_POST["logout"])) {

    session_destroy();
    header("Location:Loginsystem.php");
    }




    //pricelist
    $Adobo = 30;
    $Sinigang = 40;
    $Menudo = 50;
    $Sisig = 60;
    
    if (empty($_POST["quantity"]) || empty($_POST["cash"])) {
    } else {
        //Invalidation if ever they typed a string
        if (is_numeric($_POST["quantity"]) && is_numeric($_POST["cash"])) {
            if ($_POST["order"] == "Adobo") {
                $_POST["order"] = $Adobo;
            } elseif ($_POST["order"] == "Sinigang") {
                $_POST["order"] = $Sinigang;
            } elseif ($_POST["order"] == "Menudo") {
                $_POST["order"] = $Menudo;
            } elseif ($_POST["order"] == "Sisig") {
                $_POST["order"] = $Sisig;
            }
            $order = $_POST["order"];
            $quantity = ($_POST["quantity"]);
            $cash = ($_POST["cash"]);
            $total_cost = $order * $quantity;
            $change = $cash - $total_cost;
            if ($quantity <= 0) {
                echo"<br>Invalid";
            } elseif ($total_cost <= $cash) {
                echo"<strong><br> The total cost is {$total_cost} <br>";
                echo"Your change is {$change}<br><br></strong>";
                echo"Thanks for the order!";
            } else {
                echo "<strong><br>Insufficient Balance</strong>  ";
            }
        } else {
            echo "<br>Invalid Input";
        }
    }




    $users = array(
  "user1" => "password1",
  "user2" => "password2"
);

if (file_exists('users.json')) {
  $users = json_decode(file_get_contents('users.json'), true);
}

$message = "";

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (array_key_exists($username, $users) && $users[$username] == $password) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
  } else {
    $message = "Invalid username or password.";
  }
}

if (isset($_POST['logout'])) {
  session_unset();
  session_destroy();
  header("Location:Loginsystem.php " . $_SERVER['PHP_SELF']);
  exit();
}


if (isset($_POST['register'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (!array_key_exists($username, $users)) {
    $users[$username] = $password;

    file_put_contents('users.json', json_encode($users));
    $message = "Registration successful. Please log in.";
  } else {
    $message = "Username already exists.";
  }
}

if (isset($_POST['submit'])) {
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $selectedItem = $_POST['food_item'];
    $quantity = (int)$_POST['quantity'];
    $cashPaid = (float)$_POST['cash_paid'];

    if (!empty($selectedItem) && $quantity > 0 && $cashPaid >= 0) {
      $totalCost = $foodItems[$selectedItem] * $quantity;

      if ($cashPaid >= $totalCost) {
        $change = $cashPaid - $totalCost;
        $message = "Your order for " . $quantity . " " . $selectedItem . " has been placed! Change due: PHP" . number_format($change, 2);
      } else {
        $message = "Insufficient cash. Total cost is PHP" . number_format($totalCost, 2) . ". Please enter a higher amount.";
      }
    } else {
      $message = "Please select a food item, enter a valid quantity, and cash amount.";
    }
  } else {
    $message = "Please log in to place an order.";
  }
}
?>
