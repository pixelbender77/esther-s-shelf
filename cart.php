
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-container {
            margin-top: 50px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .cart-item img {
            width: 100px;
            height: auto;
        }
        .cart-item-info {
            flex: 1;
            margin-left: 20px;
        }
        .cart-item-actions {
            display: flex;
            align-items: center;
        }
        .cart-item-actions input {
            width: 50px;
            margin: 0 10px;
            text-align: center;
        }
        .cart-item-actions .btn {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; //Includind header
        
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }
    include('database.php');
    // Fetch user ID from session
    $user_id = $_SESSION["user_id"];
    // Fetch cart items for the user
    $sqlSelect = "SELECT cart_items.*, books.title, books.price, books.cover 
                FROM cart_items 
                JOIN books ON cart_items.book_id = books.id 
                WHERE cart_items.user_id = $user_id";
    $result = mysqli_query($mysqli, $sqlSelect); // making the fetch for display
?>

    <div class="container cart-container">
        <h1>Shopping Cart</h1>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="cart-items">
                <?php while ($item = mysqli_fetch_assoc($result)): ?>
                    <div class="cart-item" data-book-id="<?php echo $item['book_id']; ?>">
                        <div class="cart-item-image">
                            <img src="covers/<?php echo $item['cover']; ?>" alt="<?php echo $item['title']; ?>">
                        </div>
                        <div class="cart-item-info">
                            <h4><?php echo $item['title']; ?></h4>
                            <p><?php echo $item['price']; ?> FCFA</p>
                            <a href="place-order.php?user_id=<?php echo $user_id ?>&cart_item_id=<?php echo $item['id']?>" class='view-link to-end'>Place Order</a>
                        </div>
                        <div class="cart-item-actions">
                            <button class="btn btn-outline-secondary decrease-qty"><i class="fas fa-minus"></i></button>
                            <input type="number" name="quantity" value="<?php echo $item['qty']; ?>" min="1" readonly>
                            <button class="btn btn-outline-secondary increase-qty"><i class="fas fa-plus"></i></button>
                            <button class="btn btn-danger remove-item"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Your cart is empty.</p>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartItems = document.querySelectorAll('.cart-item');
            
            cartItems.forEach(item => {
                const bookId = item.getAttribute('data-book-id');
                const qtyInput = item.querySelector('input[name="quantity"]');
                const decreaseBtn = item.querySelector('.decrease-qty');
                const increaseBtn = item.querySelector('.increase-qty');
                const removeBtn = item.querySelector('.remove-item');
                
                decreaseBtn.addEventListener('click', function () {
                    let qty = parseInt(qtyInput.value);
                    if (qty > 1) {
                        qtyInput.value = --qty;
                        updateCart(bookId, qty);
                    }
                });
                
                increaseBtn.addEventListener('click', function () {
                    let qty = parseInt(qtyInput.value);
                    qtyInput.value = ++qty;
                    updateCart(bookId, qty);
                });
                
                removeBtn.addEventListener('click', function () {
                    removeFromCart(bookId);
                });
            });
        });
        
        function updateCart(bookId, qty) {
            fetch(`update-cart.php?book_id=${bookId}&qty=${qty}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Cart updated successfully');
                    } else {
                        console.error('Failed to update cart');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
        
        function removeFromCart(bookId) {
            fetch(`remove-cart.php?book_id=${bookId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`.cart-item[data-book-id="${bookId}"]`).remove();
                    } else {
                        console.error('Failed to remove item from cart');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
