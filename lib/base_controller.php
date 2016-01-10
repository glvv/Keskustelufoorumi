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
    
    public static function verifyRightsforDeletingOrEditingGroup($group_id) {
        $user = self::getUserLoggedIn();
        $creator = Group::findByID($group_id)->creator;
        if (!($user->admin || $creator == $user->id)) {
            Redirect::to('/', array('message' => 'Sinulla ei ole oikeuksia!'));
        }
    }
    
    public static function verifyRightsforDeletingOrEditingMessage($message_id) {
        $user = self::getUserLoggedIn();
        $author = Message::findByID($message_id)->author;
        if (!($user->admin || $author->id == $user->id)) {
            Redirect::to('/', array('message' => 'Sinulla ei ole oikeuksia!'));
        }
    }

    public static function checkLoggedIn() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }
    
    public static function verifyMembership($forum_group_id) {
        $user = self::getUserLoggedIn();
        if (!((Group_Member::verifyMembership($user->id, $forum_group_id) || $user->admin))) {
            Redirect::to('/', array('message' => 'Et ole ryhmän jäsen!'));
        }
    }
    
    public static function verifyMembershipByTopicId($topic_id) {
        $forum_group_id = Topic::findById($topic_id)->forum_group_id;
        $user = self::getUserLoggedIn();
        if (!((Group_Member::verifyMembership($user->id, $forum_group_id) || $user->admin))) {
            Redirect::to('/', array('message' => 'Et ole ryhmän jäsen!'));
        }
    }
    
}
