<?php

class Topic extends BaseModel {

    public $id, $title, $forum_group_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateTitle');
    }
    
    private static function createNewTopicFromResult($row) {
        return new Topic(array(
            'id' => $row['id'],
            'title' => $row['title'],
            'forum_group_id' => $row['forum_group_id']
        ));
    }
    
    public static function findByGroupId($group_id) {
        $rows = parent::queryWithParameters('SELECT * FROM Topic WHERE forum_group_id = :group_id', array('group_id' => $group_id));
        $topics = array();
        foreach ($rows as $row) {
            $topics[] = Topic::createNewTopicFromResult($row);
        }
        return $topics;
    }
    
    public static function findById($id) {
        return Topic::createNewTopicFromResult(parent::queryWithParametersLimit1('SELECT * FROM Topic WHERE id = :id LIMIT 1', array('id' => $id)));
    }
    
    public function save() {
        $parameters = array('title' => $this->title, 'forum_group_id' => $this->forum_group_id);
        $query = 'INSERT INTO Topic (title, forum_group_id) VALUES (:title, :forum_group_id) RETURNING id';
        $row = parent::queryWithParametersLimit1($query, $parameters);
        $this->id = $row['id'];
    }
    
    public function validateTitle() {
        $errors = array();
        if ($this->title == '' || $this->title == NULL) {
            $errors[] = 'Otsikko ei saa olla tyhjä';
        } else if (strlen($this->title) > 120) {
            $errors[] = 'Otsikko on liian pitkä, maksimipituus 120 merkkiä';
        }
        return $errors;
    }

}