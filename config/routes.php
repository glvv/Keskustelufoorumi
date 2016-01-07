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

$routes->get('/register', function() {
    UserController::register();
});

$routes->post('/register', function() {
    UserController::handleRegister();
});

$routes->post('/logout', function() {
    UserController::logout();
});

$routes->post('/groups/new', function() {
    GroupController::store();
});

$routes->post('/groups/:group_id/new', function($group_id) {
    TopicController::store($group_id);
});

$routes->get('/groups/:group_id', function($group_id) {
    ForumController::topics($group_id);
});

$routes->get('/groups/:group_id/edit', function($group_id) {
    TopicController::edit($group_id);
});

$routes->get('/topics/:topic_id', function($topic_id) {
    ForumController::topic($topic_id);
});

$routes->post('/topics/:topic_id/', function($topic_id) {
    MessageController::store($topic_id);
});

$routes->get('/topics/:topic_id/:message_id/edit', function($topic_id, $message_id) {
    MessageController::edit($message_id, $topic_id);
});

$routes->post('/topics/:topic_id/:message_id/edit', function($topic_id, $message_id) {
    MessageController::update($message_id, $topic_id);
});

$routes->post('/topics/:topic_id/:message_id/delete', function($topic_id, $message_id) {
    MessageController::delete($message_id, $topic_id);
});

