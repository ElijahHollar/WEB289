<?php

  class Bookshelf extends DatabaseObject {

    static protected $table_name = 'bookshelf_item';
    static protected $id_name = 'bookshelf_item_id';
    static protected $db_columns = ['bookshelf_item_id', 'user_id', 'bookshelf_item_isbn'];

    public $bookshelf_item_id;
    public $user_id;
    public $bookshelf_item_isbn;

    public function __construct($args=[]) {
      $this->user_id = $args['user_id'] ?? '';
      $this->bookshelf_item_isbn = $args['bookshelf_item_isbn'] ?? '';
    }

    static public function get_books($user_id) {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE user_id=" . $user_id;
      $object_array = static::find_by_sql($sql);
      if(!empty($object_array)) {
        return $object_array;
      } else {
        return false;
      }
    }

    static public function get_book_by_isbn($isbn) {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE bookshelf_item_isbn=" . self::$database->quote($isbn);
      $object_array = static::find_by_sql($sql);
      if(!empty($object_array)) {
          return array_shift($object_array);
      }   else    {
          return false;
      }
    }


    // static public function get_book_by_isbn($isbn) {
    //   $sql = "SELECT * FROM " . static::$table_name . " ";
    //   $sql .= "WHERE bookshelf_item_isbn=" . $isbn;
    //   $object_array = static::find_by_sql($sql);
    //   if(!empty($object_array)) {
    //     return $object_array;
    //   } else {
    //     return false;
    //   }
    // }    

    protected function validate() {
      $this->errors = [];
    
      if(!already_in_bookshelf($this->bookshelf_item_isbn, $this->bookshelf_item_id)) {
        $this->errors['bookshelf'] = "You have already added this book to your bookshelf.";
        echo "<script>console.log('bookshelf error!' );</script>";
      }
  
      return $this->errors;
    }
  }