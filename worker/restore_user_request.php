<?php
require_once __DIR__ . "/../db/include.php";

$recieved_login = $_POST['login'];

function restoreUser($username) {  

    $user = null;
    if( DB::dbCheckUserExist($username) ) {
        $user = $username;
    } else if( DB::dbCheckEmailExist($username) ) {
        $user = DB::dbGetUsernameByEmail($username);
    } else if( $user == null ) {
        echo('userNotFound');
        return;
    } else { 
        echo ('error');
        return;
    }
    
    $salt = DB::GenerateSalt();
    $email = DB::GetEmailByUsername($user);
    
    //how to add this to link in js?
   // "?username=".$user."&salt=".$salt;
}

restoreUser($recieved_login);
 