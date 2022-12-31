import mysql.connector as mc
import shopifyScraper

SITES = ["kbdfans"]
PATHS = ["https://kbdfans.com/collections/"]
SUBPATHS = [["keycaps", "diy-kit", "switches"]]


def upload_product(product, db, src):
    cursor = db.cursor()
    cursor.execute("SELECT COUNT(*) FROM `products` WHERE `source` = %s AND `shop_id` = %s", (src, product["id"]))
    res = cursor.fetchone()[0]
    if(res > 0): #If product already exists
        return
    cursor.execute("INSERT INTO `products` (`title`, `source`, `shop_id`, `img`) VALUES (%s, %s, %s, %s)", (product["title"], src, product["id"], product["image"]))
    db.commit()
    parent_id = cursor.lastrowid
    for variant in product["variants"]:
        upload_variant(variant, db, src, parent_id)

def upload_variant(variant, db, src, parent_id):
    cursor = db.cursor()
    cursor.execute(
        "INSERT INTO `variants` (`title`, `price`, `img`, `source`, `parent`) VALUES (%s, %s, %s, %s, %s)",
        (variant["title"], variant["price"], variant["image"], src, parent_id)
    )
    db.commit()


print(shopifyScraper.get_products(PATHS[0], SUBPATHS[0]))

db = mc.connect(
  host="localhost",
  user="server",
  password="A3FRvi]zsAE!02C*",
  database="davidson"
)


for i in range(len(PATHS)):
    products = shopifyScraper.get_products(PATHS[i], SUBPATHS[i])
    for product in products:
        upload_product(product, db, SITES[i])
