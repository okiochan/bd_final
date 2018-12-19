<?php
require_once __DIR__ . '/db/include.php';
?>

<!DOCTYPE html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="photos" />

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
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="style/css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="style/css/bootstrap.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="style/css/owl.carousel.min.css">
	<link rel="stylesheet" href="style/css/owl.theme.default.min.css">
	<!-- Theme style  -->
	<link rel="stylesheet" href="style/css/style.css">

	<!-- Modernizr JS -->
	<script src="style/js/modernizr-2.6.2.min.js"></script>

	</head>
	<body>
	<div id="fh5co-page">
		<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
		<aside id="fh5co-aside" role="complementary" class="border js-fullheight">

			<nav id="fh5co-main-menu" role="navigation">
				<ul>
                    <li><a href="movies.php">Movies</a></li>
                    <li><a href="actors.php">Actors</a></li>
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

		<div id="fh5co-main">
            <h1> <center>all actors list</center> </h1>
        
			<div class="gallery">
                <?php
                    function DisplayImages() {
                    $ret = DB::ReadActors();
                    
                    $format= ' 
                                <a class="gallery-item" href="singleActor.php?id_act=%s">
                                <img src="actors/%s">
                                <span class="overlay">
                                    <h2> %s </h2>
                                    <span> more info </span>
                                </span>
                                </a> 
                                
                            ';
                                
                    foreach($ret as $row) {
                        printf($format, htmlspecialchars($row["id"]), htmlspecialchars($row["img_path"]), htmlspecialchars($row["name"]));
                        }
                    }
                
                //------------------------------
                DisplayImages();

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

