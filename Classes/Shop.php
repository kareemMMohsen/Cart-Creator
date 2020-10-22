<?php
include 'Inventory.php';

class Shop
{
    private $inventory;
    private $tax;
    public function __construct($shop){ 
        if(!$shop->Inventory){
            exit("Can't create a shop without its inventory\n");
        }
        $this->inventory = new Inventory($shop->Inventory); 
        if(!$shop->Tax){
            exit("Tax cannot be zero or empty, enter tax in your shop!\n");
        }
        $this->tax = $shop->Tax; 
    }
    public function createCart($items, $currency){
        $sub_total = $this->inventory->calcSubtotal($items);
        $sub_total_currency_converted = ConvertCurrency(
            $sub_total, 
            "$", 
            $currency
        );

        echo "Subtotal: $currency$sub_total_currency_converted\n";
        $taxes = $sub_total * $this->tax;
        $taxes_currency_converted = ConvertCurrency(
            $taxes, 
            "$", 
            $currency
        );
        echo "Taxes: $currency$taxes_currency_converted\n";
        $discounts = $this->inventory->calcDiscounts($items, $currency);
        $total = $sub_total + $taxes - $discounts;
        $total_currency_converted = ConvertCurrency(
            $total, 
            "$", 
            $currency
        );

        echo "Total: $currency$total_currency_converted\n";
    }
}
?>