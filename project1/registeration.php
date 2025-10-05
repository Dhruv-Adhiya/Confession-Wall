<?php

$input_username = $input_email = $input_name = "";
$usernameErr = $emailErr = $nameErr = $passwordErr = $password1Err = "";
$successMsg = "";
$isValid = false;
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input_username = trim($_POST['username']);
    $input_email = trim($_POST['email']);
    $input_name = trim($_POST['name']);
    $input_password = $_POST['password'];
    $input_password1 = $_POST['password1'];

    $isValid = true;


    $servername = "localhost";  
    $db_username = "root";         
    $db_password = "";             
    $dbname = "confession_wall";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $check_stmt = $conn->prepare("SELECT username FROM registeration WHERE username = ? OR email = ?");
    $check_stmt->bind_param("ss", $input_username, $input_email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $usernameErr = "Username or email already exists";
        $isValid = false;
    }
    $check_stmt->close();

    if (empty($input_username)) {
        $usernameErr = "Please enter username";
        $isValid = false;
    }

    if (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Enter valid email.";
        $isValid = false;
    }

    if (empty($input_name)) {
        $nameErr = "Please enter your name"; 
        $isValid = false;
    }

    if (strlen($input_password) < 6) {
        $passwordErr = "Password must be at least 6 characters.";
        $isValid = false;
    }

    if ($input_password !== $input_password1) {
        $password1Err = "Passwords do not match.";
        $isValid = false;
    }

    if ($isValid) {
        $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO registeration (username, email, pname, userpassword) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $input_username, $input_email, $input_name, $hashed_password);

        if ($stmt->execute()) {
            $successMsg = "Registration successful! You can now login.";
            // Clear form data after successful registration
            $input_username = $input_email = $input_name = "";
        } else {
            $usernameErr = "Registration failed. Please try again.";
        }

        $stmt->close();
    }
    
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Page</title>
    <link rel="stylesheet" href="reg.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" >
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" >
</head>
<body>
    <header>
        <div class="header">
            <div class="home">
                <a href="index.html" class="logo">
                    <i class="fa-solid fa-house"></i>
                    Home
                </a>
            </div>
            <div class="login">
                <a href="login.php" class="logo">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Login
                </a>
            </div>
            <div class="about">
                <a href="about.html" class="logo">
                    <i class="fa-solid fa-user"></i>
                    About Us
                </a>
            </div>
        </div>
    </header>
    <div id="form1">
        <h1>Create Account</h1>
        <?php if ($successMsg) : ?>
            <p style="color: green; font-weight: bold;"><?= htmlspecialchars($successMsg) ?></p>
        <?php endif; ?>
        <form id="registerationform" method="post" action="">
            <div>
                <input type="text" id="username" name="username" class="input1" placeholder="enter username" value="<?= htmlspecialchars($input_username) ?>" required />
                <div class="error" id="usernameerror" style="color: red;"><?= $usernameErr ?></div>
            </div>
            <div>
                <input type="email" id="email" name="email" class="input1" placeholder="enter your email" value="<?= htmlspecialchars($input_email) ?>" required />
                <div class="error" id="emailerror" style="color: red;"><?= $emailErr ?></div>
            </div>
            <div>
                <input type="text" id="name" name="name" class="input1" placeholder="enter your name" value="<?= htmlspecialchars($input_name) ?>" required />
                <div class="error" id="nameerror" style="color: red;"><?= $nameErr ?></div>
            </div>
            <div>
                <input type="password" id="password" name="password" class="input1" placeholder="create a password" required />
                <div class="error" id="passworderror" style="color: red;"><?= $passwordErr ?></div>
            </div>
            <div>
                <input type="password" id="password1" name="password1" class="input1" placeholder="confirm your password" required />
                <div class="error" id="password1error" style="color: red;"><?= $password1Err ?></div>
            </div>
            <button type="submit" id="button" name="submit">Create Account</button>
            <p id="signin">Already Have An account? <a href="login.php">sign in</a></p>
        </form>
    </div>
</body>
</html>
