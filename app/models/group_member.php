<?php

class Group_Member extends BaseModel {
    
    public $user_id, $forum_group_id;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function findGroupByUserId($user_id) {
        $query = DB::connection()->prepare('SELECT Forum_Group.id, Forum_Group.name FROM Forum_Group INNER JOIN Group_Member ON Forum_Group.id = Group_Member.forum_group_id WHERE Group_Member.user_id = :user_id');
        $query->execute(array('user_id' => $user_id));
        $rows = $query->fetchAll();
        $groups = array();
        foreach ($rows as $row) {
            $groups[] = new Group(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $groups;
    }
    
}