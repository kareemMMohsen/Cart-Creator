<?php
$json = file_get_contents("./Universe.json");
$universe = json_decode($json, false); 

$currency_map = get_object_vars($universe->Currency);
function ConvertCurrency($val, $currency_from, $currency_to) {
    global $currency_map;
    if($currency_map[$currency_from] == null){
        exit("The $currency_from currency is not supported  ¯\_(ツ)_/¯\n");
    }
    if($currency_map[$currency_to] == null){
        exit("The $currency_to currency is not supported  ¯\_(ツ)_/¯\n");
    }
    return ($val / $currency_map[$currency_from]) * $currency_map[$currency_to];
}
?>