<!DOCTYPE html>
<html lang="en">
<?php include "./header.shtml" ?>
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <div class="content">
        <?php
            $res = getCards();
            foreach($res as $card) { ?>
                <div class="card">
                    <div class="card-photo">
                        <img src="<?php echo "/images/" . $card["img"] ?>" alt="">
                    </div>
                    <div class="card-title">
                        <?php echo $card["title"] ?>
                    </div>
                    <div class="card-price">
                        10000000$
                    </div>
                </div>
            <?php }
        ?>
    </div>
</body>
</html>

<?php
    /**
     * @var mysqli $conn
     */

    function getCards() { //TODO: Sort/search functionality :)
        require_once 'db.php';
        $result = $conn->query("SELECT * FROM `products` WHERE  1");
        return $result;
    }
?>