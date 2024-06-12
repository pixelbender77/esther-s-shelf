<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .order-table th, .order-table td {
            vertical-align: middle;
            text-align: center;
            padding: 20px!important;
        }
    </style>
</head>
<body>
    <?php include 'header.php';  //including the header(which starts session)
        if (!isset($_SESSION["user_id"])) {
            header("Location: login.php");
            exit();
        }
        include('database.php');
        // Retrieve the logged-in user's orders
        $user_id = intval($_SESSION["user_id"]);
        $sqlSelect = "SELECT o.id, o.shipping_address, o.payment_method, o.status, o.city, o.country, o.card_info, b.title, b.author, b.price
                    FROM orders o
                    JOIN cart_items c ON o.cart_item_id = c.id
                    JOIN books b ON c.book_id = b.id
                    WHERE o.user_id = $user_id";
        $result = mysqli_query($mysqli, $sqlSelect); #fetching data to be displyed on page
    ?>

    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>My Orders</h1>
            <a href="catalog.php" class="view-link">Back to Catalog</a>
        </header>
        
        <?php if (isset($_SESSION["order_success"])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION["order_success"];
                unset($_SESSION["order_success"]);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION["order_error"])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION["order_error"];
                unset($_SESSION["order_error"]);
                ?>
            </div>
        <?php endif; ?>
        
        <table class="table table-bordered order-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Shipping Address</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Card Info</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_array($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['title']); ?></td>
                    <td><?php echo htmlspecialchars($order['author']); ?></td>
                    <td><?php echo htmlspecialchars($order['price']); ?> FCFA</td>
                    <td><?php echo htmlspecialchars($order['shipping_address']); ?></td>
                    <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td><?php echo htmlspecialchars($order['city']); ?></td>
                    <td><?php echo htmlspecialchars($order['country']); ?></td>
                    <td><?php echo htmlspecialchars($order['card_info']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
