<?php
session_start();

define("MIN_PASS_LEN", 4);

require_once __DIR__ . "/DB.php";
require_once __DIR__ . "/Users.php";
require_once __DIR__ . "/RestoreDB.php";
require_once __DIR__ . "/CommentsDB.php";