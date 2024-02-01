<?php

   // make sure the user is logged in
   if ( !isUserLoggedIn() ) {
     // if is not logged in, redirect to /login page
     header("Location: /login");
     exit;
   }

    // Step 1: connect to the database
    $database = connectToDB();

    // Step 2: get all the data from the form using $_POST
    $post_id = $_POST['post_id'];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $status = $_POST["status"];

    // Step 3: error checking
    // 3.1 make sure all the fields are not empty
    if ( empty( $title ) || empty( $content ) ) {
        setError( 'All the fields are required', '/manage-posts-edit?id=' . $post_id );
    } else {
            // Step 5: update the user data
            $sql = "UPDATE posts SET title = :title, content = :content, status = :status WHERE id = :id";
            $query = $database->prepare( $sql );
            $query->execute([
                'title' => $title,
                'content' => $content,
                'status' => $status,
                'id' => $post_id
            ]);

            // Step 6: redirect back to /manage-users page
            $_SESSION["success"] = "Post has been updated successfully.";
            header("Location: /manage-posts");
            exit;
        }

