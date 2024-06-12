<?php
include('database.php'); //including the database in the operations

// ADD BOOK ================================
if (isset($_POST["create"])) {
    $title = mysqli_real_escape_string($mysqli, $_POST["title"]);
    $type = mysqli_real_escape_string($mysqli, $_POST["type"]);
    $author = mysqli_real_escape_string($mysqli, $_POST["author"]);
    $description = mysqli_real_escape_string($mysqli, $_POST["description"]);
    $price = mysqli_real_escape_string($mysqli, $_POST["price"]);
    
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $fileName = $_FILES["image"]["name"];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        $tempName = $_FILES["image"]["tmp_name"];
        $targetPath = "covers/".$fileName;
        
        if (in_array($ext, $allowedTypes)) { // making sure the uploaded file is allowed
            if (move_uploaded_file($tempName, $targetPath)) { // moving uploaded file to the website's uploads
                $query = "INSERT INTO books(title, author, type, description, cover, price) VALUES ('$title','$author','$type', '$description','$fileName','$price')";
                if (mysqli_query($mysqli, $query)) {
                    session_start();
                    $_SESSION["create"] = "Book Added Successfully!";
                    header("Location:dashboard.php");
                } else {
                    die("Something went wrong with the database query.");
                }
            } else {
                die("File upload failed.");
            }
        } else {
            die("Your file type is not allowed.");
        }
    } else {
        die("No file uploaded or there was an upload error.");
    }
}


/// EDIT BOOK ===============================

if (isset($_POST["edit"])) {
    $title = mysqli_real_escape_string($mysqli, $_POST["title"]);
    $type = mysqli_real_escape_string($mysqli, $_POST["type"]);
    $author = mysqli_real_escape_string($mysqli, $_POST["author"]);
    $description = mysqli_real_escape_string($mysqli, $_POST["description"]);
    $price = mysqli_real_escape_string($mysqli, $_POST["price"]);

    $id = mysqli_real_escape_string($mysqli, $_POST["id"]);
    $sqlUpdate = "UPDATE books SET title = '$title', type = '$type', author = '$author', description = '$description', price = '$price' WHERE id='$id'";
    if(mysqli_query($mysqli,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Book Updated Successfully!";
        header("Location:dashboard.php");
    }else{
        die("Something went wrong");
    }
}

#EDIT USER ============================

if (isset($_POST["edit-user"])) {
    if (empty($_POST["name"])) {
        die("Name is required");
    }
    if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }

    if (strlen($_POST["password"]) < 8) {
        die("Password must be at least 8 characters");
    }
    if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter");
    }
    if ( ! preg_match("/[0-9]/", $_POST["password"])) {
        die("Password must contain at least one number");
    }
    if ($_POST["password"] !== $_POST["password_confirmation"]) {
        die("Passwords must match");
    }
    // End of validation

    $name = mysqli_real_escape_string($mysqli, $_POST["name"]);
    $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $id = mysqli_real_escape_string($mysqli, $_POST["id"]);
    $sqlUpdate = "UPDATE user SET name = '$name', email = '$email', password_hash = '$password_hash' WHERE id='$id'";
    if(mysqli_query($mysqli,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "User Updated Successfully!";
        header("Location:index.php");
    }else{
        die("Something went wrong");
    }
}


/// ADD TO CART ===================
if (isset($_GET["user_id"]) && isset($_GET["book_id"])) {
    $user_id = mysqli_real_escape_string($mysqli, $_GET["user_id"]);
    $book_id = mysqli_real_escape_string($mysqli, $_GET["book_id"]);

    // Checking if the item is already in the cart
    $check_cart = "SELECT * FROM cart_items WHERE user_id='$user_id' AND book_id='$book_id'";
    $result = mysqli_query($mysqli, $check_cart);

    if (mysqli_num_rows($result) > 0) {
        // If the item is already in the cart, we increment the quantity by 1
        $update_cart = "UPDATE cart_items SET qty = qty + 1 WHERE user_id='$user_id' AND book_id='$book_id'";
        if (mysqli_query($mysqli, $update_cart)) {
            session_start();
            $_SESSION["update"] = "Item quantity updated in cart successfully!";
            header("Location: cart.php?id=$book_id");
        } else {
            die("Something went wrong");
        }
    } else {
        // If the item is not in the cart, add it
        $add_to_cart = "INSERT INTO cart_items (user_id, book_id, qty) VALUES ('$user_id', '$book_id', 1)";
        if (mysqli_query($mysqli, $add_to_cart)) {
            session_start();
            $_SESSION["update"] = "Item added to cart successfully!";
            header("Location: cart.php?id=$book_id");
        } else {
            die("Something went wrong");
        }
    }
}


?>