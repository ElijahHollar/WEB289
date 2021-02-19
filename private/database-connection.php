<?php

define("DB_SERVER", "localhost");
define("DB_USER", "uf95wsmutqpaw");
define("DB_PASS", "z*3mc@-1#se&95");
define("DB_NAME", "dbrvy4tqsit434");

function db_connect() {
  try {
    $connection = new PDO('mysql:host='.DB_SERVER.'; dbname='.DB_NAME, DB_USER, DB_PASS);
    return $connection;
  }

  catch(Exception $e) {
    echo $e->getMessage();
  }

  function db_disconnect($connection) {
    if(isset($connection)) {
      $connection->close();
    }
  }
}

$database = db_connect();
