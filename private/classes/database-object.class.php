<?php

class DatabaseObject {

  static protected $database;
  static protected $table_name = "user";
  static protected $columns = [];
  public $errors = [];

  /**
   * Sets the name of the database to be used for site functions
   *
   * @param {string} $database - the name of the database to be used by the site
   *
   */
  static public function set_database($database) {
    self::$database = $database;
  }

  /**
   * Executes a provided sql statement against the site database, then returns any results in an array of objects
   *
   * @param {string} $sql - the sql statment to be executed on the database
   *
   */
  static public function find_by_sql($sql) {
    $result = self::$database->query($sql);
    if(!$result) {
      return false;
    }

    // Turn results into objects
    $object_array = [];
    while ($record = $result->fetch(PDO::FETCH_ASSOC)) {
        $object_array[] = static::instantiate($record);
      }
    return $object_array;
  }

  /**
   * Executes an sql statment on the site database table associated with the class the function is called from, looking for any records where 
   * values from the table's primary key matches the provided id number
   *
   * @param {int} $id - the id number to be searched for
   *
   */
  static public function find_by_id($id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE " . static::$id_name . "=" . self::$database->quote($id);
    $object_array = static::find_by_sql($sql);
    if(!empty($object_array)) {
        return array_shift($object_array);
    }   else    {
        return false;
    }
  }

  /**
   * Executes an sql statment on the database table associated with the class the function is called from, retrieves all records from the associated table
   *
   */
  static public function find_all() {
    $sql = "SELECT * FROM " . static::$table_name;
    return static::find_by_sql($sql);
  }

  /**
   * Converts a supplied array into a new instance of the class the function is called in
   *
   * @param {array} $record - the record to be converted into a new class instance
   *
   */
  static public function instantiate($record) {
    $object = new static;
    foreach($record as $property => $value) {
        if(property_exists($object, $property)) {
            $object->$property = $value;
        }
    }
    return $object;
  }

  /**
   * Inserts a new record into the database table associated with the class the function is called in, running any
   * specified validation rules in the process.
   *
   */
  public function create() {
    $this->validate();
    if(!empty($this->errors)) { return false; }
    
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . static::$table_name . " (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES (";
    $sql .= join(", ", array_values($attributes));
    $sql .= ");";

    $stmt = self::$database->prepare($sql);
    $result = $stmt->execute();

    if( $result ) {
        $this->user_id = self::$database->lastInsertID();
    } else  echo "Insert query did not run:" . $sql;
    
    return $result;    
  }

  /**
   * Updates an existing record in the database table associated with the class the function is called in, running any
   * specified validation rules in the process.
   *
   */
  protected function update() {
    $this->validate();
    if(!empty($this->errors)) { return false; }

    $attributes = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}={$value}";
    }

    $id = static::$id_name;

    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(", ", $attribute_pairs);
    $sql .= " WHERE " . static::$id_name . "=" . self::$database->quote($this->$id) . " ";
    $sql .= "LIMIT 1";

    $stmt = self::$database->prepare($sql);
    $result = $stmt->execute();
    return $result;
  }

  /**
   * Checks to see if a record about to be put into the database should be a brand new record or should update an existing record, then passes
   * the record off to the correct function
   *
   */
  public function save() {
    // A new record will not have an ID yet
    $id = static::$id_name;
    if(isset($this->$id)) {
        return $this->update();
    } else {
        return $this->create();
    }
  }

  /**
   * Takes a supplied array and binds any values that have indexes matching the columns in the class the function is called in
   *
   * @param {array} $args=[] - the array to be binded to the calling class
   *
   */
  public function merge_attributes($args=[]) {
    foreach($args as $key => $value) {
        if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
        }
    }
  }

  /**
   * Gets the attributes associated with the current instance of the class the function is called in, exculding the ID
   *
   */
  public function attributes() {
    $attributes = [];
    foreach(static::$db_columns as $column) {
        if( $column == static::$id_name ) { continue; }
        $attributes[$column] = $this->$column;
    }
    return $attributes;
  }

  /**
   * Gets the attributes associated with the current instance of the class the function is called in, quoting them to prevent sql injection
   *
   */
  protected function sanitized_attributes() {
    $sanitized = [];
    foreach($this->attributes() as $key => $value) {
        $sanitized[$key] = self::$database->quote($value);
    }
    return $sanitized;
  }

  /**
   * Deletes the record matching the id of the current instance of the class the function is called in
   *
   */
  public function delete() {    
    $id = static::$id_name;
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE " . static::$id_name . "=" . self::$database->quote($this->$id) . " ";
    $sql .= "LIMIT 1";
    $stmt = self::$database->prepare($sql);
    $result = $stmt->execute();
    return $result;

    // After deleting, the instance of the object will still 
    // exist even though the database record does not. 
    // This can be useful as in:
    //  echo $user->first_name . " was deleted.";
    // but, for example, we can't call $user->update() after
    // calling $user->delete().
  }

  /**
   * Deletes the record matching the id of the current instance of the class the function is called in
   *
   */
  protected function validate() {
    $this->errors = [];

    // Add custom validations

    return $this->errors;
  }

}