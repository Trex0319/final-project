<?php
    session_start();

       // Instruction: require all the files you need here. Tips: (includes/functions.php, includes/class-products.php)
       require "includes/class-products.php";
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
            case 'product_add': //condition
                require "includes/product/product_add.php";
                break;
            case 'dashboard': //condition
                require "pages/dashboard.php";
                break;
            case 'manage-product': //condition
                require "pages/product/manage-product.php";
                break;
            case 'manage-product-add': //condition
                require "pages/product/manage-product-add.php";
                break;
            case 'manage-product-edit': //condition
                require "pages/product/manage-product-edit.php";
                break;
            case 'login':
                require "pages/login.php";
                break;
            case 'signup':
                require "pages/signup.php";
                break;
            case 'logout': //condition
                require "pages/logout.php";
                break;
            case 'product':
                require "pages/product.php";
                break;
            default:
                require 'pages/home.php';
                break;
        }