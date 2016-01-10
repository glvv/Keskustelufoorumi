<?php

class TopicController extends BaseController {

    public static function store($group_id) {
        self::checkLoggedIn();
        $user = self::getUserLoggedIn();
        $params = $_POST;
        $topic = new Topic(array(
            'title' => $params['title'],
            'forum_group_id' => $group_id,
            'creator' => $user->id
        ));
        $errors = $topic->errors();
        $message;
        if (count($errors) == 0) {
            $topic->save();
            $message = array('message' => 'Aihe lisätty onnistuneesti');
        } else {
            $message = array('errors' => $errors);
        }
        Redirect::to('/groups/' . $group_id, $message);
    }

}
