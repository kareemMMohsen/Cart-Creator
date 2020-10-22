<?php
include 'Product.php';
include '.:/../Utils/ConvertCurrency.php';

class Inventory 
{ 
    private $products = array();
    // Constructor 
    public function __construct($Inventory){ 
        // Create products
        if(!$Inventory->Products){
            exit("Please make sure that the Inventory has products!\n");
        }
        foreach ($Inventory->Products as $product_name => $product_data){
            $this->products[$product_name] = new Product($product_name, $product_data);
        }
    } 

    public function calcSubtotal($items){
        $subtotal = 0;
        foreach ($items as $product_name){
            if(!$this->products[$product_name]){
                exit("The item $product_name in not available in our inventory!\n");
            }
            $price_currency_converted = ConvertCurrency(
                $this->products[$product_name]->getPrice(), 
                $this->products[$product_name]->getCurrency(), 
                "$"
            );
            
            $subtotal = $subtotal + $price_currency_converted;
        }
        return $subtotal;
    }

    public function calcDiscounts($items, $currency){
        $items_copy = $items;
        $discount = 0;
        foreach ($items as $product_name){
            if($this->products[$product_name]->validOffer($items_copy)){
                $percentage = $this->products[$product_name]->getOfferPercentage() * 100;
                $value = $this->products[$product_name]->getOfferValue();
                $value_to_usd = ConvertCurrency(
                    $value, 
                    $this->products[$product_name]->getCurrency(), 
                    "$"
                );
                $discount = $discount + $value_to_usd;
                if($discount == 0){
                    echo "Discounts:\n";
                }
                $value_currency_converted = ConvertCurrency(
                    $value, 
                    $this->products[$product_name]->getCurrency(), 
                    $currency
                );
                echo "\t$percentage% off {$product_name}: -$currency{$value_currency_converted}\n";
            }
        }
        return $discount;
    }
} 
?>