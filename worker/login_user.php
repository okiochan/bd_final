<?php
require_once __DIR__ . "/../db/include.php";

$recieved_login = $_POST['login'];
$recieved_pass = $_POST['pass'];

function TryLogin($username, $pass) {  

    $user = null;
    if( DB::CheckUserExist($username) ) {
        $user = $username;
    } else if( DB::CheckEmailExist($username) ) {
        $user = DB::GetUsernameByEmail($username);
    } else if( $user == null ) {
        echo('userNotFound');
        return;
    } else { 
        echo ('error');
        return;
    }
    
    if( DB::CheckPass($user, $pass) == true) {
        if(Users::isLogged() == false) {
            echo('cookieDisabled');
        }
        Users::loginUser($user);
        echo ('success');
    } else {
        echo ('error');
    }
}

TryLogin($recieved_login, $recieved_pass);
 