<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['email']) ?>!</h2>
    <form method="POST" action="index.php">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>
