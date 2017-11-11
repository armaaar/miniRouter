<?php

require_once('router/router.php');
require_once('controllers/homepage.php');

$user = true;
$admin = true;

$router = new miniRouter();

$router->filter("is_user", function(){
  global $user;
  if($user)
    return true;
  return false;
});


$router->filter("is_admin", function(){
  global $admin;
  if($admin)
    return true;
  return true;
});

$router->get('/', "homePageController");

$router->group("/router", function($router){

  $router->get(['/house/{:s}/([a-zA-Z0-9+_\-\.]+)', "index"], "homePageController");




  $router->get('/home/{:s}?/', "homeCloneController");

  $router->get('/laugh', function(){

    echo "hahaha ".$_REQUEST["lala"];
  }, ["is_user", "is_admin"]);

  $router->group('/api', function($router){

    $router->any('/users', function(){
      echo "list of users";
    });
    $router->get('/boxes', function(){
      echo "list of boxes";
    });
  }, ["is_user", "is_admin"]);

});




$router->fallback(function(){
  echo "Page Not Found";
});
