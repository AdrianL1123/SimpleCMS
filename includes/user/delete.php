<?php

  // Step 1: connect to the database
  $database = connectToDB();

  // Step 2: get todo id from the post 
  $delete_user = $_POST["delete_user"];

  // Step 3: delete the todo from the database using todo ID
    //3.1 sql command
    $sql = "DELETE FROM users WHERE id = :id";
    //3.2 prepare
    $query = $database->prepare($sql);
    //3.3 execute 
    $query->execute([ 'id' => $delete_user ]);

 // Step 4 redirect back to page 
    header("Location: /manage-users");
    exit;
  ?>