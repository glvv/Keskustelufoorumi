<?php

class MessageController extends BaseController {

    public static function store($topic_id) {
        self::checkLoggedIn();
        self::verifyMembershipByTopicId($topic_id);
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
    
    public static function edit($id, $topic_id) {
        self::checkLoggedIn();
        self::verifyMembershipByTopicId($topic_id);
        $message = Message::findById($id);
        View::make('editmessage.html', array('message' => $message));
    }
    
    public static function update($id, $topic_id) {
        self::checkLoggedIn();
        self::verifyMembershipByTopicId($topic_id);
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'author' => $params['author'],
            'posted' => $params['posted'],
            'message' => $params['message'],
            'topic_id' => $params['topic_id']
        );
        $message = new Message($attributes);
        $errors = $message->errors();
        if (count($errors) == 0) {
            $message->update();
        } else {
            Redirect::to('/topics/' . $message->topic_id . '/' . $message->id . '/edit', array('errors' => $errors));
        }
        Redirect::to('/topics/' . $message->topic_id);
    }
    
    public static function delete($id, $topic_id) {
        self::checkLoggedIn();
        self::verifyMembershipByTopicId($topic_id);
        MessageController::delete($id);
    }    
}