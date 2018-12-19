<?php
require_once __DIR__ . '/db/include.php';

$username = "alice";
$pass = "helloworld";
$email = "alice@mail.ru";

//DB::dbAddUser($username, $pass, $email);

$id_movie=3;

$comments = CommentsDB::GetComments($id_movie);
print_r($comments);

?>