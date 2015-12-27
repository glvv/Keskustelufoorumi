<?php

class MessageController extends BaseController {

    public static function store($topic_id) {
        $user = self::get_user_logged_in();
        $params = $_POST;
        $message = new Message(array(
            'message' => $params['message'],
            'author' => $user['id'],
            'topic_id' => $topic_id
        ));
        $message->save();
        Redirect::to('/');
    }

}