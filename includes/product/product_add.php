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
    $detail = $_POST["detail"];
    $author = $_POST['author'];
    $page = $_POST['page'];
    $subject = $_POST['subject'];
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $user_id = $_SESSION['user']['id'];

    if ( !empty( $image_name ) ) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename( $image_name ); 
        move_uploaded_file( $image["tmp_name"], $target_file );
    }

    if ( empty( $name ) || empty($price) || empty($detail) || empty($author) || empty($page) || empty($subject) || empty($image_name)) {
        $error = 'All fields are required';
    }

    if( isset ($error)){
        $_SESSION['error'] = $error;
        header("Location: /manage-product-add");    
    } else {
        // if no error found, process to account creation
        $sql = "INSERT INTO products (`name`, `price`, `detail`, `author`, `page`, `subject`, `image`, `user_id` )
        VALUES(:name, :price, :detail, :author, :page, :subject, :image, :user_id)";
        $query = $database->prepare( $sql );
        $query->execute([
            'name' => $name,
            'price' => $price,
            'detail' => $detail,
            'author' => $author,
            'page' => $page,
            'subject' => $subject,
            'image' => $image_name,
            'user_id' => $user_id
        ]);

        // redirect the user back to manage-users page
        $_SESSION["success"] = "New product has been created.";
        header("Location: /manage-product");
        exit;

    }

    ?>