<?php
require_once "db.php";
require_once "functions.php";

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    if (!validate_username($username)) {
        $message = "Invalid username (3-20 chars, letters/numbers/underscores)";
    } elseif (!validate_email($email)) {
        $message = "Invalid email";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters";
    } elseif (!verify_captcha($captcha)) {
        $message = "CAPTCHA incorrect";
    } else {
        $hashed_password = hash_password($password);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$username, $email, $hashed_password]);
            $message = "Registration successful! <a href='index.php'>Login here</a>";
        } catch (PDOException $e) {
            $message = ($e->errorInfo[1] == 1062) ? "Username or email exists" : "Error: ".$e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Register</h2>
<form method="post">
    Username: <input type="text" name="username" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    CAPTCHA: <?php echo generate_captcha(); ?><br>
    Answer: <input type="text" name="captcha" required><br><br>
    <button type="submit">Register</button>
</form>
<p class="error"><?php echo $message; ?></p>
<p>Already have an account? <a href="index.php">Login</a></p>
</body>
</html>
