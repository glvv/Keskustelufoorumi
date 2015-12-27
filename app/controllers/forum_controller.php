<?php

class ForumController extends BaseController {

    public static function login() {
        View::make('login.html');
    }

    public static function groups() {
        $user_id = $_SESSION['user'];
        $groups = Group_Member::findGroupByUserId($user_id);
        View::make('groups.html', array('groups' => $groups));
    }
    
    public static function topics() {
        View::make('topiclist.html');
    }

}
