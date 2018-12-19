<?php
require_once __DIR__ . '/db/include.php';

 $id_movie = "";
 // sanitization
    $id_movie = $_GET['id_mov'];
    
    print($id_movie);
    if (empty($id_movie)) {
        die();
    }
?>

<!DOCTYPE html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="hello" />

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,600,400italic,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="style/css/animate.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="style/css/owl.carousel.min.css">
	<link rel="stylesheet" href="style/css/owl.theme.default.min.css">
	<!-- Theme style  -->
	<link rel="stylesheet" href="style/css/style.css">

	<!-- Modernizr JS -->
	<script src="style/js/modernizr-2.6.2.min.js"></script>
    
    <script src='https://www.google.com/recaptcha/api.js'></script>
    
    <!-- Logic JS -->
    <script
      src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
    <script src='js/add_comment.js'></script>
	
	<!-- for comments -->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	</head>
	<body>

	<div id="fh5co-page">

		<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
		<aside id="fh5co-aside" role="complementary" class="border">

			<nav id="fh5co-main-menu" role="navigation">
				<ul>
                   <li><a href="actors.php">Actors</a></li>
                    <li><a href="movies.php">Movies</a></li>
                    <?php             
                        if (empty($_SESSION['user_logged'])) {
                            echo '
                            <br> <br>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                             ';
                            
                        } else {
                            echo '
                            <br> <br> <br> <br>
                             <li><a href="worker/logout.php">Logout</a></li>
                             ';
                        }
                    ?>
				</ul>
			</nav>

			<div class="fh5co-footer">
				<ul>
					<li><a href="#"><i class="icon-facebook"></i></a></li>
					<li><a href="#"><i class="icon-twitter"></i></a></li>
					<li><a href="#"><i class="icon-instagram"></i></a></li>
					<li><a href="#"><i class="icon-linkedin"></i></a></li>
				</ul>
			</div>

		</aside>

		<div id="fh5co-main1">
			<div class="fh5co-narrow-content1 animate-box " data-animate-effect="fadeInLeft">
				<h2 class="fh5co-heading1" >Info about movie</span></h2>
                <div>
                <?php
                    function DisplayInfo($id_movie) {
                        $row = DB::GetMovie($id_movie);
                        $rating = DB::GetMovieRating($id_movie);
                        
                        if($row == false) {
                            print("GetMovie false <br>");
                            die();
                        }
                         $format= ' 
                            <div class="col-md-12">
                            <figure><img src="movies/%s" class="img-responsive1"></figure>
                            <h3> Name: %s </h3>
                            <h3> Genre: %s </h3>
                            <h3> Year: %s </h3>
                            <h3> Rating: %s </h3>
                            <h3> Info: </h3> <h4> %s <h4> 
                            </div>
                        ';
                        
                        printf($format, htmlspecialchars($row["img_path"]), htmlspecialchars($row["name"]), 
                        htmlspecialchars($row["genre"]), htmlspecialchars($row["year"]), htmlspecialchars($rating), htmlspecialchars($row["info"]) );
                        
                        $arr = DB::GetActors($id_movie);
                        print(' <div class="col-md-12"> <h3> Actors : </h3>');
                        $format= '<h4><a href="%s">%s</a></h4>';
                        foreach($arr as $row) {
                            $url = "singleActor.php?id_act=" . urlencode($row["id"]);
                            printf($format, htmlspecialchars($url), htmlspecialchars($row["name"]));
                        }
                        print("</div>");
                        
                    }
                    //----------------------------------
                    DisplayInfo($id_movie);
                ?>  

                 <!--- Comment section -->
                <?php

                $comments = CommentsDB::GetComments($id_movie);
                echo '<div class="fh5co-narrow-content animate-box" data-animate-effect="fadeInLeft"><div >';
                foreach($comments as $com) {
                    echo
                    '<div class="col-md-8 comments">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>'. htmlspecialchars($com["username"]) .'</strong>
                            <span class="text-muted"> 
                                Rating: '.htmlspecialchars($com["rating"]).'
                                Commented at '. htmlspecialchars($com["time"]) .'
                            </span>
                        </div>
                    <div class="panel-body">
                    '. htmlspecialchars($com["text"]) .'
                    </div>
                    </div>
                    </div>';
                }
                echo '</div></div>';
                ?>
                
                <?php
                $is_logged = Users::isLogged();
                
                if($is_logged) {
                ?>
                    <form class="comment_form" action="" method="post">
                        <div >
                            <div class="col-md-12">
                                <div >	
                                    <div class="col-md-6 comments">
                                        <div class="form-group">
                                            <textarea name="text" id="message" cols="30" rows="7" class="form-control" placeholder="Message" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            
                                            <p><b>Rating</b></p>
                                            <select name="Rating">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            </select>
                                    
                                            <input type="submit" name="btn_submit" class="btn btn-primary btn-md comment_submit" value="Add comment">
                                            <input type="hidden" name="id_movie" value="<?php echo htmlspecialchars($id_movie); ?>">
                                            <input type="hidden" name="username" value="<?php echo htmlspecialchars(Users::whichUser()); ?>">
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6 comments">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <?php 
                } 
                ?>
                
                </div>

			</div>
		</div>

	<!-- jQuery -->
	<script src="style/js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="style/js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="style/js/bootstrap.min.js"></script>
	<!-- Carousel -->
	<script src="style/js/owl.carousel.min.js"></script>
	<!-- Stellar -->
	<script src="style/js/jquery.stellar.min.js"></script>
	<!-- Waypoints -->
	<script src="style/js/jquery.waypoints.min.js"></script>
	<!-- Counters -->
	<script src="style/js/jquery.countTo.js"></script>
	<!-- MAIN JS -->
	<script src="style/js/main.js"></script>

	</body>
</html>

