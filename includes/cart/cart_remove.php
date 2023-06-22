<?php

    // call the db class
    $database = connectToDB();

    // get the cart id
    $cart_id = $_POST['cart_id'];

    // delete from the cart table
    $sql = "DELETE FROM cart WHERE id = :id";
    $query = $database->prepare($sql);
    $query->execute([
            'id' => $cart_id
    ]);

    // redirect to cart page
    header("Location: /cart");
    exit;