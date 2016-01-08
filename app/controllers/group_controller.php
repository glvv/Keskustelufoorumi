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

    public static function edit($group_id) {
        self::checkLoggedIn();
        self::verifyMembership($group_id);
        $group = Group::findByID($group_id);
        $members = Group_Member::findGroupMembersByGroupId($group_id);
        View::make('editgroup.html', array('members' => $members, 'group' => $group));
    }

    public static function expel($group_id, $user_id) {
        self::checkLoggedIn();
        self::verifyMembership($group_id);
        Group_Member::delete($group_id, $user_id);
        Redirect::to('/groups/' . $group_id . '/edit', array('message' => 'Jäsen poistettu onnistuneesti'));
    }

    public static function invite($group_id) {
        self::checkLoggedIn();
        self::verifyMembership($group_id);
        $params = $_POST;
        $user_id = User::findByName($params['name'])->id;
        $message;
        if ($user_id != null) {
            $group_member = new Group_Member(array(
                'forum_group_id' => $group_id,
                'user_id' => $user_id
            ));
            $errors = $group_member->errors();
            if (count($errors) == 0) {
                $group_member->save();
                $message = array('message' => 'Käyttäjä lisätty onnistuneesti');
            } else {
                $message = array('errors' => $errors);
            }
        } else {
            $message = array('error' => 'Käyttätunnusta ei ole');
        }
        Redirect::to('/groups/' . $group_id . '/edit', $message);
    }

    public static function update($group_id) {
        self::checkLoggedIn();
        self::verifyMembership($group_id);
        $params = $_POST;
        $group = new Group(array(
            'name' => $params['name'],
            'id' => $params['id']
        ));
        $errors = $group->errors();
        $message;
        if (count($errors) == 0) {
            $group->update();
            $message = array('message' => 'Ryhmän nimi vaihdettu onnistuneesti');
        } else {
            $message = array('errors' => $errors);
        }
        Redirect::to('/groups/' . $group_id . '/edit', $message);
    }
    
    public static function destroy($group_id) {
        
    }

}
