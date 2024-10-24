<?php
session_start();

// Check if logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: admin-panel.php");
    exit;
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dummy credentials (in real-world applications, credentials would be retrieved from a database)
    $valid_username = 'admin';
    $valid_password = 'zaq1@WSX';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    if ($username === $valid_username && $password === $valid_password) {
        // Store data in session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['login'] = $username;
        $_SESSION['password'] = $password;

        // Redirect to the protected page
        header("Location: admin-panel.php");
        exit;
    } else {
        // If login fails, show an error
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
