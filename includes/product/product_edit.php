<?php

    // load the database
    $database = connectToDB();

    // get all the $_POST data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $detail = $_POST['detail'];
    $status = $_POST['status'];
    $id = $_POST['id'];

    if(empty($name) || empty($price) || empty($detail) || empty($status)){
        $error = "Make sure all the fields are filled.";
    }
    
    // if error found, set error message & redirect back to the manage-users-edit page with id in the url
    if ( isset( $error ) ) {
        $_SESSION['error'] = $error;
        header("Location: /manage-product-edit?id=$id");
        exit;
    }   
    // if no error found, update the user data based whatever in the $_POST data
    $sql = "UPDATE products SET name = :name, price = :price, detail = :detail, status = :status WHERE id = :id";
    $query = $database->prepare($sql);
    $query->execute([
        'name' => $name,
        'price' => $price,
        'detail' => $detail,
        'status' => $status,
        'id' => $id
    ]);

    // set success message
    $_SESSION["success"] = "Post has been Updated.";

    // redirect
    header("Location: /manage-product");
    exit;