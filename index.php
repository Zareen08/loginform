<?php
session_start();

// user credentials for authentication
$users = [
    'user@example.com' => 'password123',
];

// Initialize variables
$error = '';
$email = '';
$password = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        // Check if email and password are correct
        if (isset($users[$email]) && $users[$email] === $password) {
            $_SESSION['email'] = $email; // Store email in session

            // Set cookies if "Remember Me" is checked
            if ($remember) {
                setcookie('email', $email, time() + (86400 * 30), '/'); // 30 days
                setcookie('password', $password, time() + (86400 * 30), '/');
            } else {
                // Clear cookies if "Remember Me" is not checked
                setcookie('email', '', time() - 3600, '/');
                setcookie('password', '', time() - 3600, '/');
            }

            header('Location: dashboard.php'); // Redirect to dashboard
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    } elseif (isset($_POST['logout'])) {
        // Handle logout
        session_destroy();
        setcookie('email', '', time() - 3600, '/');
        setcookie('password', '', time() - 3600, '/');
        header('Location: index.php');
        exit;
    }
}

// Autofill email and password if cookies exist
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
    <h2>Login Form</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?= htmlspecialchars($password) ?>" required><br>

        <input type="checkbox" id="remember" name="remember" <?= isset($_COOKIE['email']) ? 'checked' : '' ?>>
        <label for="remember">Remember Me</label><br><br>

        <button type="submit" name="login">Login</button>
    </form>

    <?php if (isset($_SESSION['email'])): ?>
        <form method="POST" action="">
            <button type="submit" name="logout">Logout</button>
        </form>
    <?php endif; ?>
</body>
</html>

