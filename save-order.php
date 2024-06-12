<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include('database.php');

// Retrieving form inputs and escaping cyber attacks
$user_id = intval($_POST['user_id']);
$cart_item_id = intval($_POST['cart_item_id']);
$shipping_address = mysqli_real_escape_string($mysqli, $_POST['shipping_address']);
$payment_method = mysqli_real_escape_string($mysqli, $_POST['payment_method']);
$status = "Pending"; // Default status for a new order
$city = mysqli_real_escape_string($mysqli, $_POST['city']);
$country = mysqli_real_escape_string($mysqli, $_POST['country']);
$card_info = mysqli_real_escape_string($mysqli, $_POST['card_info']);

// Insert the order into the database
$sqlInsert = "INSERT INTO orders (user_id, cart_item_id, shipping_address, payment_method, status, city, country, card_info)
              VALUES ('$user_id', '$cart_item_id', '$shipping_address', '$payment_method', '$status', '$city', '$country', '$card_info')";

if (mysqli_query($mysqli, $sqlInsert)) {
    // Order placed successfully
    $_SESSION["order_success"] = "Your order has been placed successfully!";
    header("Location: orders.php"); // Redirect to orders page or a success page
} else {
    // Error placing order
    $_SESSION["order_error"] = "There was an error placing your order. Please try again.";
    header("Location: place-order.php?user_id=$user_id&cart_item_id=$cart_item_id"); // Redirect back to place order page
}
?>
