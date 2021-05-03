<?php

require_once("../private/initialize.php"); 

$user_id = $_SESSION["admin_id"];

$bookshelf = Bookshelf::get_books($user_id);

$bookshelf_items = $bookshelf[0];

$i = 0;

foreach($bookshelf as $bookshelf_item) {
  echo("<p class=\"hidden\" id=\"isbn". $i . "\">" . $bookshelf_item->bookshelf_item_isbn . "</p>");
  $i++;
}
