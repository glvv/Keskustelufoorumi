<?php

class ForumController extends BaseController {

    public static function login() {
        View::make('login.html');
    }

    public static function groups() {
        //autentikointia ei toteutettu
//        $user_id = $_SESSION['user'];
        $user_id = 1;
        $groups = Group_Member::findGroupByUserId($user_id);
        View::make('groups.html', array('groups' => $groups));
    }
    
    public static function topics($group_id) {
        $topics = Topic::findByGroupId($group_id);
        View::make('topics.html', array('topics' => $topics));
    }
    
    public static function topic($topic_id) {
        $messages = Message::findByTopicId($topic_id);
        $topic = Topic::findById($topic_id);
        View::make('topic.html', array('messages' => $messages, 'topic' => $topic));
    }

}
