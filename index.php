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
    <div class="content">
        <?php
            $res = getCards();
            foreach($res as $card): ?>
                    <a href="./item.php?id=<?php echo $card["id"] ?>">
                        <div class="card">
                            <div class="card-photo">
                                <img src="<?php echo "/images/" . $card["img"] ?>" alt="">
                            </div>
                            <div class="card-title">
                                <?php echo $card["title"] ?>
                            </div>
                            <div class="card-price">
                                <?php echo getPriceRange(getVariants($card["id"])) . "$"?>
                            </div>
                        </div>
                    </a>
            <?php endforeach; ?>
    </div>
</body>
</html>

<?php
    function getCards() { //TODO: Sort/search functionality
        global $conn;
        $result = $conn->query("SELECT * FROM `products` WHERE  1");
        return $result;
    }

    function getVariants($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM `variants` WHERE `parent`=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function getProductData($variants) {

    }

    function getPriceRange($variants) {
        $minPrice = $variants[0]["price"];
        $maxPrice = $variants[0]["price"];
        foreach($variants as $curr) {
            if($curr["price"] > $maxPrice) {
                $maxPrice = $curr["price"];
            } else if($curr["price"] < $minPrice) {
                $minPrice = $curr["price"];
            }
        }
        $priceStr = "";
        if($minPrice === $maxPrice) {
            $priceStr = $maxPrice;
        } else {
            $priceStr = $minPrice . " - " . $maxPrice;
        }
        return $priceStr;
    }
?>