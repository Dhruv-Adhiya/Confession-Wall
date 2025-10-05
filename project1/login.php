<?php
session_start();

$servername = "localhost";
$username = "root";  
$password = "";     
$dbname = "confession_wall"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_email = trim($_POST['email']);
    $login_password = trim($_POST['password']);

    if (empty($login_email) || empty($login_password)) {
        echo "<script>alert('Please fill all fields'); window.location='login.php';</script>";
        exit();
    }

    $stmt = $conn->prepare("SELECT username,userpassword FROM registeration WHERE email = ?");
    $stmt->bind_param("s", $login_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_username, $hashedPassword);
        $stmt->fetch();

        if (password_verify($login_password, $hashedPassword)) {

            $_SESSION['username'] = $db_username;
            setcookie("user", $db_username, time() + 3600, "/");
            header("Location: view.php");
            exit();
        } else {
            echo "<script>alert('Invalid password'); window.location='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found'); window.location='login.php';</script>";
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
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <header>
        <div class="header">
            <div class="home">
                <a href="index.html" class="logo">
                <i class="fa-solid fa-house"></i>
                Home</a>
            </div>
            <div class="login">
                <a href="login.php" class="logo">
                <i class="fa-solid fa-right-to-bracket"></i>
                Login</a>
            </div>
            <div class="about">
                <a href="about.html" class="logo">
                <i class="fa-solid fa-user"></i>
                About Us</a>
            </div> 
        </div>
    </header>
    <div>
        <h1>Welcome Back</h1>
    </div>
    <div id="form">
        <p id="signin">sign in to your account</p>
        <form id="form1" action="login.php" method="POST">
            <div>
                <input type="text" id="username" name="username" class="input" placeholder="enter username" required>
                <div class="error" id="usernameerror"></div>
            </div>
            <div>
                <input type="email" id="email" name="email" class="input" placeholder="enter your email" required>
                <div class="error" id="emailerror"></div>
            </div>
            <div>
                <input type="password" id="password" name="password" class="input" placeholder="enter your password" required>
                <div class="error" id="passworderror"></div>
            </div>
            <div>
                <a href="forgot-password.html" id="forgot">Forgot password?</a>
            </div>
            <button type="submit" id="button">Sign in</button>
            <br>
            <p id="signup">Don't Have Account?<a href="registeration.php">sign up</a></p>
        </form>
    </div>
    
    <script>
        document.getElementById("form1").addEventListener("submit", function(e) {
            document.getElementById("usernameerror").textContent = "";
            document.getElementById("emailerror").textContent = "";
            document.getElementById("passworderror").textContent = "";

            const username = document.getElementById("username").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;

            let isvalid = true;

            if (username === "") {
                document.getElementById("usernameerror").textContent = "please enter username";
                isvalid = false;
            }

            const emailPattern = /^[^]+@[^]+\.[a-z]{2,3}$/;
            if (!emailPattern.test(email)) {
                document.getElementById("emailerror").textContent = "enter valid email.";
                isvalid = false;
            }

            if (password.length < 6) {
                document.getElementById("passworderror").textContent = "password must be atleast 6 characters.";
                isvalid = false;
            }

            if (!isvalid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
