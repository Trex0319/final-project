<?php

    // load the database
    $database = connectToDB();

    // get all the $_POST data
    $id = $_POST["id"];
    $product_id = $_POST['product_id'];
    /* 
        do error check
        - make sure the id is not empty
    */
    if (empty($id)){
        $error = "Error!";
    }

    // if error found, set error message & redirect back to the manage-users page
    if ( isset( $error ) ) {
        $_SESSION['error'] = $error;
        header("Location: /product?id=$product_id");
        exit;
    }

    // if no error found, delete the user
    $sql = "DELETE FROM comments WHERE id = :id";
    $query = $database->prepare($sql);
    $query->execute([
        'id' => $id
    ]);

    // redirect
    header("Location: /product?id=$product_id");
    exit;