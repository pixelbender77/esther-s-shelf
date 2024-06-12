<?php
session_start();
include('database.php');

if (isset($_SESSION["user_id"]) && isset($_GET["book_id"]) && isset($_GET["qty"])) {
    $user_id = $_SESSION["user_id"];
    $book_id = intval($_GET["book_id"]);
    $qty = intval($_GET["qty"]);

    $updateQuery = "UPDATE cart_items SET qty = $qty WHERE user_id = $user_id AND book_id = $book_id";
    if (mysqli_query($mysqli, $updateQuery)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
} else {
    echo json_encode(["success" => false]);
}
?>
