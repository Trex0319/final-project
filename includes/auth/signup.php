<?php

    $database = connectToDB();
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

        // recipe
        $sql = "SELECT * FROM users where email = :email";
        // prepare
        $query = $database->prepare( $sql );
        // execute
        $query->execute([
            'email' => $email
        ]);
        // fetch (eat)
        $user = $query->fetch(); // fetch() will only return one row of data

        // 1. make sure all fields are not empty
        if ( empty( $name ) || empty($email) || empty($password) || empty($confirm_password)  ) {
            $error = 'All fields are required';
        } else if ( $password !== $confirm_password ) {
            // 2. make sure password is match
            $error = 'The password is not match.';
        } else if ( strlen( $password ) < 8 ) {
            // 3. make sure password is at least 8 chars.
            $error = "Your password must be at least 8 characters";
        } else if ( $user ) {
                // 4. make sure email provided is not already exists in the users table
            $error = "The email you inserted has already been used by another user. Please insert another email.";
        } else {
            // recipe
            $sql = "INSERT INTO users ( `name`, `email`, `password` )
                VALUES (:name, :email, :password)";
            // prepare
            $statement = $database->prepare( $sql );
            // execute
            $statement->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash( $password, PASSWORD_DEFAULT )
            ]);
            $_SESSION["user"] = $user;
            header('Location: /dashboard');
            exit;
        }

        
        // do error checking
        if ( isset( $error ) ) {
            // store the error message in session
            $_SESSION['error'] = $error;
            // redirect the user back to login.php
            header("Location: /signup");
            exit;
        }