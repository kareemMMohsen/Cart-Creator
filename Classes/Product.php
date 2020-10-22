<?php
include 'Offer.php';

class Product
{
    private $price;
    private $currency;
    private $offer;
    private $name;
    // Constructor 
    public function __construct($product_name, $product_data){ 
        // Create products
        $this->name = $product_name;
        if(!$product_data->Price){
            exit("Price for $product_name can't be empty or null or zero!\n");
        }
        if(!$product_data->Currency){
            exit("Currency for $product_name can't be empty or null or zero!\n");
        }
        $this->price = $product_data->Price;
        $this->currency = $product_data->Currency;
        if($product_data->Offer != null){
            $this->offer = new Offer($product_data->Offer->Percentage, $product_data->Offer->Condition);
        }else{
            $this->offer = null;
        }
        
    } 
    public function getPrice(){
        return $this->price;
    }
    public function getCurrency(){
        return $this->currency;
    }

    public function validOffer(&$items){
        if($this->offer != null){
            return $this->offer->validOffer($items);
        }else {
            return false;
        }
        
    }

    public function getOfferPercentage(){
        return $this->offer->getPercentage();
    }

    public function getOfferValue(){
        return $this->price * $this->getOfferPercentage();
    }

}
?>