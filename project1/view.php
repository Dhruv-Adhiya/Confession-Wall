<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view confession</title>
    <link rel="stylesheet" href="view.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header">
            
            <div class="home">
                <a href="view.php" class="logo">
                <i class="fa-solid fa-house"></i>
                Home</a>
            </div>
            <div class="profile">
                <a href="profile.php" class="logo">
                <i class="fa-solid fa-circle-user"></i>
                Profile</a>
            </div>
            <div class="confession">
                <a href="confession.php" class="logo">
                <i class="fa-solid fa-comment"></i>
                confession</a>
                </div>
            <div class="about">
                <a href="about.html" class="logo">
                <i class="fa-solid fa-user"></i>
                About Us</a>
            </div>
            <div class="logout">
                <a href="logout.php" class="logo">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout</a>
            </div> 
        </div>
    </header>

    <div>
        <div style="text-align: center; margin-bottom: 20px;">
            <input type="text" id="search" placeholder="Search confessions...">
            <i class="fa-solid fa-magnifying-glass" id="searchicon"></i>
        </div>

        <div class="confession-container">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "confession_wall";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $result = $conn->query("SELECT * FROM confession ORDER BY created_at DESC");
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="confessiondisplay">';
                    echo '<p>' . htmlspecialchars($row['confession_text']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p style="text-align: center; color: #666; font-size: 18px; margin-top: 50px;">No confessions yet. Be the first to share!</p>';
            }
            
            $conn->close();
            ?>
        </div>
        
    </div>
</body>
</html>