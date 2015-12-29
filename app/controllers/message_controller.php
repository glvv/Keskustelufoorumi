<?php

class MessageController extends BaseController {

    public static function store($topic_id) {
        $user_id = 1;
        $params = $_POST;
        $message = new Message(array(
            'message' => $params['message'],
            'author' => $user_id,
            'topic_id' => $topic_id
        ));
        $message->save();

        Redirect::to('/topics/' . $topic_id);
    }
    
}
