<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .profile {
            text-align: center;
            margin-top: 30px;
        }
        .profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .profile h3 {
            margin-bottom: 10px;
        }
        .profile h4 {
            color: gray;
        }
        .btn-back {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary btn-back"><i class="fas fa-arrow-left"></i> Back</a>
    
    <?php
    include_once("database.php");
    
    // Retrieve the user ID from the URL
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id) {
        $query = "SELECT * FROM user WHERE id=$id";
        $result = mysqli_query($mysqli, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            $name = htmlspecialchars($row["name"]);
            $email = htmlspecialchars($row["email"]);
            ?>
            <a class="btn btn-info mb-4" href="edit-profile.php?id=<?php echo $id; ?>" style="background-color:var(--ACCENT); border:none;"><i class="fas fa-edit"></i> Edit Profile</a>
            <div class="profile">
                <img src="assets/profile.png" alt="Profile Image">
                <h3><?php echo $name; ?></h3>
                <h4><?php echo $email; ?></h4>
                <p><a href="logout.php">Log out</a></p>
            
            </div>
            
            <?php
        } else {
            echo "<p class='text-danger'>User not found.</p>";
        }
    } else {
        echo "<p class='text-danger'>Invalid user ID.</p>";
    }
    ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
