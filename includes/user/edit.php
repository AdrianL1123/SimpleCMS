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
    $user_id = $_POST['user_id'];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    // Step 3: error checking
    // 3.1 make sure all the fields are not empty
    if ( empty( $name ) || empty( $email ) || empty( $role ) ) {
        setError( 'All the fields are required', '/manage-users-edit?id=' . $user_id );
    } else {
        // Step 4: make sure the email entered wasn't already exists in the database
        $sql = "SELECT * FROM users where email = :email AND id != :id";
        $query = $database->prepare( $sql );
        $query->execute([
            'email' => $email,
            'id' => $user_id
        ]);
        $user = $query->fetch(); // get only one row of data

        if ( empty( $user ) ) {
            // Step 5: update the user data
            $sql = "UPDATE users SET name = :name, email = :email, role = :role WHERE id = :id";
            $query = $database->prepare( $sql );
            $query->execute([
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'id' => $user_id
            ]);

            // Step 6: redirect back to /manage-users page
            $_SESSION["success"] = "User data has been updated successfully.";
            header("Location: /manage-users");
            exit;
        } else {
            setError("The email provided has already been used.",'/manage-users-edit?id=' . $user_id);
        } // end - $user

    } // end - step 3
