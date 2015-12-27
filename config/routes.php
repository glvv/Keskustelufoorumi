<?php

$routes->get('/', function() {
    ForumController::groups();
});

$routes->get('/login', function() {
    ForumController::login();
});

$routes->get('/:group_id', function($group_id) {
    ForumController::topics($group_id);
});

$routes->get('/:group_id/new', function($group_id) {
    ForumController::newgroup($group_id);
});

$routes->get('/:group_id/:topic_id', function($group_id, $topic_id) {
    ForumController::topic($group_id, $topic_id);
});

$routes->get('/:group_id/:topic_id/new', function($group_id, $topic_id) {
    ForumController::newtopic($group_id, $topic_id);
});