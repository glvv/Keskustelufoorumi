<?php

class User extends BaseModel {

    public $id, $name, $password, $admin;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateName', 'validatePassword');
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
    
    public static function findByName($name) {
        return User::createUserFromResult(parent::queryWithParametersLimit1('SELECT * FROM Forum_User WHERE name = :name', array('name' => $name)));
    }
    
    private static function checkNameAvailability($name) {
        if (parent::queryWithParametersLimit1('SELECT * FROM Forum_User WHERE name = :name', array('name' => $name))) {
            return false;
        }
        return true;
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
        foreach ($rows as $row) {
            $users[] = User::createUserFromResult($row);
        }
        return $users;
    }

    public function save() {
        $parameters = array('name' => $this->name, 'password' => $this->password, 'admin' => $this->admin);
        $query = 'INSERT INTO Forum_User (name, password, admin) VALUES (:name, :password, :admin) RETURNING id';
        $row = parent::queryWithParametersLimit1($query, $parameters);
        $this->id = $row['id'];
    }

    public function validateName() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Käyttäjätunnus ei saa olla tyhjä!';
        } else if (strlen($this->name) < 3) {
            $errors[] = 'Käyttäjätunnuksen pituuden tulee olla vähintään kolme merkkiä!';
        } else if (strlen($this->name > 120)) {
            $errors[] = 'Käyttäjätunnus on liian pitkä, maksimipituus on 120 merkkiä';
        } else {
            if (!User::checkNameAvailability($this->name)) {
                $errors[] = 'Käyttäjätunnus on käytössä!';
            }
        }
        return $errors;
    }

    public function validatePassword() {
        $errors = array();
        if ($this->password == '' || $this->password == null) {
            $errors[] = 'Salasana ei saa olla tyhjä!';
        } else if (strlen($this->password) < 7) {
            $errors[] = 'Salasanan pituuden tulee olla vähintään seitsemän merkkiä!';
        } else if (strlen($this->password) > 120) {
            $errors[] = 'Salasana on liian pitkä, maksimipituus on 120 merkkiä';
        }
        return $errors;
    }
    
}