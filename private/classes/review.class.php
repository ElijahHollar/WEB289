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

    public function __construct($args=[]) {
      $this->review_isbn = $args['review_isbn'] ?? '';
      $this->review_text = $args['review_text'] ?? '';
      $this->review_date = $args['review_date'] ?? '';
    }
  }