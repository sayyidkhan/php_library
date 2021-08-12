<?php

class User {
    private $id; // int
    private $username; //string
    private $password; //string
    private $name; // string
    private $surname; // string
    private $phone; // string
    private $email; // string
    private $type; // string

    function __construct(
        $id,
        $username,
        $password,
        $name,
        $surname,
        $phone,
        $email,
        $type
    ) {
    $this->id = $id;
    $this->username = $username;
    $this->passowrd = $password;
    $this->name = $name;
    $this->surname = $surname;
    $this->phone = $phone;
    $this->email = $email;
    $this->type = $type;
    }
    
    //dynamic getters and setters
    function __get($name) { return $this->$name;} 
    function __set($name, $value) { $this->$name = $value; }

    public static function init($sql_array) {
        $instance = null;
        try {
            $instance = new self(
            $sql_array['id'],
            $sql_array['username'],
            $sql_array['password'],
            $sql_array['name'],
            $sql_array['surname'],
            $sql_array['phone'],
            $sql_array['email'],
            $sql_array['type']
            );
        }
        catch (Exception $e) {
            $instance = null;
        }
        return $instance;
    }

}

?>