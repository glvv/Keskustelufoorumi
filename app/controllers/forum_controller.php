<?php

class ForumController extends BaseController {

    public static function index() {
        View::make('frontpage.html');
    }

    public static function newmessage() {
        View::make('newmessage.html');
    }

    public static function editmessage() {
        View::make('editmessage.html');
    }

    public static function topicview() {
        View::make('topicview.html');
    }

    public static function groups() {
        View::make('grouplist.html');
    }

    public static function topics() {
        View::make('topiclist.html');
    }

}
