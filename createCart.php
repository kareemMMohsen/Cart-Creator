<?php

include 'Classes/Shop.php';

$currency = "$";
$items = array();
foreach($argv as $arg){
    if(substr($arg, 0, 16) == "--bill-currency="){
        $currency = substr($arg, 16);
    }elseif($arg != "createCart.php"){
        array_push($items, $arg);
    }
}
$json = file_get_contents("./Universe.json");
$universe = json_decode($json, false); 

$shop = new Shop($universe->Shop); 
$shop->createCart($items, $currency);
?>