<?php

    // call db class
    $database = connectToDB();

    // get total amount in cart
    $total_amount = $_POST['total_amount'];

    // create new order in orders table
    $sql = "INSERT INTO orders (`user_id`,`total_amount`) VALUES (:user_id, :total_amount)";
    $query = $database->prepare($sql);
    $query->execute([
            'user_id' => $_SESSION['user']['id'],
            'total_amount' => $total_amount
        ]);

    // get the last inserted order id
    $order_id = $database->lastInsertId();

    // get all the available products in cart
    $sql = "SELECT * FROM cart WHERE user_id = :user_id AND order_id IS NULL";
    $query = $database->prepare($sql);
    $query->execute([
            'user_id' => $_SESSION['user']['id']
        ]);

    $products_in_cart = $query->fetchAll();

    // loop through the products in cart, and insert the order_id into cart
    foreach( $products_in_cart as $cart ) {
        $sql = "UPDATE cart SET order_id = :order_id WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute([
                'order_id' => $order_id,
                'id' => $cart['id']
            ]);
    }

    // redirect to orders page
    header("Location: /orders");
    exit;