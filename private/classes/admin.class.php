<?php

 class Admin extends DatabaseObject {
    
    static protected $table_name = 'user';
    static protected $id_name = 'user_id';
    static protected $db_columns = ['user_id', 'user_email_address', 'user_username', 'user_password', 'user_level'];

    public $user_id;
    public $user_email_address;
    public $user_username;
    public $user_level;
    protected $user_password;
    public $password;
    public $confirm_password;
    protected $password_required = true;

    /**
     * Creates a new instance of the admin class using an array of provided values
     *
     * @param {array} $args[] - the array of provided values
     *
     */
    public function __construct($args=[]) {
        $this->user_email_address = $args['user_email_address'] ?? '';
        $this->user_username = $args['user_username'] ?? '';
        $this->user_level = $args['user_level'] ?? 'm';
        $this->password = $args['password'] ?? '';
        $this->confirm_password = $args['confirm_password'] ?? '';
    }

    /**
     * Encrypts the current user's password and stores it in the current class instance
     *
     */
    protected function set_hashed_password() {
        $this->user_password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    
    /**
     * Checks to see if the supplied password matches the password stored in the current instance of the class
     *
     */
    public function verify_password($password) {
      return password_verify($password, $this->user_password);
    }

    /**
     * Uses the set_hashed_password() function to encrypt the current user's password before running the normal create() function
     *
     */
    public function create() {
        $this->set_hashed_password();
        return parent::create();
    }

    /**
     * Checks to see if the current user's password is being updated, encrypting the new one if it is, before calling the normal update() function
     *
     */
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

    /**
     * Checks to see if the user is entering a valid email address, valid username, valid password, and has correctly confirmed their password
     *
     */
    protected function validate() {
        $this->errors = [];
      
        if(is_blank($this->user_email_address)) {
          $this->errors['email'] = "Email cannot be blank.";
        } elseif (!has_length($this->user_email_address, array('max' => 255))) {
          $this->errors['email'] = "Email address must be less than 255 characters.";
        } elseif (!has_valid_email_format($this->user_email_address)) {
          $this->errors['email'] = "Email must be a valid format.";
        }
      
        if(is_blank($this->user_username)) {
          $this->errors['username'] = "Username cannot be blank.";
        } elseif (!has_length($this->user_username, array('min' => 8, 'max' => 255))) {
          $this->errors['username'] = "Username must be between 8 and 255 characters.";
        } elseif (!has_unique_username($this->user_username, $this->user_id ?? 0)) {
          $this->errors['username'] = "Username not allowed. Try another.";
        }

        if($this->password_required) {
            if(is_blank($this->password)) {
            $this->errors['password'] = "Password cannot be blank.";
            } elseif (!has_length($this->password, array('min' => 12))) {
            $this->errors['password'] = "Password must contain 12 or more characters";
            } elseif (!preg_match('/[A-Z]/', $this->password)) {
            $this->errors['password'] = "Password must contain at least 1 uppercase letter";
            } elseif (!preg_match('/[a-z]/', $this->password)) {
            $this->errors['password'] = "Password must contain at least 1 lowercase letter";
            } elseif (!preg_match('/[0-9]/', $this->password)) {
            $this->errors['password'] = "Password must contain at least 1 number";
            } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
            $this->errors['password'] = "Password must contain at least 1 symbol";
            }
        
            if(is_blank($this->confirm_password)) {
            $this->errors['confirm_password'] = "Confirm password cannot be blank.";
            } elseif ($this->password !== $this->confirm_password) {
            $this->errors['confirm_password'] = "Password and confirm password must match.";
            }
        }
      
        return $this->errors;
    }

    /**
     * Attempts to retrieve all records from the database table associated with the current class where the stored username matches the provided username
     *
     * @param {string} $user_username - the username who's matching records are to be retrieved
     *
     */
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

    /**
     * Attempts to retrieve all records from the database table associated with the current class where the stored email addres matches the provided email address
     *
     * @param {string} $user_username - the email address who's matching records are to be retrieved
     *
     */
    static public function find_by_email($user_email_address) {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE user_email_address=" . self::$database->quote($user_email_address);
      $object_array = static::find_by_sql($sql);
      if(!empty($object_array)) {
          return array_shift($object_array);
      }   else    {
          return false;
      }
    }
 }
