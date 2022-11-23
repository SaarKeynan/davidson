<?php

$db_host = "localhost";
$db_user = "server";
$db_password = "A3FRvi]zsAE!02C*";
$db = "davidson";

$conn = new mysqli($db_host, $db_user, $db_password, $db, 3306);
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function prepared_query($mysqli, $query, $params, $types = ""): mysqli_stmt {
    $types = $types ?: str_repeat("s", count($params));
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt;
}