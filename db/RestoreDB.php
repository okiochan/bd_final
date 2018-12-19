<?php
require_once __DIR__ . '/include.php';

class DBrestore{
//+
    function OpenCon() {
        // Create connection
        $conn = new mysqli(DB_ADDR, DB_USER, DB_PASS, DB_NAME);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
     
     return $conn;
     }
        
    public static function CheckSalt($username, $recieved_salt) {
        //OPEN
        $conn = self::OpenCon();

        $stmt = $conn->prepare('SELECT username,salt FROM users WHERE salt=?');
        $stmt->bind_param('s', $recieved_salt);
        $stmt -> execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        //CLOSE
        $conn->close();
        
        if($row == false){
            return false;
        }
        
        $good_username = $row['username'];
        if($username== $good_username) {
            return true;
        }
    }
     
}