<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confession_text']) && !empty($_POST['confession_text'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "confession_wall";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $user = $_SESSION['username'];
    $confession = $_POST['confession_text'];
    
    $stmt = $conn->prepare("INSERT INTO confession (username, confession_text, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $user, $confession);
    
    if ($stmt->execute()) {
        header("Location: view.php");
        exit();
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>confession</title>
    <link rel="stylesheet" href="confession.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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
        <div>
            <h1>Add Your confession With Love &hearts;</h1>
        </div>
        <form method="POST">
            <div>
                <textarea name="confession_text" placeholder="Add your Confession..." id="confession" required></textarea>
            </div>
            <div>
                <button type="submit" id="button">Submit</button>
            </div>
        </form>
    </div>

</body>
</html>