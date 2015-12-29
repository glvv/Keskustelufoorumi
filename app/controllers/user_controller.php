<?php

class UserController extends BaseController {

    public static function login() {
        View::make('login.html');
    }

    public static function handleLogin() {
        $params = $_POST;
        $user = User::authenticate($params['username'], $params['password']);
        if (!$user) {
            View::make('login.html', array('error' => 'Väärä käyttäjätunnus tai salasana', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->name . '!'));
        }
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}
