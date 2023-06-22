<?php

    // make sure the user is logged in
    if ( !isUserLoggedIn() ) {
        header("Location: /");
        exit;
    }

    $database = connectToDB();

    // get all the POST data
    $comments = $_POST['comments'];
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];

    // do error checking
    if ( empty( $comments ) || empty( $product_id ) || empty( $user_id ) ) {
        $error = "Please fill out the comment";
    }
    
    if( isset ($error)){
        $_SESSION['error'] = $error;
        header("Location: /product?id=$product_id" ); 
        exit;
    }

    // insert the comment into database
    $sql = "INSERT INTO comments (`comments`, `product_id`, `user_id`)
    VALUES(:comments, :product_id, :user_id)";
    $query = $database->prepare( $sql );
    $query->execute([
        'comments' => $comments,
        'product_id' => $product_id,
        'user_id' => $user_id
    ]);

    $_SESSION["success"] = "New product has been created.";
    header("Location: /product?id=$product_id" );
    exit;