####how to use api

the baseurl = https://wemall.sanctablog.com/api/
#To get list of all  the product
list/<what-list-is-based-on>/<list-filter>

-- list/category/all
    this will return all product
-- list/category/footwear
    this will return all product with catergory of footwear
-- list/gender/all
    get all product
-- list/gender/male
    get all male product

#to get details of a specific item
product/<what-you-want-to-get>/<product-id>

-- product/details/<product-id>
    this will get all detail the product with the tallying product-id
-- product/price/<product-id>
    this will return the price of the product with the tallying product-id
-- product/gender/<product-id>
    this will return the gender of the product with the tallying product-id


before you can make order with this api you need to signup the user that which to make the purchase

