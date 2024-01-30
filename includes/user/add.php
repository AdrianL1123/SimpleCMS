<?php

    // Step 1: connect to the database
    $database = connectToDB();

    // Step 2: get all the data from the form using $_POST
    $role = $_POST["role"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Step 3: error checking
    // 3.1 make sure all the fields are not empty
    if ( empty( $name ) || empty( $email ) || empty( $password ) || empty( $confirm_password )|| empty( $role ) ) {
        setError( "All the fields are required.", '/manage-users-add' );
    } else if ( $password !== $confirm_password ) {
    // 3.2 - make sure password is match
    setError( "The password is not match", '/manage-users-add' );
    } else if ( strlen( $password ) < 8 ) {
    // 3.3 - make sure the password length is at least 8 chars
    setError( "Your password must be at least 8 characters", '/manage-users-add' );
    } else {

    // step 4: make sure the email entered does not exists yet
    $sql = "SELECT * FROM users where email = :email";
    $query = $database->prepare( $sql );
    $query->execute([
        'email' => $email
    ]);
    $user = $query->fetch(); // get only one row of data

    if ( empty( $user ) ) {
        // step 5: create the user account
            // 5.1 - sql command (recipe)
            $sql = "INSERT INTO users (`name`,`email`,`password`,`role`) VALUES (:name, :email, :password, :role)";
            // 5.2 - prepare (put everything into th bowl)
            $query = $database->prepare( $sql );
            // 5.3 - execute (cook it)
            $query->execute([
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'password' => password_hash( $password, PASSWORD_DEFAULT )
            ]);

        // Step 6: redirect back to /manage-users page
        $_SESSION["success"] = "Account has been added successfully.";
        header("Location: /manage-users");
        exit;
    } else {
        setError("The email provided has already been used.","/manage-users");
    }

} // end - step 3


