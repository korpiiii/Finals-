<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: Loginsystem.php");
    exit();
}

// Initialize variables
$order_message = "";
$error_message = "";

// Define product prices
$prices = [
    "• Adobo" => 30,
    "• Sinigang" => 40,
    "• Menudo" => 50,
    "• Sisig" => 60
];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["logout"])) {
        session_destroy();
        header("Location: Loginsystem.php");
        exit();
    }

    // Validate input
    $order = $_POST["order"] ?? '';
    $quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT);
    $cash = filter_input(INPUT_POST, "cash", FILTER_VALIDATE_FLOAT);

    // Check if input is valid
    if ($order && $quantity !== false && $cash !== false) {
        if ($quantity > 0 && array_key_exists($order, $prices)) {
            $total_cost = $prices[$order] * $quantity;
            $change = $cash - $total_cost;

            if ($total_cost <= $cash) {
                $order_message = "<strong>The total cost is {$total_cost} PHP<br>";
                $order_message .= "Your change is {$change} PHP<br><br></strong>";
                $order_message .= "Thanks for the order!";
            } else {
                $error_message = "Insufficient Balance";
            }
        } else {
            $error_message = "Invalid Quantity or Order";
        }
    } else {
        $error_message = "Invalid Input";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order System</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        h1.custom {
            font-family: "Times New Roman", Times, serif;
            font-size: 38px;
            color: brown;
        }
    </style>
</head>

<body class="bg-gradient-to-b from-green-200 to-green-100 min-h-screen flex flex-col items-center justify-center">
    <div class="w-full max-w-lg bg-white shadow-md rounded-lg p-8">
    <h1 class="custom text-center mb-8" style="font-weight: bold;">Welcome to Harbi's, <?= htmlspecialchars($_SESSION['username'] ?? ''); ?>!</h1>

        <form action="ordersystem.php" method="post" class="mb-6">
            <ul>
                <?php if(isset($prices)): ?>
                    <?php foreach ($prices as $item => $price): ?>
                        <li class="flex justify-between items-center text-gray-800">
                            <span class="font-bold"><?= htmlspecialchars($item) ?></span>
                            <span><?= $price ?> PHP</span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
          <br>
            <label for="order" class="block mb-2 text-gray-800">Choose your order:</label>
            <select name="order" id="order" class="w-full border border-gray-300 rounded-md p-2 mb-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option value="">Select an item</option>
                <?php if(isset($prices)): ?>
                    <?php foreach ($prices as $item => $price): ?>
                        <option value="<?= htmlspecialchars($item) ?>" <?= isset($_POST['order']) && $_POST['order'] == $item ? 'selected' : '' ?>>
                            <?= htmlspecialchars($item) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <label for="quantity" class="block mb-2 text-gray-800">Quantity:</label>
            <input type="text" name="quantity" id="quantity" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '' ?>" class="w-full border border-gray-300 rounded-md p-2 mb-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            <label for="cash" class="block mb-2 text-gray-800">Cash:</label>
            <input type="text" name="cash" id="cash" value="<?= isset($_POST['cash']) ? htmlspecialchars($_POST['cash']) : '' ?>" class="w-full border border-gray-300 rounded-md p-2 mb-4 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            <div class="flex justify-between">
                <button type="submit" name="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Submit</button>
                <form action="ordersystem.php" method="post">
                    <button type="submit" name="logout" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 ml-4">Logout</button>
                </form>
            </div>
        </form>
        <?php if (isset($order_message) && $order_message): ?>
            <p class="text-green-600 text-center"><?= $order_message ?></p>
        <?php endif; ?>
        <?php if (isset($error_message) && $error_message): ?>
            <p class="text-red-600 text-center"><?= $error_message ?></p>
        <?php endif; ?>
    </div>
</body>

</html>
