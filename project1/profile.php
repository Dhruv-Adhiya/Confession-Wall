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
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
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
            <div class="favorite">
                <a href="favourite.html" class="logo">
                <i class="fa-solid fa-heart"></i>
                favorites</a>
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
        <div id="profileinfo">
            <span>
                <img src="profilepic.png" alt="profilepic" id="profilepic">
            </span>
            <span>
                <h4 id="name"><?php echo htmlspecialchars($_SESSION['username']); ?></h4>
            </span>
            <span>
                <p id="info"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <p id="info">Join Date: <?php echo date('d/m/Y'); ?></p>
            </span>
            <span>
                <button id="editprofile">Edit Profile</button>
            </span>  
        </div>
        <div>
            <div>
                <h4 id="yourconfession">Your confessions&hearts;</h4>
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
                
                $user = $_SESSION['username'];
                $stmt = $conn->prepare("SELECT * FROM confession WHERE username = ? ORDER BY created_at DESC");
                $stmt->bind_param("s", $user);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="confessiondisplay">';
                        echo '<p>' . htmlspecialchars($row['confession_text']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p style="text-align: center; color: #666; font-size: 18px; margin-top: 50px; width: 100%;">You haven\'t posted any confessions yet.</p>';
                }
                
                $stmt->close();
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>