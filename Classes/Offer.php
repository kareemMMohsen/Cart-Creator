<?php
class Offer
{
    private $percentage;
    private $condition;
    public function __construct($percentage, $condition){ 
        // Create products
        if(!$percentage){
            exit("You should specify a percentage for your offer!\n");
        }
        if($condition === null){
            exit("Your offer condition can be empty, but can't be null!\n");
        }
        $this->percentage = $percentage;
        $this->condition = $condition;
    } 

    public function validOffer(&$items){
        $deleted_items = array();
        foreach($this->condition as $condition_item){
            if (($key = array_search($condition_item, $items)) !== false) {
                array_push($deleted_items, $items[$key]);
                unset($items[$key]);
            }else {
                // Rollback
                foreach($deleted_items as $deleted_item){
                    array_push($items, $deleted_item);
                }
                return false;
            }
        }
        return count($this->condition) == count($deleted_items);
    }

    public function getPercentage(){
        return $this->percentage;
    }
}
?>