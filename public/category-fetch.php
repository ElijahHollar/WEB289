<?php

require_once("../private/initialize.php"); 

$category = Category::find_all();

$cateogries = $category[0];

if(isset($category[0])) {
  
  $i = 0;
  $names=[];

  foreach($category as $category_item) {

    $names[$i] = $category_item->category_name;

    $i++;
  }
  
  $results = count($category) - 1;
  
  $numbers = range(0, $results);
  shuffle($numbers);
  
  $returned = 0;

  $i = 0;

  foreach($numbers as $number) {
    if($returned < 3) {
      echo("<p class=\"hidden\" id=\"category". $i . "\">" . $names[$number] . "</p>");

      $i++;
      $returned++;
    }
  }  
}
