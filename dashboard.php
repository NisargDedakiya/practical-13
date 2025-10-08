<?php
require_once "functions.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
