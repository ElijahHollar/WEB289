<?php

  class Category extends DatabaseObject {

    static protected $table_name = 'category';
    static protected $id_name = 'category_id';
    static protected $db_columns = ['category_id', 'category_name'];

    public $id;
    public $category_id;
    public $category_name;

    public function __construct($args=[]) {
      $this->category_name = $args['category_name'] ?? '';
    }

  }