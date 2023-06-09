<?php

    if ( !isUserLoggedIn() ) {
        header("Location: /");
        exit;
    }
    // load database
    $database = connectToDB();

    // get all the POST data
    $name = $_POST["name"];
    $price = $_POST["price"];

    if ( empty( $name ) || empty($price)) {
        $error = 'All fields are required';
    }

    if( isset ($error)){
        $_SESSION['error'] = $error;
        header("Location: /manage-product-add");    
    } else {
        // if no error found, process to account creation
        $sql = "INSERT INTO products (`name`, `price`, `id` )
        VALUES(:name, :price, :id)";
        $query = $database->prepare( $sql );
        $query->execute([
            'name' => $name,
            'price' => $price,
            'id' => $_SESSION['id']
        ]);

        // redirect the user back to manage-users page
        $_SESSION["success"] = "New product has been created.";
        header("Location: /manage-product");
        exit;

    }