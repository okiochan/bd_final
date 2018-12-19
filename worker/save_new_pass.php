<?php
require_once __DIR__ . "/../db/include.php";

$recieved_username = $_POST['username'];
$recieved_pass1 = $_POST['pass1'];
$recieved_pass2 = $_POST['pass2'];
$salt = DB::GenerateSalt();

print("sfsdfsdf");

if(DB::CheckUserExist($recieved_username) == false) {
    die("user_not_found");
}

if($recieved_pass1 !== $recieved_pass2) {
  die("pass_mismatch"); 
}

if( strlen($recieved_pass1) < MIN_PASS_LEN) {
    die("pass_too_short");
}

$res = DB::ChangePass($recieved_username, $recieved_pass1);
if ($res == true){
    echo ('success');
}else {
    echo('error');
}
