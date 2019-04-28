<?php
class ShoppingBasket {
  private $items = array();

  function getCount() {
    return count($this->items);
  }

  function getTotalCount() {
    $sum = 0;
    foreach ($this->items as $f => $q) {
      $sum += $q;
    }
    return $sum;
  }

  function getItems() {
    return $this->items;
  }

  function emptyBasket(){
    $this->items = array();
  }

  function isEmpty(){
    return empty($this->items);
  }

  function addItem($i) {
    if (!isset($this->items[$i])){
      $this->items[$i] = 1;
    }
    else {
      $this->items[$i]++;
    }
  }

  function setQuantity($i, $q) {
    $this->items[$i] = $q;
  }

  function getQuantity($i) {
    return $this->items[$i];
  }
}
?>
