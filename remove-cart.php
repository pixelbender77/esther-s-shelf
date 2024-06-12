<?php
session_start();
include('database.php');

if (isset($_SESSION["user_id"]) && isset($_GET["book_id"])) {
    $user_id = $_SESSION["user_id"];
    $book_id = intval($_GET["book_id"]);

    $deleteQuery = "DELETE FROM cart_items WHERE user_id = $user_id AND book_id = $book_id";
    if (mysqli_query($mysqli, $deleteQuery)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
} else {
    echo json_encode(["success" => false]);
}
?>
