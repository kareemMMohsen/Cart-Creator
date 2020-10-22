# Cart-Creator
## Approach 
The main idea is to create a data-source-agnostic architecture, and then add a parsing layer taylored for the choosen data source to test and verify and then put it in use.
## Universe.json
This an example of the data sources that can feed this achitecture: 
```
{
    "Currency": {
        "$": 1,
        ...
    },
    "Shop": {
        "Inventory": {
            "Products": {
                "ProductZ": {
                    "Price": 10.99,
                    "Currency": "$",
                    "Offer": {
                        "Condition": [
                            "ProductX",
                            "ProductY"
                        ],
                        "Percentage": 0.5
                    }
                },
                ....
            }
        },
        "Tax": 0.14
    }
}
```
This is an example of a very simple yet flixeble schema. For example, the representation of the offer entry can provide an interface for many types of offers aside from the onnes mentioned int the requirements.
### for example: 
A buy 2 get 1 free can be represented like the following:
```
"Offer": {
    "Condition": [
        "T-shirt",
        "T-shirt"
    ],
    "Percentage": 1
}
```
Or say you wanna give products for free: 
```
"Offer": {
    "Condition": [],
    "Percentage": 1
}
```
This can be easily converted to an SQL schema, for example: 
PRODUCTS: ID, Name, Price, Currency, offerId
OFFERS: ID, Percentage
OFFER_CONDITION: offerId, productId
INVENTORY: productId
# Classes
## Offer class
Holds the properties of the offer from the schema above.
### validOffer
Accepts an array of purchased items, and determines id the item associated with this offer is eligible for a discount or not.
## Product class
Holds the properties of the product from the schema above, and an offer object if there's any.
## Inventory class
Holds the objects of the avalable products in the inventory of the current shop.
### calcSubtotal
Accepts an array of items, and returns the subtotal of the items list.
### calcDiscounts
Accepts an array of items, and returns the total anout discount value, and renders the discount for each item seprately.
## Shop class
Holds the inventory object from the schema above.
### createCart 
This method renders the final cart.
# Util functions
## ConvertCurrency
Uses the currency mapper in the input json to convert the value from a currency to another currency.
# How to run
Clone this repo and then use the following command: 
```php createCart.php --bill-currency=<currency> <products list>```
### Currency
Default ```$```
Currently supports ```$```, ```EGP``` and ```EUR```.
To add more currencies, just add them in the Currncies entry in ```universe.json```
### Products list
A lsit of products defined in ```universe.json```
### example ```php createCart.php --bill-currency=$ T-shirt T-shirt Shoes Jacket```
