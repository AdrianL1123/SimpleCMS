<?php

   // make sure the user is logged in
   if ( !isUserLoggedIn() ) {
     // if is not logged in, redirect to /login page
     header("Location: /login");
     exit;
   }
 
   // make sure only admin can see this page
   if ( !UserIsAdmin() ) {
     // if is not admin, then redirect the user back to /dashboard
     header("Location: /dashboard");
     exit;
   }

    // Step 1: connect to the database
    $database = connectToDB();

    // Step 2: get all the data from the form using $_POST
    $post_id = $_POST['post_id'];
    $title = $_POST["title"];
    $content = $content["content"];

    // Step 3: error checking
    // 3.1 make sure all the fields are not empty
    if ( empty( $title ) || empty( $content ) ) {
        setError( 'All the fields are required', '/manage-users-edit?id=' . $user_id );
    } else { ( empty( $post ) ) {
            // Step 5: update the user data
            $sql = "UPDATE posts SET title = :title content = :content WHERE title = :title, content = :content, id = :id";
            $query = $database->prepare( $sql );
            $query->execute([
                'title' => $title,
                'content' => $content,
                'id' => $post_id
            ]);

            // Step 6: redirect back to /manage-users page
            $_SESSION["success"] = "User data has been updated successfully.";
            header("Location: /manage-users");
            exit;
        }

    } // end - step 3