<?php

class MessageController extends BaseController {

    public static function store($topic_id) {
        $user_id = $_SESSION['user'];
        $params = $_POST;
        $message = new Message(array(
            'message' => $params['message'],
            'author' => $user_id,
            'topic_id' => $topic_id
        ));
        $errors = $message->errors();
        if (count($errors) == 0) {
            $message->save();
        } else {
            Redirect::to('/topics/' . $topic_id, array('errors' => $errors));
        }
        Redirect::to('/topics/' . $topic_id);
    }
    
    public static function edit($id) {
        $message = Message::findById($id);
        View::make('editmessage.html', array('message' => $message));
    }
    
    public static function update($id) {
        
    }
    
}
