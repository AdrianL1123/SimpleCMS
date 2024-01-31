<?php
/* store all my functions */

    // connect to database
    function connectToDB() {
    $host = 'devkinsta_db';
    $database_name = 'SimpleCMS';
    $database_user = 'root';
    $database_password = 'f9Rry0z7a1HO6o38';

    // Step 2: connect to the database
    $database = new PDO(
     "mysql:host=$host;dbname=$database_name",
     $database_user,
     $database_password
   );
   
   return $database;
}


// set error message
function setError( $error_message, $redirect_page ) {
  $_SESSION["error"] = $error_message;
  // redirect back to login page
  header("Location: " . $redirect_page );
  exit;
}


// function user is logged in 
function isUserLoggedIn () {
  return isset( $_SESSION["user"]);
}

// is user is an admin
function UserIsAdmin () {
  return isset( $_SESSION["user"]['role'] ) && $_SESSION["user"]['role'] === 'admin';
}
// is user an editor
function UserIsEditor () {
  // return isset( $_SESSION["user"]['role'] ) && $_SESSION["user"]['role'] === 'editor';
}
// is user a normal user 
function UserIsNormal () {
  return isset( $_SESSION["user"]['role'] ) && $_SESSION["user"]['role'] === 'user';
}


