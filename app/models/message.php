<?php

class Message extends BaseModel {

    public $id, $author, $posted, $message, $topic_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    private static function createUserFromResult($row) {
        return new User(array(
            'id' => $row['id'],
            'name' => $row['name']
        ));
    }

    private static function createNewMessageFromResult($row) {
        return new Message(array(
            'id' => $row['id'],
            'author' => $row['author'],
            'posted' => $row['posted'],
            'message' => $row['message'],
            'topic_id' => $row['topic_id']
        ));
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Forum_Message ORDER BY posted');
        $query->execute();
        $rows = $query->fetchAll();
        $messages = array();
        foreach ($rows as $row) {
            $messages[] = $this->createNewMessageFromResult($row);
        }
        return $messages;
    }

    public static function findById($id) {
        $query = DB::connection()->prepare('SELECT * FROM Forum_Message WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        return $this->createNewMessageFromResult($row);
    }

    public static function findByTopicId($id) {
        $query = DB::connection()->prepare('SELECT * FROM Forum_Message WHERE topic_id = :id ORDER BY posted');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $messages = array();
        foreach ($rows as $row) {
            $messages[] = $this->createNewMessageFromResult($row);
        }
        return $messages;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO MESSAGE (author, posted, message, topic_id) VALUES (:author, NOW(), :message, :topic_id) RETURNING id');
        $query->execute(array('author' => $this->author, 'message' => $this->message, 'topic_id' => $this->topic_id));
        $row = $query->fetch();
        $this->id = $row['id'];    
    }
    
    

}
