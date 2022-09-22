<?php
$db_host = "localhost";
$db_user = "server";
$db_password = "A3FRvi]zsAE!02C*";
$db = "davidson";

if(isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $conn = new mysqli($db_host, $db_user, $db_password, $db, 3306);
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $results = $stmt->get_result();
    if($results->num_rows < 1) {
        echo "No such user";
    }
    else if(password_verify($password, $results->fetch_assoc()["password"])) {
        echo "Success";
    }
    else {
        echo "Wrong password";
    }
}