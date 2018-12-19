<?php

require_once __DIR__ . "/../db/include.php";

function Result($code, $message) {
    echo json_encode([$code, $message]);
    die();
}

if (!Users::isLogged()) Result(1, "user not logged in");
if (empty($_POST['id_movie'])) Result(2, "no movie");
if (empty($_POST['text'])) Result(3, "no text");

$id_movie = $_POST['id_movie'];
$text = $_POST['text'];
$username = Users::whichUser();
$rating = 0;

try {
    CommentsDB::AddComment($id_movie, $username, $text, $rating); 
} catch (Exception $ex) {
    Result(11, "internal error");
}

Result(0, "Success");