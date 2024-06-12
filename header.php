<!-- Header Component-->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            padding-top: 56px; /* Navbar height */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="margin: 5px; padding: 10px; background-color: gray;">
        <div class="container-fluid" >
            <a class="navbar-brand" href="index.php"><img src="assets/logo.png" style="width: 100px; height: auto; "></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="catalog.php">Catalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                    <?php if (isset($user) && $user["is_admin"]): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Admin</a>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($user)): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="view-profile.php?id=<?= $user["id"]; ?>" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlspecialchars($user["name"]) ?>
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.html">Sign up</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
