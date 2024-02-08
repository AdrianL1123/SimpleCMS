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
    $title = $_POST["title"];
    $content = $_POST["content"];
    
    // capture the image file
    $image = $_FILES["image"];

    // make sure that you only upload if image is available
    if ( !empty( $image['name'] ) ) {
        $target_dir = "uploads/";
        // add the image name to the uploads folder path
        $target_path = $target_dir . time() . '_' . basename( $image['name'] ); // uploads/892938829293_image.jpg
        // move the file to the uploads folder
        move_uploaded_file( $image["tmp_name"], $target_path );
    }

    // Step 3: error checking
    // 3.1 make sure all the fields are not empty
    if ( empty($title) || empty($content) ) {
        setError("All the fields are required.","/manage-posts-add");
    }

    // Step 4: add the post into the database
    $sql = "INSERT INTO posts (`title`,`content`,`image`,`user_id`) VALUES (:title,:content,:image,:user_id)";
    $query = $database->prepare( $sql );
    $query->execute([
        'title' => $title,
        'content' => $content,
        'image' => !empty( $image['name'] ) ? $target_path : '',
        'user_id' => $_SESSION['user']['id']
    ]);

    // Step 5: redirect back to /manage-posts
    $_SESSION["success"] = "New post has been added.";
    header("Location: /manage-posts");
    exit;
