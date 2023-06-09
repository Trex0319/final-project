<?php

    function connectToDB() {
        $database = new PDO(
            'mysql:host=devkinsta_db;dbname=Final_Project', 
            'root', 
            'r9wz9RSYYaTbjS7v'
        );
        return $database;
    }

    function isAdmin() {
        if ( isset( $_SESSION['user']['role'] ) && $_SESSION['user']['role'] === 'admin' ) {
            return true;
        } else {
            return false;
        }
    }

    function isEditor() {
        if ( isset( $_SESSION['user']['role'] ) && $_SESSION['user']['role'] === 'editor' ) {
            return true;
        } else {
            return false;
        }
    }

    function isUser() {
        if ( isset( $_SESSION['user']['role'] ) && $_SESSION['user']['role'] === 'user' ) {
            return true;
        } else {
            return false;
        }
    }

    function ofEditorAndAdmin(){
        return isAdmin() || isEditor() ? true : false;
    }

    function isUserLoggedIn(){
        return isUser() || isEditor() || isAdmin() ? true : false;
    }