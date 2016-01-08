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
    GroupController::edit($group_id);
});

$routes->post('/groups/:group_id/edit', function($group_id) {
    GroupController::update($group_id);
});

$routes->post('/groups/:group_id/expel/:user_id', function($group_id, $user_id) {
    GroupController::expel($group_id, $user_id);
});

$routes->post('/groups/:group_id/invite', function($group_id) {
    GroupController::invite($group_id);
});

$routes->get('/groups/:group_id/delete', function($group_id) {
    GroupController::delete($group_id);
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

