<?php

class BaseController {

    public static function getUserLoggedIn() {
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];
            $user = User::findByID($user_id);
            return $user;
        }
        return null;
    }

    public static function checkLoggedIn() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }
    
    public static function verifyMembership($forum_group_id) {
        $user_id = $_SESSION['user'];
        if (!Group_Member::verifyMembership($user_id, $forum_group_id)) {
            Redirect::to('/', array('message' => 'Et ole ryhmän jäsen!'));
        }
    }
    
    public static function verifyMembershipByTopicId($topic_id) {
        $forum_group_id = Topic::findById($topic_id)->forum_group_id;
        $user_id = $_SESSION['user'];
        if (!Group_Member::verifyMembership($user_id, $forum_group_id)) {
            Redirect::to('/', array('message' => 'Et ole ryhmän jäsen!'));
        }
    }
    
}
