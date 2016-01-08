<?php

class Group extends BaseModel {

    public $id, $name;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateName');
    }

    public function save() {
        $parameters = array('name' => $this->name);
        $query = 'INSERT INTO Forum_Group (name) VALUES (:name) RETURNING id';
        $row = parent::queryWithParametersLimit1($query, $parameters);
        $this->id = $row['id'];
    }

    public function validateName() {
        $errors = array();
        if ($this->name == '' || $this->name == NULL) {
            $errors[] = 'Ryhmän nimi ei saa olla tyhjä';
        } else if (strlen($this->name) > 120) {
            $errors[] = 'Ryhmän nimi on liian pitkä';
        }
        return $errors;
    }

    public static function findByID($id) {
        $row = parent::queryWithParametersLimit1('SELECT * FROM Forum_Group WHERE id = :id LIMIT 1', array('id' => $id));
        return new Group(array(
            'id' => $row['id'],
            'name' => $row['name']
        ));
    }
    
    public function update() {
        $parameters = array('id' => $this->id, 'name' => $this->name);
        $query = 'UPDATE Forum_Group SET name = :name WHERE id = :id';
        parent::queryWithParameters($query, $parameters);
    }

}
