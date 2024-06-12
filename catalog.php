<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Catalog</title>
    
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class='top-section'>
            <h1>Catalog</h1>
            <div class="search-container position-relative">
                <input id="search-bar" class="form-control search-bar" type="text" name="q" placeholder="Search..">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
        
        
        <div id="book-list">
            <?php
            include('database.php');
            $sqlSelect = "SELECT * FROM books";
            $result = mysqli_query($mysqli, $sqlSelect);
            while ($data = mysqli_fetch_array($result)) {
                $fileName = $data["cover"];
                $imageUrl = "covers/".$fileName;
                echo "
                <div class='book-card'>
                    <div class='card-image'>
                        <img src='$imageUrl' alt='Book Cover'>
                    </div>
                    <div class='card-content'>
                        <div>
                            <h2 class='card-title'>{$data['title']}</h2>
                            <h3 class='card-desc' title='{$data['description']}'>
                                ".substr($data['description'], 0, 150)."
                                ".(strlen($data['description']) > 150 ? "... <a class='view-more' href='view.php?id={$data['id']}'> (see more)</a>" : "")."
                            </h3>
                        </div>
                        <div class='bottom-line'>
                            <div class='author-price'>
                                <p>By: <span class='author'>{$data['author']}</span></p>
                                <p class='price'>{$data['price']} FCFA</p>
                            </div>
                            <a href='view.php?id={$data['id']}' class='view-link'>View</a>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>   
        </div>
    </div>

    <script>
        document.getElementById('search-bar').addEventListener('input', function() {
            var query = this.value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'search.php?q=' + query, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('book-list').innerHTML = this.responseText;
                }
            };
            xhr.send();
        });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Catalog</title>
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
    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <div>
                <h1>Catalog</h1>
                <input class='search-bar' type="text" name="q" placeholder="Search..">
            </div>
        </header>
        
            <?php
            include('database.php');
            $sqlSelect = "SELECT * FROM books";
            $result = mysqli_query($mysqli, $sqlSelect);
            while ($data = mysqli_fetch_array($result)) {
            ?>
            <div class='book-card'>
                <?php 
                    $fileName = $data["cover"];
                    $imageUrl = "covers/".$fileName;
                    echo "<div class='card-image'>";
                    echo "<img src='$imageUrl'>";
                    echo "</div>";
                ?>
                <div class='card-content'>
                    <div>
                        <h2><?php echo $data['title']; ?></h2>
                        <h3 class='card-desc' title="<?php echo $data['description']; ?>">
                            <?php echo substr($data['description'], 0, 150); ?>
                            <?php if (strlen($data['description']) > 150): ?>
                            ... <a class='view-more' href="view.php?id=<?php echo $data['id']; ?>">(see more)</a>
                            <?php endif; ?>
                        </h3>
                        
                    </div>
                    <div class='bottom-line'>
                        <div class='author-price'>
                            <p >By: <span class='author'><?php echo $data['author']; ?></span></p>
                            <p class='price'><?php echo $data['price']; ?> FCFA</p>
                        </div>
                        <a href="view.php?id=<?php echo $data['id']; ?>" class='view-link'>View</a>
                    </div>
                </div>
            </div>
            <?php } ?>   
        
    </div>
</body>
</html> -->
