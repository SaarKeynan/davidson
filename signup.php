<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="style.css">
<?php include "./header.shtml" ?>
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
Sign Up
<form action="/signup.php" method="post" id="signup" class="forms">
    <input type="text" name="username" minlength="3" placeholder="Username">
    <input type="password" minlength="5" name="password">
    <input type="submit" value="Submit">
    <div id="signupres"></div>
</form>
</body>
</html>

<?php

$db_host = "localhost";
$db_user = "server";
$db_password = "A3FRvi]zsAE!02C*";
$db = "davidson";

if(isset($_POST["username"]) && isset($_POST["password"])) {
    if(strlen($_POST["username"]) < 3) {
        echo "Username too short";
        exit();
    }
    if(strlen($_POST["username"]) > 24) {
        echo "Username too long";
        exit();
    }
    if(strlen($_POST["password"]) < 5) {
        echo "Password too short";
        exit();
    }
    $username = $_POST["username"];
    $password = $_POST["password"];
    $conn = new mysqli($db_host, $db_user, $db_password, $db, 3306);
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $results = $stmt->get_result();
    if($results->fetch_row()[0] != 0) {
        echo "Username already exists";
    } else {
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashedPass);
        $stmt->execute();
        echo "Successfully created account";
    }
}