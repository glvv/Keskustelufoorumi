<?php

class User extends BaseModel {

    public $id, $name, $password, $admin;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findByID($id) {
        
    }

    public static function authenticate($name, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Forum_User WHERE name = :name AND password = :password LIMIT 1');
        $query->execute(array('name' => $name, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            
        }
    }

}
