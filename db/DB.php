<?php

require_once __DIR__ . '/include.php';

class DB{

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
//-----------------------------MOVIES------------------------------------  
//+  
    function AddMovie($name, $year, $genre, $info, $img_path) {
        //OPEN
        $conn = self::OpenCon();
        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO movies (name, year, genre, img_path, info) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sdsss', $name, $year, $genre, $img_path, $info);
        $stmt -> execute();
        //CLOSE
        $conn->close();
    }
     
    function ReadMovies() {
        //OPEN
        $conn = self::OpenCon();
        $stmt = $conn->prepare('SELECT * FROM movies');
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
    
    function GetMovie($id_movie) {
        //OPEN
        $conn = self::OpenCon();
        $stmt = $conn->prepare('SELECT * FROM movies WHERE id = ?');
        $stmt->bind_param('i', $id_movie);
        $stmt -> execute();
        $res = $stmt->get_result();
        //CLOSE
        $conn->close();
        
        $row = $res->fetch_assoc();
        if($row == false){
            return false;
        }
        return $row;
    }
   
    function GetMovieRating($id_movie) {
        //OPEN
        $conn = self::OpenCon();
        $stmt = $conn->prepare('SELECT * FROM comments WHERE id_movie = ?');
        $stmt->bind_param('i', $id_movie);
        $stmt -> execute();
        $res = $stmt->get_result();
        //CLOSE
        $conn->close();
        
        $sum = 0; $cnt = 0;
        while ($row = $res->fetch_assoc()) {
            $sum += $row["rating"];
            $cnt ++;
        }
        
        if($cnt == 0) return 0;
        return $sum/$cnt;
    }
    
//-----------------------------ACTORS------------------------------------ 
//+   
    function AddActor($name, $year, $info, $img_path) {
        //OPEN
        $conn = self::OpenCon();
        // prepare and bind
        print("sdfsdf");
        $stmt = $conn->prepare("INSERT INTO actors (name, year, img_path, info) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sdss', $name, $year, $img_path, $info);
        $stmt -> execute();
        //CLOSE
        $conn->close();
    }
    
    function ReadActors() {
        //OPEN
        $conn = self::OpenCon();
        $stmt = $conn->prepare('SELECT * FROM actors');
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
    
  
    function GetActor($id_actor) {
        //OPEN
        $conn = self::OpenCon();
        $stmt = $conn->prepare('SELECT * FROM actors WHERE id = ?');
        $stmt->bind_param('i', $id_actor);
        $stmt -> execute();
        $res = $stmt->get_result();
        //CLOSE
        $conn->close();
        
        $row = $res->fetch_assoc();
        if($row == false){
            return false;
        }
        return $row;
    }
//------------------------------LINK-MOVIE-ACTOR------------------------

//+
    function InsertActorMovie($id_actor, $id_movie) {
        //OPEN
        $conn = self::OpenCon();
        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO link_movie_actor (idActor, idMovie) VALUES (?, ?)");
        $stmt->bind_param('ii', $id_actor, $id_movie);
        $stmt -> execute();
        //CLOSE
        $conn->close();
    }
//+    
    function GetActors($id_movie) {
        //OPEN
        $conn = self::OpenCon();
        $stmt = $conn->prepare('SELECT * FROM link_movie_actor WHERE idMovie = ?');
        $stmt->bind_param('i', $id_movie);
        $stmt -> execute();
        $res = $stmt->get_result();
        //CLOSE
        $conn->close();
        
        $ret = [];
        while ($row = $res->fetch_assoc()) {
            $ret[] = self::GetActor($row["idActor"]);
        }
        return $ret;
    }
    
//+    
    function GetMovies($id_actor) {
        //OPEN
        $conn = self::OpenCon();
        $stmt = $conn->prepare('SELECT * FROM link_movie_actor WHERE idActor = ?');
        $stmt->bind_param('i', $id_actor);
        $stmt -> execute();
        $res = $stmt->get_result();
        //CLOSE
        $conn->close();
        
        $ret = [];
        while ($row = $res->fetch_assoc()) {
            $ret[] = self::GetMovie($row["idMovie"]);
        }
        return $ret;
    }
    
//------------------------------WORK WITH USER------------------------

    private static function PassToHash($pass, $salt) {
        $res = hash('sha256',$pass.$salt);
        return $res;
    }
    
    public static function GenerateSalt() {
    $res ='';
    for($i=0; $i < 64; $i++) {
        $c = rand( ord('a'), ord('z') );
        $c = chr ($c);
        $res = $res.$c;
    }
    return $res;
    }


    public static function CheckUserExist($username) {
        //OPEN
        $conn = self::OpenCon();
        
        $stmt = $conn->prepare('SELECT username FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt -> execute();
        $res = $stmt->get_result();
        //CLOSE
        $conn->close();
        
        $row = $res->fetch_assoc();
        
        if($row == false){
            print("CheckUserExist false <br>");
            return false;
        }
        print("CheckUserExist true <br>");
        return true;
    }
    

    public static function CheckEmailExist($email) {
        //OPEN
        $conn = self::OpenCon();

        $stmt = $conn->prepare('SELECT email FROM users WHERE email = ?');
        $stmt -> bind_param('s',$email);
        $stmt -> execute();
        $res = $stmt->get_result();
        //CLOSE
        $conn->close();

        $row = $res->fetch_assoc();
        if($row == false){
            print("CheckEmailExist false <br>");
            return false;
        }
        print("CheckEmailExist true <br>");
        return true;
    }
    

    public static function AddUser($username, $pass, $email) {
        
        if( self::CheckUserExist($username) == true) {
            return 0;
        }
        if( self::CheckEmailExist($email) == true) {
            return -1;
        }
        
        $salt = self::GenerateSalt();
        $pass = self::PassToHash($pass, $salt);
        //OPEN
        $conn = self::OpenCon();
        
        $stmt = $conn->prepare('INSERT INTO users (username,password,salt,email) VALUES (?,?,?,?)');
        $stmt->bind_param('ssss', $username, $pass, $salt, $email);
        $stmt -> execute();
        //CLOSE
        $conn->close();
        print("AddUser true<br>");
        return 1;
    }
 

    public static function ChangePass($username, $newpass) {
        $salt = self::GenerateSalt();
        $pass = self::PassToHash($newpass, $salt);
        //OPEN
        $conn = self::OpenCon();
        
        $stmt = $conn->prepare('UPDATE users SET password = ? , salt = ? WHERE username = ?');
        $stmt->bind_param('sss', $username, $pass, $salt);
        $stmt -> execute();
       //CLOSE
        $conn->close();
        return true;
    }
    
        
    public static function CheckPass($username, $pass) {
        //OPEN
        $conn = self::OpenCon();
        
        $stmt = $conn->prepare('SELECT username,password,salt FROM users WHERE username=?');
        $stmt -> bind_param('s',$username);
        $stmt -> execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        //CLOSE
        $conn->close();
        
        if($row == false){
            return false;
        }
        $goodpass = $row['password'];
        $pass = self::PassToHash($pass, $row['salt']);
        if($goodpass == $pass) {
            return true;
        }
        return false;
    }
 

    public static function GetUsernameByEmail($email) {
        //OPEN
        $conn = self::OpenCon();
        
        $stmt = $conn->prepare('SELECT username FROM users WHERE email=?');
        $stmt -> bind_param('s',$email);
        $stmt -> execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        //CLOSE
        $conn->close();
        
        if($row == false){
            return -1;
        }
        return $row['username'];
    }
    
    public static function GetEmailByUsername($username) {
        //OPEN
        $conn = self::OpenCon();

        $stmt = $conn->prepare('SELECT email FROM users WHERE username=?');
        $stmt -> bind_param('s',$username);
        $stmt -> execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        //CLOSE
        $conn->close();
        
        if($row == false){
            return -1;
        }
        return $row['email'];
    }  
}