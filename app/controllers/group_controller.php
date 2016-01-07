<?php

class GroupController extends BaseController {

    public static function store() {
        self::checkLoggedIn();
        $params = $_POST;
        $user_id = $_SESSION['user'];
        $group = new Group(array(
            'name' => $params['name']
        ));
        $errors = $group->errors();
        $messages;
        if (count($errors) == 0) {
            $group->save();
            Group_Member::addUserToGroup($user_id, $group->id);
            $messages = array('message' => 'Ryhmä luotu onnistuneesti');
        } else {
            $messages = array('errors' => $errors);
        }
        Redirect::to('/', $messages);
    }

}
