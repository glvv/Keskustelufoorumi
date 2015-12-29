<?php

$routes->get('/', function() {
    ForumController::groups();
});

$routes->get('/login', function() {
    ForumController::login();
});

$routes->get('/groups/:group_id', function($group_id) {
    ForumController::topics($group_id);
});

$routes->get('/groups/new', function($group_id) {
    ForumController::newgroup($group_id);
});

$routes->get('/topics/:topic_id', function($topic_id) {
    ForumController::topic($topic_id);
});

$routes->post('/topics/:topic_id/', function($topic_id) {
    MessageController::store($topic_id);
});