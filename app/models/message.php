<?php

class Message extends BaseModel {

    public $id, $author, $posted, $message, $topic_id, $read_users;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    private static function findUsersWhoHaveReadTheMessage($id) {
        $query = DB::connection()->prepare('SELECT Forum_User.id, Forum_User.name FROM Forum_User INNER JOIN Has_Read ON Forum_User.id = Has_Read.user_id WHERE message_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $users = array();
        foreach ($rows as $row) {
            $users[] = Message::createUserFromResult($row);
        }
        return $users;
    }

    private static function createUserFromResult($row) {
        return new User(array(
            'id' => $row['id'],
            'name' => $row['name']
        ));
    }

    private static function createNewMessageFromResult($row) {
        $usersWhoHaveReadTheMessage = Message::findUsersWhoHaveReadTheMessage($row['id']);
        $author = User::findByID($row['author']);
        return new Message(array(
            'id' => $row['id'],
            'author' => $author,
            'posted' => $row['posted'],
            'message' => $row['message'],
            'topic_id' => $row['topic_id'],
            'read_users' => $usersWhoHaveReadTheMessage
        ));
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Forum_Message ORDER BY posted');
        $query->execute();
        $rows = $query->fetchAll();
        $messages = array();
        foreach ($rows as $row) {
            $messages[] = Message::createNewMessageFromResult($row);
        }
        return $messages;
    }

    public static function findById($id) {
        $query = DB::connection()->prepare('SELECT * FROM Forum_Message WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        return Message::createNewMessageFromResult($row);
    }

    public static function findByTopicId($id) {
        $query = DB::connection()->prepare('SELECT * FROM Forum_Message WHERE topic_id = :id ORDER BY posted');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $messages = array();
        foreach ($rows as $row) {
            $messages[] = Message::createNewMessageFromResult($row);
        }
        return $messages;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Forum_Message (author, posted, message, topic_id) VALUES (:author, NOW(), :message, :topic_id) RETURNING id');
        $query->execute(array('author' => $this->author, 'message' => $this->message, 'topic_id' => $this->topic_id));
        $row = $query->fetch();
        $this->id = $row['id'];    
    }
    
    

}
