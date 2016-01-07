<?php

class ForumController extends BaseController {

    public static function groups() {
        self::checkLoggedIn();
        $user_id = $_SESSION['user'];
        $groups = Group_Member::findGroupByUserId($user_id);
        View::make('groups.html', array('groups' => $groups));
    }
    
    public static function topics($group_id) {
        self::checkLoggedIn();
        self::verifyMembership($group_id);
        $group = Group::findByID($group_id);
        $topics = Topic::findByGroupId($group_id);
        View::make('topics.html', array('topics' => $topics, 'group' => $group));
    }
    
    public static function topic($topic_id) {
        self::checkLoggedIn();
        self::verifyMembershipByTopicId($topic_id);
        $messages = Message::findByTopicId($topic_id);
        $topic = Topic::findById($topic_id);
        View::make('topic.html', array('messages' => $messages, 'topic' => $topic));
    }
    
}