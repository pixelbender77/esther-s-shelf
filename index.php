<?php

session_start();
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
    <link rel="stylesheet" href="style.css">
    
    <style>
        body {
            padding-top: 100px; /* Navbar height and more */
        }
    </style>
</head>
<body >
    <?php include 'header.php'; ?>
    
    <div class="container mt-4 fill-page">
        <?php if (isset($user)): ?>
            <!-- <h4 style="margin-top: 40px;">Welcome <?= htmlspecialchars($user["name"]) ?>!</h4> -->
            <div class="d-flex justify-content-center align-items-center" style="margin-top: 80px;">
                <div style="width: 200px; height:auto; margin-right: 50px;">
                    <img src="assets/logo.png" style="width: 100%; height:auto;">
                </div>
                <div style="flex:2;">
                    <h3>Our books answer your questions.</h3>
                    <p style="color: gray; font-size: 1.2rem;">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati atque perspiciatis praesentium molestias eius sapiente veniam, sit vero nobis eligendi debitis, assumenda pariatur sapiente veniam, sit vero nobis eligendi debitis, assumenda pariatur dolores enim in iusto dolores enim in iusto quo quas aperiam! Visit our <a style="color: var(--ACCENT);" href="catalog.php">Catalog</a>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <p><a href="login.php">Log in</a> or <a href="signup.html">Sign up</a></p>
        <?php endif; ?>
    </div> 
    <?php include 'footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2IWO6Io5RkycJ2mLNIGeLZ6I2FQnmWgtiJEHcNf5Wq6p6YfRvH+zB5f8GDr" crossorigin="anonymous"></script>
</body>
</html>

