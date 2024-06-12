<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include('database.php');

// Fetch user ID from session and cart item ID from URL
$user_id = $_SESSION["user_id"];
$cart_item_id = isset($_GET["cart_item_id"]) ? intval($_GET["cart_item_id"]) : 0;

if ($cart_item_id == 0) {
    header("Location: cart.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .order-form {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f9f9f9;
        }
        .order-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .order-form .form-group {
            margin-bottom: 15px;
        }
        .order-form .form-control {
            height: 45px;
        }
        .order-form .btn {
            width: 100%;
            padding: 10px;
        }
    </style>
</head>
<body>
    <a href="cart.php?id=<?php echo $user_id ?>" class="btn btn-secondary btn-back" style="position: absolute; left: 100px; top: 50px; width: 100px;"><i class="fas fa-arrow-left"></i> Back</a>

    <div class="container order-form">
        <h2>Place Your Order</h2>
        <form action="save-order.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="cart_item_id" value="<?php echo $cart_item_id; ?>">

            <div class="form-group">
                <label for="shipping_address">Shipping Address</label>
                <input type="text" class="form-control" id="shipping_address" name="shipping_address" required>
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="form-group">
                <label for="card_info">Card Info</label>
                <input type="text" class="form-control" id="card_info" name="card_info" placeholder="Card Number" required>
            </div>

            <button type="submit" class="btn btn-primary" style="background-color: #AA6688; color: white; border:none;">Place Order</button>
        </form>
    </div>
</body>
</html>
