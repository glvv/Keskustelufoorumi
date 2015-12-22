<?php

class Message extends BaseModel {

    public $id, $author, $posted, $message, $topic_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
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
        $query = DB::connection()->prepare('SELECT * FROM Forum_Message');
        $query->execute();
        $rows = $query->fetchAll();
        $messages = array();
        foreach ($rows as $row) {
            $messages[] = $this->createNewMessageFromResult($row);
        }
        return $messages;
    }

    public static function find($id) {
        
    }

    public static function findByTopicId($id) {
        
    }

}
