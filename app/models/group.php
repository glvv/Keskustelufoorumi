<?php

class Group extends BaseModel {

    public $id, $name, $creator;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateName');
    }

    public static function createGroupFromResult($row) {
        return new Group(array(
            'id' => $row['id'],
            'name' => $row['name'],
            'creator' => $row['creator']
        ));
    }

    public static function all() {
        $rows = parent::queryWithoutParameters('SELECT * FROM Forum_Group');
        $groups = array();
        foreach ($rows as $row) {
            $groups[] = self::createGroupFromResult($row);
        }
        return $groups;
    }

    public function save() {
        $parameters = array('name' => $this->name, 'creator' => $this->creator);
        $query = 'INSERT INTO Forum_Group (name, creator) VALUES (:name, :creator) RETURNING id';
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
            'name' => $row['name'],
            'creator' => $row['creator']
        ));
    }

    public function update() {
        $parameters = array('id' => $this->id, 'name' => $this->name);
        $query = 'UPDATE Forum_Group SET name = :name WHERE id = :id';
        parent::queryWithParameters($query, $parameters);
    }

    public static function delete($id) {
        $parameters = array('id' => $id);
        $query = 'DELETE FROM Forum_Group WHERE id = :id';
        parent::queryWithParameters($query, $parameters);
    }

}
