<?php

class User extends BaseModel {

    public $id, $name, $password, $admin;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    private static function createUserFromResult($row) {
        return new User(array(
            'id' => $row['id'],
            'name' => $row['name'],
            'password' => $row['password'],
            'admin' => $row['admin']
        ));
    }

    public static function findByID($id) {
        $rows = parent::queryWithParameters('SELECT * FROM Forum_User WHERE id = :id', array('id' => $id));
        return User::createUserFromResult($rows[0]);
    }

    public static function authenticate($name, $password) {
        $rows = parent::queryWithParameters('SELECT * FROM Forum_User WHERE name = :name AND password = :password LIMIT 1', array('name' => $name, 'password' => $password));
        if ($rows[0]) {
            return User::createUserFromResult($rows[0]);
        } else {
            return NULL;
        }
    }
    
    public static function all() {
        $rows = parent::queryWithoutParameters('SELECT * FROM Forum_User');
        $users = array();
        foreach($rows as $row) {
            $users[] = User::createUserFromResult($row);
        }
        return $users;
    }
    
    public function save() {
        
    }

}
