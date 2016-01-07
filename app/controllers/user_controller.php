<?php

class UserController extends BaseController {

    public static function login() {
        View::make('login.html');
    }
    
    public static function register() {
        View::make('register.html');
    }
    
    public static function handleRegister() {
        $params = $_POST;
        $user = new User(array(
            'name' => $params['username'],
            'password' => $params['password']
        ));
        $errors = $user->errors();
        if (count($errors) == 0) {
            $user->save();
        } else {
            Redirect::to('/register', array('errors' => $errors));
        }
        Redirect::to('/login', array('message' => 'Käyttäjätunnus luotu onnistuneesti'));
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
