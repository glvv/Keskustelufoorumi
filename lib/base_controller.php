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

}
