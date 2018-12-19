<?php
session_start();

define("MIN_PASS_LEN", 4);
define("DB_ADDR", "192.168.0.4");
define("DB_USER", "user");
define("DB_PASS", "123");
define("DB_NAME", "tmp");

require_once __DIR__ . "/DB.php";
require_once __DIR__ . "/Users.php";
require_once __DIR__ . "/RestoreDB.php";
require_once __DIR__ . "/CommentsDB.php";