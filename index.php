<?php
    session_start();

       // Instruction: require all the files you need here. Tips: (includes/functions.php, includes/class-products.php)
       require "includes/functions.php";

    // get route
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

    // remove query string
    $path = parse_url( $path, PHP_URL_PATH );

    $path = trim( $path, '/');
        switch( $path ) {
            case 'wishlist/submit':
                require 'includes/wishlist/submit.php';
                break;
            case 'auth/login':
                require "includes/auth/login.php";
                break;
            case 'auth/signup':
                require "includes/auth/signup.php";
                break;
            case 'product_add': 
                require "includes/product/product_add.php";
                break;
            case 'product_delete': 
                require "includes/product/product_delete.php";
                break;
            case 'product_edit': 
                require "includes/product/product_edit.php";
                break;
            case 'cart':
                require "pages/cart.php";
                break;
            case 'dashboard': 
                require "pages/dashboard.php";
                break;
            case 'manage-product': 
                require "pages/product/manage-product.php";
                break;
            case 'manage-product-add': 
                require "pages/product/manage-product-add.php";
                break;
            case 'manage-product-edit': 
                require "pages/product/manage-product-edit.php";
                break;
            case 'manage-users': 
                require "pages/users/manage-users.php";
                break;
            case 'manage-users-add': 
                $_SESSION["title"] = "Add New User";
                require "pages/users/manage-users-add.php";
                break;
            case "user_add":
                require "includes/users/user_add.php";
                break;
            case "user_edit":
                require "includes/users/user_edit.php";
                break;
            case "user_changepwd":
                require "includes/users/user_changepwd.php";
                break;
            case "user_delete":
                require "includes/users/user_delete.php";
                break;
            case 'manage-users-changepwd': 
                require "pages/users/manage-users-changepwd.php";
                break;
            case 'manage-users-edit': 
                require "pages/users/manage-users-edit.php";
                break;
            case "comments/add":
                require "includes/comments/add.php";
                break;
            case "comments/delete":
                require "includes/comments/delete.php";
                break;
            case 'cart_add':
                require 'includes/cart/cart_add.php';
                break;
            case 'cart_remove':
                require 'includes/cart/cart_remove.php';
                break;
            case 'checkout':
                require 'includes/cart/checkout.php';
                break;
            case 'orders':
                require 'pages/orders.php';
                break;
            case 'login':
                require "pages/login.php";
                break;
            case 'signup':
                require "pages/signup.php";
                break;
            case 'logout': 
                require "pages/logout.php";
                break;
            case 'product':
                require "pages/product.php";
                break;
            default:
                require 'pages/home.php';
                break;
        }