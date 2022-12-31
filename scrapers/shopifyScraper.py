import json

import requests

ORIGINPATH = "https://kbdfans.com/collections/"
SUBPATHS = ["keycaps", "diy-kit", "switches"]

# Returns product array. Products have indices "variants", "id", "title", "image"
def get_products(path, subpaths):
    res = []
    pageNum = 1
    for i in subpaths:
        r = requests.get(path + str(i) + "/products.json?limit=250&page=" + str(pageNum))
        pageNum += 1
        data = json.loads(r.text)
        if len(data["products"]) == 0:
            pageNum = 1
            return res
        for j in data["products"]:
            tmp = read_product_and_variants(j)
            if tmp["variants"] != []:
                res.append(tmp)

# Reads products from products.json
def read_product_and_variants(product):
    total = {}
    total["title"] = product["title"]
    total["id"] = product["id"]
    total["image"] = product["images"][0]["src"]
    if total["image"] is None:
        total["image"] = ""
    total["variants"] = []
    for variant in product["variants"]:
        if variant["available"]:
            res = {}
            res["title"] = variant["title"]
            res["id"] = variant["id"]
            res["price"] = variant["price"]
            if(variant["featured_image"] is not None):
                res["image"] = variant["featured_image"]["src"]
            else:
                res["image"] = ""
            total["variants"].append(res)
    return total
