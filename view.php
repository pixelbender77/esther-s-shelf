<?php
    session_start();
    if (isset($_SESSION["user_id"])) {
        
        $mysqli = require __DIR__ . "/database.php";
        
        $sql = "SELECT * FROM user
                WHERE id = {$_SESSION["user_id"]}";
                
        $result = $mysqli->query($sql);
        
        $user = $result->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <title>Book Details</title>
    <style>
        .book-details{
            background-color:#f5f5f5;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Book Detail</h1>
        </header>
        <div class="book-details p-5 my-4">
            <?php
            include("database.php");
            $id = $_GET['id'];
            if ($id) {
                $sql = "SELECT * FROM books WHERE id = $id";
                $result = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_array($result)) {
                 ?>
                 <div class='cover-cart-flex'>
                    <?php
                        $fileName = $row["cover"];
                        $imageUrl = "covers/".$fileName;
                        echo "<div class='cover-detail'>";
                        echo "<img src='$imageUrl'>";
                        echo "</div>";
                    ?>
                    <a href="process.php?user_id=<?php echo $user['id']; ?>&book_id=<?php echo $row['id']; ?>" name="add-to-cart"class='view-link'>Add to Cart</a>   
                 </div>
                
                 <h3><?php echo $row["title"]; ?></h3>
                 <p><?php echo $row["description"]; ?></p>
                 <h4>Author</h4>
                 <p><?php echo $row["author"]; ?></p>
                 <h4>Type</h4>
                 <p><?php echo $row["type"]; ?></p>
                 <h4    >Price</h4>
                 <p><?php echo $row["price"]; ?>FCFA</p>
                 <?php
                }
            }
            else{
                echo "<h3>No books found</h3>";
            }
            ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>