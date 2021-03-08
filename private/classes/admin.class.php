<?php

 class Admin extends DatabaseObject {
    
    static protected $table_name = 'user';
    static protected $db_columns = ['user_id', 'user_email_address', 'user_username', 'user_password', 'user_level'];

    public $user_id;
    public $user_email_address;
    public $user_username;
    public $user_level;
    protected $user_password;
    public $password;
    public $confirm_password;
    protected $password_required = true;

    public function __construct($args=[]) {
        $this->user_email_address = $args['user_email_address'] ?? '';
        $this->user_username = $args['user_username'] ?? '';
        $this->user_level = $args['user_level'] ?? 'm';
        $this->password = $args['password'] ?? '';
        $this->confirm_password = $args['confirm_password'] ?? '';
    }

    protected function set_hashed_password() {
        $this->user_password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function verify_password($password) {
      return password_verify($password, $this->user_password);
    }

    public function create() {
        $this->set_hashed_password();
        return parent::create();
    }

    public function update() {
        if($this->password != '') {
            $this->set_hashed_password();
            // Validate password
        } else {
            // password not being updated, skip hashing and validation
            $this->password_required = false;
        }
        return parent::update();
    }

    protected function validate() {
        $this->errors = [];
      
        if(is_blank($this->user_email_address)) {
          $this->errors[] = "Email cannot be blank.";
        } elseif (!has_length($this->user_email_address, array('max' => 255))) {
          $this->errors[] = "Last name must be less than 255 characters.";
        } elseif (!has_valid_email_format($this->user_email_address)) {
          $this->errors[] = "Email must be a valid format.";
        }
      
        if(is_blank($this->user_username)) {
          $this->errors[] = "Username cannot be blank.";
        } elseif (!has_length($this->user_username, array('min' => 8, 'max' => 255))) {
          $this->errors[] = "Username must be between 8 and 255 characters.";
        } elseif (!has_unique_username($this->user_username, $this->user_id ?? 0)) {
          $this->errors[] = "Username not allowed. Try another.";
        }

        if($this->password_required) {
            if(is_blank($this->password)) {
            $this->errors[] = "Password cannot be blank.";
            } elseif (!has_length($this->password, array('min' => 12))) {
            $this->errors[] = "Password must contain 12 or more characters";
            } elseif (!preg_match('/[A-Z]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 uppercase letter";
            } elseif (!preg_match('/[a-z]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 lowercase letter";
            } elseif (!preg_match('/[0-9]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 number";
            } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 symbol";
            }
        
            if(is_blank($this->confirm_password)) {
            $this->errors[] = "Confirm password cannot be blank.";
            } elseif ($this->password !== $this->confirm_password) {
            $this->errors[] = "Password and confirm password must match.";
            }
        }
      
        return $this->errors;
    }
    
    static public function find_by_username($user_username) {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE user_username=" . self::$database->quote($user_username);
      $object_array = static::find_by_sql($sql);
      if(!empty($object_array)) {
          return array_shift($object_array);
      }   else    {
          return false;
      }
    }
 }
