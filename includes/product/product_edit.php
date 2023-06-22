<?php

    // load the database
    $database = connectToDB();

    // get all the $_POST data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $detail = $_POST['detail'];
    $status = $_POST['status'];
    $author = $_POST['author'];
    $page = $_POST['page'];
    $original_image = $_POST['original_image'];
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $id = $_POST['id'];

    if ( !empty( $image_name ) ) {
    // target the uploads folder
    $target_dir = "uploads/";
    // add the image name to the uploads folder
    $target_file = $target_dir . basename( $image_name ); // output: uploads/fs.jpg
    // move the file to the uploads folder
    move_uploaded_file( $image["tmp_name"], $target_file );
  }
            

    if(empty($name) || empty($price) || empty($detail) || empty($status) || empty($author) || empty($page)){
        $error = "Make sure all the fields are filled.";
    }
    
    // if error found, set error message & redirect back to the manage-users-edit page with id in the url
    if ( isset( $error ) ) {
        $_SESSION['error'] = $error;
        header("Location: /manage-product-edit?id=$id");
        exit;
    }   
    // if no error found, update the user data based whatever in the $_POST data
    $sql = "UPDATE products SET name = :name, price = :price, detail = :detail, image = :image, author = :author, page = :page, status = :status WHERE id = :id";
    $query = $database->prepare($sql);
    $query->execute([
        'name' => $name,
        'price' => $price,
        'detail' => $detail,
        'author' => $author,
        'page' => $page,
        'status' => $status,
        'image' => ( !empty( $image_name ) ? $image_name : ( !empty( $original_image ) ? $original_image : null ) ),
        'id' => $id
    ]);

    // set success message
    $_SESSION["success"] = "Product has been Updated.";

    // redirect
    header("Location: /manage-product");
    exit;

    ?>
 