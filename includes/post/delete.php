<?php

  // make sure the user is logged in
  if ( !isUserLoggedIn() ) {
    // if is not logged in, redirect to /login page
    header("Location: /login");
    exit;
  }



  // Step 1: connect to the database
  $database = connectToDB();

  // Step 2: get todo id from the post 
  $post_id = $_POST["post_id"];

  // Step 3: delete the todo from the database using todo ID
    //3.1 sql command
    $sql = "DELETE FROM posts WHERE id = :id";
    //3.2 prepare
    $query = $database->prepare($sql);
    //3.3 execute 
    $query->execute([ 'id' => $post_id]);

  // confirm user deletion
  $_SESSION["success"] = "User deleted.";

 // Step 4 redirect back to page 
    header("Location: /manage-posts");
    exit;
  ?>