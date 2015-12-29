<?php

$routes->get('/', function() {
    ForumController::groups();
});

$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function() {
    UserController::handleLogin();
});

$routes->get('/groups/:group_id', function($group_id) {
    ForumController::topics($group_id);
});

$routes->get('/groups/new', function($group_id) {
    ForumController::newGroup($group_id);
});

$routes->get('/topics/:topic_id', function($topic_id) {
    ForumController::topic($topic_id);
});

$routes->post('/topics/:topic_id/', function($topic_id) {
    MessageController::store($topic_id);
});