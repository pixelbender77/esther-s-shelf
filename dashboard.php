<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Admin | Dashboard</title>
    <style>
        table td, table th {
            vertical-align: middle;
            text-align: center;
            padding: 20px!important;
        }
        .alert {
            text-align: center;
        }
    </style>
</head>
<body>
    
    <?php include 'header.php'; ?>
    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Dashboard</h1>
            <div>
                <a href="create.php" class="btn btn-secondary"><i class="fas fa-plus-circle"></i> Add a Book</a>
            </div>
        </header>

        <?php
        if (isset($_SESSION["create"])) {
            echo '<div class="alert alert-success">' . $_SESSION["create"] . '</div>';
            unset($_SESSION["create"]);
        }
        if (isset($_SESSION["update"])) {
            echo '<div class="alert alert-success">' . $_SESSION["update"] . '</div>';
            unset($_SESSION["update"]);
        }
        if (isset($_SESSION["delete"])) {
            echo '<div class="alert alert-success">' . $_SESSION["delete"] . '</div>';
            unset($_SESSION["delete"]);
        }
        ?>
            <!-- Books Section -->
            <h2 style="color:gray">Books</h2>

            <div class="tab-pane fade show active" id="books" role="tabpanel" aria-labelledby="books-tab">
                <table class="table table-bordered table-striped mt-4">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('database.php');
                        $sqlSelect = "SELECT * FROM books";
                        $result = mysqli_query($mysqli, $sqlSelect);
                        while ($data = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['title']; ?></td>
                            <td><?php echo $data['author']; ?></td>
                            <td><?php echo $data['price']; ?> FCFA</td>
                            <td>
                                <a href="view.php?id=<?php echo $data['id']; ?>" class="btn"><i class="fas fa-eye"></i></a>
                                <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn"><i class="fas fa-edit"></i></a>
                                <a href="delete.php?id=<?php echo $data['id']; ?>" class="btn"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <h2 style="color:gray">Orders</h2>
            <!-- Orders Section -->
            <table class="table table-bordered table-striped mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Book Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Shipping Address</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlSelectOrders = "SELECT o.id as order_id, o.user_id, b.title as book_title, c.qty, b.price, (c.qty * b.price) as total, o.shipping_address, o.payment_method, o.status
                                        FROM orders o
                                        JOIN cart_items c ON o.cart_item_id = c.id
                                        JOIN books b ON c.book_id = b.id";
                    $resultOrders = mysqli_query($mysqli, $sqlSelectOrders);
                    $totalAmount = 0;
                    while ($order = mysqli_fetch_array($resultOrders)) {
                        $totalAmount += $order['total'];
                    ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo $order['user_id']; ?></td>
                        <td><?php echo $order['book_title']; ?></td>
                        <td><?php echo $order['qty']; ?></td>
                        <td><?php echo $order['price']; ?> FCFA</td>
                        <td><?php echo $order['total']; ?> FCFA</td>
                        <td><?php echo $order['shipping_address']; ?></td>
                        <td><?php echo $order['payment_method']; ?></td>
                        <td><?php echo $order['status']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Total Amount:</th>
                        <th colspan="4"><?php echo $totalAmount; ?> FCFA</th>
                    </tr>
                </tfoot>
            </table>
        
    </div>
    <?php include 'footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2IWO6Io5RkycJ2mLNIGeLZ6I2FQnmWgtiJEHcNf5Wq6p6YfRvH+zB5f8GDr" crossorigin="anonymous"></script>
</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Admin | Dashboard</title>
    <style>
        table  td, table th{
        vertical-align:middle;
        text-align:right;
        padding:20px!important;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Book List</h1>
            <div>
                <a href="create.php" class="btn btn-primary">Add a Book</a>
            </div>
        </header>
        <?php
        // session_start();
        // if (isset($_SESSION["create"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            // echo $_SESSION["create"];
            ?>
        </div>
        <?php
        // unset($_SESSION["create"]);
        // }
        ?>
         <?php
        // if (isset($_SESSION["update"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            // echo $_SESSION["update"];
            ?>
        </div>
        <?php
        // unset($_SESSION["update"]);
        // }
        ?>
        <?php
        // if (isset($_SESSION["delete"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            // echo $_SESSION["delete"];
            ?>
        </div>
        <?php
        // unset($_SESSION["delete"]);
        // }
        ?>
        
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                <th>price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
        <?php
        // include('database.php');
        // $sqlSelect = "SELECT * FROM books";
        // $result = mysqli_query($mysqli,$sqlSelect);
        // while($data = mysqli_fetch_array($result)){
            ?>
            <tr>
                <td><?php //echo $data['id']; ?></td>
                <td><?php //echo $data['title']; ?></td>
                <td><?php //echo $data['author']; ?></td>
                <td><?php //echo $data['price']; ?> FCFA</td>
                <td>
                    <a href="view.php?id=<?php //echo $data['id']; ?>" class="btn btn-info">View</a>
                    <a href="edit.php?id=<?php //echo $data['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?id=<?php //echo $data['id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <?php
        //}
        ?>
        </tbody>
        </table>
    </div>
</body>
</html> -->