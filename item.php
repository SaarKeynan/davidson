<!DOCTYPE html>
<html lang="en">
<?php
include "./header.shtml";
require_once "db.php";
?>
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php
    if(!isset($_GET["id"])) {
        echo "Invalid Item!";
        return;
    }
    $details = getDetails($_GET["id"]);
    if($details === []) {
        echo "No such item.";
        return;
    }
?>
    <div>

    </div>
</body>
</html>

<?php

/**
 * @var mysqli $conn
 */
function getDetails($id) {
    global $conn;
    $stmt = prepared_query("SELECT * FROM `variants` WHERE `parent`=?", array($id), "i");
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

