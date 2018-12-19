<?php
require_once __DIR__ . "/../db/include.php";

$recieved_login = $_POST['login'];

function restoreUser($username) {  

    $user = null;
    if( DB::CheckUserExist($username) ) {
        echo("$username");
    } else if( DB::CheckEmailExist($username) ) {
        $user = DB::GetUsernameByEmail($username);
        echo("$user");
    } else if( $user == null ) {
        echo('userNotFound');
        return;
    } else { 
        echo ('error');
        return;
    }
}

restoreUser($recieved_login);
 