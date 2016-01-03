<?php

class Message extends BaseModel {

    public $id, $author, $posted, $message, $topic_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateMessage');
    }

    private static function createNewMessageFromResult($row) {
        $author = User::findByID($row['author']);
        return new Message(array(
            'id' => $row['id'],
            'author' => $author,
            'posted' => $row['posted'],
            'message' => $row['message'],
            'topic_id' => $row['topic_id']
        ));
    }

    public static function all() {
        $rows = parent::queryWithoutParameters('SELECT * FROM Forum_Message ORDER BY posted');
        $messages = array();
        foreach ($rows as $row) {
            $messages[] = Message::createNewMessageFromResult($row);
        }
        return $messages;
    }

    public static function findById($id) {
        $row = parent::queryWithParametersLimit1('SELECT * FROM Forum_Message WHERE id = :id LIMIT 1', array('id' => $id));
        return Message::createNewMessageFromResult($row);
    }

    public static function findByTopicId($id) {
        $rows = parent::queryWithParameters('SELECT * FROM Forum_Message WHERE topic_id = :id ORDER BY posted', array('id' => $id));
        $messages = array();
        foreach ($rows as $row) {
            $messages[] = Message::createNewMessageFromResult($row);
        }
        return $messages;
    }

    public function save() {
        $parameters = array('author' => $this->author, 'message' => $this->message, 'topic_id' => $this->topic_id);
        $query = 'INSERT INTO Forum_Message (author, posted, message, topic_id) VALUES (:author, NOW(), :message, :topic_id) RETURNING id';
        $row = parent::queryWithParametersLimit1($query, $parameters);
        $this->id = $row['id'];
    }

    public function update() {
        $parameters = array('author' => $this->author, 'message' => $this->message, 'topic_id' => $this->topic_id, 'id' => $this->id);
        $query = 'UPDATE Forum_Message SET author = :author, posted = :posted, message = :message, topic_id = :topic_id WHERE id = :id';
        parent::queryWithParameters($query, $parameters);
    }
    
    public static function delete($id) {
        $parameters = array('id' => $id);
        $query = 'DELETE FROM Forum_Message WHERE id = :id';
        parent::queryWithParameters($query, $parameters);
    }

    public function validateMessage() {
        $errors = array();
        if ($this->message == '' || $this->message == NULL) {
            $errors[] = 'Viesti ei saa olla tyhjä';
        }
        return $errors;
    }
    
    

}
