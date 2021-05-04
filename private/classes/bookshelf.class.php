<?php

  class Bookshelf extends DatabaseObject {

    static protected $table_name = 'bookshelf_item';
    static protected $id_name = 'bookshelf_item_id';
    static protected $db_columns = ['bookshelf_item_id', 'user_id', 'bookshelf_item_isbn'];

    public $bookshelf_item_id;
    public $user_id;
    public $bookshelf_item_isbn;

    /**
     * Creates a new instance of the bookshelf class using an array of provided values
     *
     * @param {array} $args[] - the array of provided values
     *
     */
    public function __construct($args=[]) {
      $this->user_id = $args['user_id'] ?? '';
      $this->bookshelf_item_isbn = $args['bookshelf_item_isbn'] ?? '';
    }

    /**
     * Attempts to retrieve all of the bookshelf item records associated with the provided user id from the database
     *
     * @param {int} $user_id - the user id number who's corresponding book records are retrieved
     *
     */
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

    /**
     * Attempts to retrieve a bookshelf item record associated with the provided isbn and user id from the database 
     *
     * @param {string} $isbn - the isbn number who's corresponding book is retrieved
     * @param {int} $user_id - the user id number who's corresponding book is retrieved
     *
     */
    static public function get_book_by_isbn_and_user($isbn, $user_id) {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE bookshelf_item_isbn=" . self::$database->quote($isbn);
      $sql .= "AND user_id=" . self::$database->quote($user_id);
      $object_array = static::find_by_sql($sql);
      if(!empty($object_array)) {
          return array_shift($object_array);
      }   else    {
          return false;
      }
    }

    /**
     * Checks to see if the book the user is attempting to add to their bookshelf is already in their bookshelf, and throws an error if it is
     *
     */
    protected function validate() {
      $this->errors = [];
    
      if(!already_in_bookshelf($this->bookshelf_item_isbn, $this->user_id)) {
        $this->errors['bookshelf'] = "You have already added this book to your bookshelf.";
        echo "<script>console.log('bookshelf error!' );</script>";
      }
  
      return $this->errors;
    }
  }