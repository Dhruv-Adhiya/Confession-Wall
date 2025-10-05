<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "confession_wall";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch stats
// Total users
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM registeration")->fetch_assoc()['count'];

// Active users (assuming all are active, or add logic for recent logins)
$activeUsers = $totalUsers; // For now, same as total

// Confessions today
$todayConfessions = $conn->query("SELECT COUNT(*) as count FROM confession WHERE DATE(created_at) = CURDATE()")->fetch_assoc()['count'];

// Confessions this week
$weeklyConfessions = $conn->query("SELECT COUNT(*) as count FROM confession WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)")->fetch_assoc()['count'];

// Total confessions
$totalConfessions = $conn->query("SELECT COUNT(*) as count FROM confession")->fetch_assoc()['count'];

// Fetch users
$usersResult = $conn->query("SELECT username, email, pname FROM registeration");

// Fetch confessions
$confessionsResult = $conn->query("SELECT id, username, confession_text, created_at FROM confession ORDER BY created_at DESC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <div class="dashboard">
        <h1>Admin Dashboard</h1>
        
        <div class="stats">
            <div class="stat-card">
                <h3><?php echo $activeUsers; ?></h3>
                <p>Active Users</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $totalUsers; ?></h3>
                <p>Total Users</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $todayConfessions; ?></h3>
                <p>Confessions Today</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $weeklyConfessions; ?></h3>
                <p>Confessions Weekly</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $totalConfessions; ?></h3>
                <p>Total Confessions</p>
            </div>
        </div>

        <div class="section">
            <h2>Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $usersResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['pname']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Confessions</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Confession</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($confession = $confessionsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $confession['id']; ?></td>
                            <td><?php echo htmlspecialchars($confession['username']); ?></td>
                            <td class="confession-text"><?php echo htmlspecialchars($confession['confession_text']); ?></td>
                            <td><?php echo $confession['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>