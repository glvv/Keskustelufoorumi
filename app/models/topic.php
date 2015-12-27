<?php

class Topic extends BaseModel {

    public $id, $title, $forum_group_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    private static function createNewTopicFromResult($row) {
        return new Topic(array(
            'id' => $row['id'],
            'title' => $row['title'],
            'forum_group_id' => $row['forum_group_id']
        ));
    }
    
    public static function findByGroupId($group_id) {
        $query = DB::connection()->prepare('SELECT * FROM Topic WHERE forum_group_id = :group_id');
        $query->execute(array('group_id' => $group_id));
        $rows = $query->fetchAll();
        $topics = array();
        foreach ($rows as $row) {
            $topics[] = Topic::createNewTopicFromResult($row);
        }
        return $topics;
    }
    
    public static function findById($id) {
        $query = DB::connection()->prepare('SELECT * FROM Topic WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        return Topic::createNewTopicFromResult($row);
    }

}
