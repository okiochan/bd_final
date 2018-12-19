<?php

class Users {
    public static function isLogged() {
        return !empty($_SESSION['user_logged']);
    }
    
    public static function whichUser() {
        return $_SESSION['user_logged'];
    }

    public static function loginUser($username) {
        $_SESSION['user_logged'] = $username;
    }

    public static function logoutUser() {
        unset($_SESSION['user_logged']);
    }
}
