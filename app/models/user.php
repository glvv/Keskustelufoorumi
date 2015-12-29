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
        return User::createUserFromResult(parent::queryWithParametersLimit1('SELECT * FROM Forum_User WHERE id = :id', array('id' => $id)));
    }

    public static function authenticate($name, $password) {
        $row = parent::queryWithParametersLimit1('SELECT * FROM Forum_User WHERE name = :name AND password = :password LIMIT 1', array('name' => $name, 'password' => $password));
        if ($row) {
            return User::createUserFromResult($row);
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
        $parameters = array('author' => $this->author, 'message' => $this->message, 'topic_id' => $this->topic_id);
        $query = 'INSERT INTO Forum_User (name, password, admin) VALUES (:name, :password, :admin) RETURNING id';
        $row = parent::queryWithParametersLimit1($query, $parameters);
        $this->id = $row['id'];
    }

}
