<?php
require_once __DIR__ . "/../db/include.php";

$recieved_username = $_POST['username'];
$recieved_pass1 = $_POST['pass1'];
$recieved_pass2 = $_POST['pass2'];
$recieved_salt = $_POST['salt'];

// error_log("hello".$recieved_username);

if(DB::dbCheckUserExist($recieved_username) == false) {
    die("user_not_found");
}

if( DBrestore::dbCheckSalt($recieved_username, $recieved_salt) == false) {
    die("salt_not_found");
}

if($recieved_pass1 !== $recieved_pass2) {
  die("pass_mismatch"); 
}

error_log("HELLO   ".strlen($recieved_pass1));

if( strlen($recieved_pass1) < MIN_PASS_LEN) {
    die("pass_too_short");
}

if( DBrestore::dbCheckSalt($recieved_username, $recieved_salt) == false) {
    die("salt_not_exist");
}

$res = DB::dbChangePass($recieved_username, $recieved_pass1);
if ($res == true){
    echo ('success');
}else {
    echo('error');
}
