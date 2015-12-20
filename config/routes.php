<?php

  $routes->get('/', function() {
    ForumController::index();
  });
  
  $routes->get('/groups', function() {
    ForumController::groups();
  });
  
  $routes->get('/topics', function() {
    ForumController::topics();
  });
  
  $routes->get('/newmessage', function() {
    ForumController::newmessage();
  });
  
    $routes->get('/editmessage', function() {
    ForumController::editmessage();
  });
  
    $routes->get('/viewtopic', function() {
    ForumController::topicview();
  });
