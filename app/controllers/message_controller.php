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

        MessageController::setMessageToHaveBeenReadByAuthor($message->id, $user_id);

        Redirect::to('/topics/' . $topic_id);
    }

    private static function setMessageToHaveBeenReadByAuthor($message_id, $user_id) {
        $has_read = new Has_Read(array(
            'message_id' => $message_id,
            'user_id' => $user_id
        ));
        $has_read->save();
    }

}
