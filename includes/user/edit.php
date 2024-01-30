<?php

  // Step 2: connect to the database
  $database = connectToDB();
    
      // step 3: get student id and updated name from $_POST
      $name = $_POST["name"];
      $email = $_POST["email"];
      $role = $_POST["role"];
    
      // do error checking. Check if student name is empty or not
      if ( empty( $name) || empty( $role )|| empty( $email ) ) {
        echo "Please enter a name";
      } else {
        // Step 4: update the name in database
            // 4.1 - sql command (recipe)
            $sql = "UPDATE users SET name = :name WHERE role = :role";
            // 4.2 - prepare (put everything into the bowl)
            $query = $database->prepare( $sql );
            // 4.3 - execute (cook it)
            $query->execute([
                'name' => $name,
                'email' => $email,
                'role' => $role
            ]);
    
        // Step 5: redirect back to home page
        header("Location: /manage-users");
        exit;
    
      }