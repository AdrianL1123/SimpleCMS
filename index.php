<?php

  // start session
  session_start();

  // require the functions.php file
  require "includes/functions.php";

  // get the current path the user is on
  $path = $_SERVER["REQUEST_URI"];
  // remove all the query string from the URL
  $path = parse_url( $path, PHP_URL_PATH );
  // trim out the beginning slash
  $path = trim( $path, '/' );

  // simple router system - deciding what page to load based on the url
  // Routes
  switch ( $path ) {
    // page routes
    case 'login':
      $page_title = "Login";
      require 'pages/login.php';
      break;
    case 'signup':
      $page_title = "Sign Up";
      require 'pages/signup.php';
      break;
    case 'logout':
      $page_title = "Logout";
      require 'pages/logout.php';
      break;
    case 'dashboard':
      $page_title = "dashboard";
      require 'pages/dashboard.php';
      break;
    case 'post':
      $page_title = "post";
      require 'pages/post.php';
      break;
    case 'manage-users':
       $page_title = "manage-users";
       require 'pages/manage-users.php';
       break;
    case 'manage-users-add':
       $page_title = "manage-users-add";
       require 'pages/manage-users-add.php';
       break;
    case 'manage-users-edit':
      $page_title = "manage-users-edit";
      require 'pages/manage-users-edit.php';
      break;
    case 'manage-users-changepwd':
      $page_title = "manage-users-changepwd";
      require 'pages/manage-users-changepwd.php';
      break;
    case 'manage-posts':
      $page_title = "manage-posts";
      require 'pages/manage-posts.php';
      break;
    case 'manage-posts-add':
      $page_title = "manage-posts-add";
      require 'pages/manage-posts-add.php';
      break;
    case 'manage-posts-edit':
      $page_title = "manage-posts-edit";
      require 'pages/manage-posts-edit.php';
      break;
    default:
      $page_title = "Home Page";
      require 'pages/home.php';
      break;

         // action ruotes
    case 'auth/login':
      require 'includes/auth/login.php';
      break;
    case 'auth/signup':
      require 'includes/auth/signup.php';
      break;
    case 'user/add':
      require 'includes/user/add.php';
      break;
    case 'user/delete':
      require 'includes/user/delete.php';
      break;
    case 'user/edit':
      require 'includes/user/edit.php';
      break;
    case 'user/changepwd':
      require 'includes/user/changepwd.php';
      break;
    case 'post/delete':
      require 'includes/post/delete.php';
       break;
    case 'post/add':
      require 'includes/post/add.php';
      break;
    case 'post/edit':
      require 'includes/post/edit.php';
      break;

  }