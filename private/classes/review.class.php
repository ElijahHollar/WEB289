<?php

  class Review extends DatabaseObject {

    static protected $table_name = 'review';
    static protected $id_name = 'review_id';
    static protected $db_columns = ['review_id', 'user_id', 'review_isbn', 'review_text', 'review_date'];

    public $review_id;
    public $user_id;
    public $review_isbn;
    public $review_text;
    public $review_date;

    /**
     * Creates a new instance of the review class using an array of provided values
     *
     * @param {array} $args[] - the array of provided values
     *
     */
    public function __construct($args=[]) {
      $this->user_id = $args['user_id'] ?? '';
      $this->review_isbn = $args['review_isbn'] ?? '';
      $this->review_text = $args['review_text'] ?? '';
      $this->review_date = $args['review_date'] ?? '';
    }

    /**
     * Checks to see if there are any book reviews corresponding to the supplied isbn number and either returns all reviews in an array or returns false
     *
     * @param {string} $book_isbn - the isbn number used to retrieve corresponding reviews
     *
     */
    static public function get_reviews($book_isbn) {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE review_isbn=" . $book_isbn;
      $object_array = static::find_by_sql($sql);
      if(!empty($object_array)) {
        return $object_array;
      } else {
        return false;
      }
    }
  }