<?php

// DATE TIME FORMAT: "Y-m-d\TH:i:sP" (DateTime::ATOM)
// TIME ZONE: UTC
require_once __DIR__ . "/include.php";

class CommentsDB {
    //+
    function OpenCon() {
        $servername = "localhost";
        $username = "root";
        $password = "123";
        $db = "tmp";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
     return $conn;
     }
    
    public function AddComment($id_movie, $username, $text, $rating){
        $time = (new DateTime())->format(DateTime::ATOM);
        //OPEN
        $conn = self::OpenCon();
        
        $stmt = $conn->prepare('INSERT INTO comments(id_movie,text,username,time,rating) VALUES (?,?,?,?,?)');
        $stmt->bind_param('sssss', $id_movie, $text, $username, $time, $rating );
        $stmt -> execute();
        //CLOSE
        $conn->close();
    }
    
    
    public function GetComments($id_movie) {
        //OPEN
        $conn = self::OpenCon();
        $stmt = $conn->prepare('SELECT * FROM comments WHERE id_movie = ?');
        $stmt->bind_param('s', $id_movie);
        $stmt -> execute();
        $res = $stmt->get_result();
        //CLOSE
        $conn->close();
        
        $ret = [];
        while ($row = $res->fetch_assoc()) {
            $ret[] = $row;
        }
        return $ret;
    }
     
}


// tests
// $dt = new DateTime();
// print($dt->format(DateTime::ATOM));
// CommentsDB::GetInstance();
// var_dump(CommentsDB::GetInstance());
// CommentsDB::GetInstance()->AddComment("Sergey","photo","user", "hello!!!");
// print_r(CommentsDB::GetInstance()->GetComments("Sergey","photo"));