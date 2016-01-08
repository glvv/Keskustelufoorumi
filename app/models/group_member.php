<?php

class Group_Member extends BaseModel {

    public $user_id, $forum_group_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('checkForDuplicate');
    }

    public static function findGroupByUserId($user_id) {
        $rows = parent::queryWithParameters('SELECT Forum_Group.id, Forum_Group.name FROM Forum_Group INNER JOIN Group_Member ON Forum_Group.id = Group_Member.forum_group_id WHERE Group_Member.user_id = :user_id', array('user_id' => $user_id));
        $groups = array();
        foreach ($rows as $row) {
            $groups[] = new Group(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $groups;
    }
    
    public static function addUserToGroup($user_id, $forum_group_id) {
        $parameters = array('user_id' => $user_id, 'forum_group_id' => $forum_group_id);
        $sql = 'INSERT INTO Group_Member (user_id, forum_group_id) VALUES (:user_id, :forum_group_id)';
        $query = DB::connection()->prepare($sql);
        $query->execute($parameters);
    }
    
    public static function verifyMembership($user_id, $forum_group_id) {
        $row = parent::queryWithParametersLimit1('SELECT * FROM Group_Member WHERE user_id = :user_id AND forum_group_id = :forum_group_id', array('user_id' => $user_id, 'forum_group_id' => $forum_group_id));
        if ($row) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public static function delete($forum_group_id, $user_id) {
        $parameters = array('user_id' => $user_id, 'forum_group_id' => $forum_group_id);
        $query = 'DELETE FROM Group_Member WHERE user_id = :user_id AND forum_group_id = :forum_group_id';
        parent::queryWithParameters($query, $parameters);
    }
    
    public static function findGroupMembersByGroupId($group_id) {
        $parameters = array('forum_group_id' => $group_id);
        $sql = 'SELECT Forum_User.id, Forum_User.name FROM Group_Member INNER JOIN Forum_User ON (Forum_User.id = Group_Member.user_id) WHERE Group_Member.forum_group_id = :forum_group_id';
        $rows = parent::queryWithParameters($sql, $parameters);
        $group_members = array();
        foreach ($rows as $row) {
            $group_members[] = new User(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $group_members;
    }
    
    public function save() {
        $parameters = array('user_id' => $this->user_id, 'forum_group_id' => $this->forum_group_id);
        $query = 'INSERT INTO Group_Member (user_id, forum_group_id) VALUES (:user_id, :forum_group_id)';
        parent::queryWithParameters($query, $parameters);
    }
    
    public function checkForDuplicate() {
        $errors = array();
        $parameters = array('user_id' => $this->user_id, 'forum_group_id' => $this->forum_group_id);
        $query = 'SELECT * FROM Group_Member WHERE user_id = :user_id AND forum_group_id = :forum_group_id LIMIT 1';
        $row = parent::queryWithParametersLimit1($query, $parameters);
        if ($row) {
            $errors[] = "Käyttäjä on jo ryhmän jäsen";
        }
        return $errors;
    }

}