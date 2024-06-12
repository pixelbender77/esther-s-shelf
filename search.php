<?php
include('database.php');

// Getting the search query
$q = isset($_GET['q']) ? $_GET['q'] : '';

// Creating the SQL query
$sqlSelect = "SELECT * FROM books WHERE title LIKE '%$q%' OR author LIKE '%$q%' OR type LIKE '%$q%'";
$result = mysqli_query($mysqli, $sqlSelect);

// Outputing the filtered results
if (mysqli_num_rows($result) > 0) {
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
                    <h2>{$data['title']}</h2>
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
} else {
    // Displaying no results message
    echo "<p class='not-found'>No search results for '$q'</p>";
}
?>
