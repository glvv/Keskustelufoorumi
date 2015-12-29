<?php

class Group extends BaseModel {

    public $id, $name;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public function save() {
        $parameters = array('name' => $this->name);
        $query = 'INSERT INTO Forum_Group (name) VALUES (:name) RETURNING id';
        $row = parent::queryWithParametersLimit1($query, $parameters);
        $this->id = $row['id'];
    }

}