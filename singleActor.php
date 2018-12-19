<?php
require_once __DIR__ . '/db/include.php';

 $id_actor = "";
 // sanitization
    $id_actor = $_GET['id_act'];

    if (empty($id_actor)) {
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
				<h2 class="fh5co-heading1" >Info about actor</span></h2>
                <div class="row">
                <?php
                    function DisplayInfo($id_actor) {
                        $row = DB::GetActor($id_actor);
                        
                        if($row == false) {
                            print("GetActor false <br>");
                            die();
                        }
                         $format= ' 
                            <div class="col-md-12">
                            <figure><img src="actors/%s" class="img-responsive1"></figure>
                            <h3> Name: %s </h3>
                            <h3> Year: %s </h3>
                            <h3> Info: </h3> <h4> %s </h4>
                            </div>
                        ';
                        
                        printf($format, htmlspecialchars($row["img_path"]), htmlspecialchars($row["name"]), htmlspecialchars($row["year"]), htmlspecialchars($row["info"]) );
                        
                        $arr = DB::GetMovies($id_actor);
                        print(' <div class="col-md-12"> <h3> Movies : </h3>');
                        $format= '<h4><a href="%s">%s</a></h4>';
                        foreach( $arr as $row) {
                            $url = "singleMovie.php?id_mov=" . urlencode($row["id"]);
                            printf($format, htmlspecialchars($url), htmlspecialchars($row["name"]));
                        }
                        print("</div>");
                    }
                    //----------------------------------
                    DisplayInfo($id_actor);
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

