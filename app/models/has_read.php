<?php

class Has_Read extends BaseModel {

    public $message_id, $user_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public function save() {
        if (!$this->checkIfExists()) {
            $query = DB::connection()->prepare('INSERT INTO Has_Read (message_id, user_id) VALUES (:message_id, :user_id)');
            $query->execute(array('message_id' => $this->message_id, 'user_id' => $this->user_id));
        }
    }

    private function checkIfExists() {
        $query = DB::connection()->prepare('SELECT * FROM Has_Read WHERE message_id = :message_id AND user_id = :user_id LIMIT 1');
        $query->execute(array('message_id' => $this->message_id, 'user_id' => $this->user_id));
        $row = $query->fetch();
        if ($row) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
