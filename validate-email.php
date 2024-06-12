<?php

$mysqli = require __DIR__ . "/database.php";

$sql = sprintf("SELECT * FROM user
                WHERE email = '%s'",
                $mysqli->real_escape_string($_GET["email"]));
                
$result = $mysqli->query($sql);

$is_available = $result->num_rows === 0; //If the number of rows of the query is 0 then there was user account having that email

header("Content-Type: application/json");

echo json_encode(["available" => $is_available]);

?>