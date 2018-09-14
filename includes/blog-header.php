<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo htmlspecialchars($title); ?></title>
		<meta charset="utf-8">
		<meta name = "format-detection" content = "telephone=no" />
                <meta name="description" content="<?php if(isset($description)){echo htmlspecialchars($description);}; ?>">
                <meta name="google-site-verification" content="FgUVJj80Z4eFurke2Hbz0xmS5PuE4JIFP0uBV1eAcHE" />
                
                <!--  Bootstrap  -->
                <!-- Latest compiled and minified CSS -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

                <!-- Optional theme -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

                <!-- Latest compiled and minified JavaScript -->
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
                <!--  // Bootstrap   -->
                
		<link rel="icon" href="images/dcan_fav.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/grid.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/animate.css">
		<link rel="stylesheet" href="css/owl.carousel.css">
                <link rel="stylesheet" href="css/bootstrap.css">
                <?php if(isset($body) && $body === 'index-4') echo '<link rel="stylesheet" href="css/contact-form.css">'; ?>
		<script src="js/jquery.js"></script>
		<script src="js/jquery-migrate-1.2.1.js"></script>
		<script src="js/script.js"></script>
		<script src="js/owl.carousel.js"></script>
                <script src="js/TMForm.js"></script>
		<script src="js/modal.js"></script>
		<script src='//maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false'></script>               
		<!--[if (gt IE 9)|!(IE)]><!-->
			<script src="js/wow.js"></script>
			<script>
				$(document).ready(function () {       
					if ($('html').hasClass('desktop')) {
						new WOW().init();
					}   
				});
			</script>
		<!--[if lt IE 8]>
			<div style=' clear: both; text-align:center; position: relative;'>
				<a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
					<img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
				</a>
			</div>
		<![endif]-->
		<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
		<![endif]-->
	</head>
        <body class="<?php echo htmlspecialchars($body); ?>">
<!-- ==============================header================================= -->
<header id="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav>
                        <ul class="sf-menu">
                            <li class="<?php if(isset($body) && $body === 'index') {echo ' current';} ?>"><a href="index.php">Home</a></li>
                            <li class="<?php if(isset($body) && $body === 'index-1') {echo ' current';} ?>"><a href="about.php">About Us</a>
                                <ul>
                                    <li><a href="code-of-ethics.php">Code of Ethics</a></li>
                                    <li><a href="testimonials.php">Testimonials</a></li>
                                    <li><a href="news.php">News</a></li>
                                </ul>
                            </li>
                            <li class="<?php if(isset($body) && $body === 'index-2') {echo ' current';} ?>"><a href="services.php">Services</a></li>
                            <li class="<?php if(isset($body) && $body === 'index-7') {echo ' current';} ?>"><a href="index.php?goto=blog">Blog</a></li>
                            <li class="<?php if(isset($body) && $body === 'index-4') echo ' current'; ?>"><a href="contact.php">Contacts</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    <!--
	<div class="container">
		<div class="block-2">
			<div class="row">
				<div class="col-md-12">
                                        <div class="col-md-5" style="background-color: #65abb4;">
                                                <div class="logotype">
                                                        <h1>
                                                            <a href="index.php">
                                                                    <!--<span class="logo">DCAN</span>-->
    <!--                                                                <span class="dcan_logo"><img src="images/logo_300x112.png" alt="DCAN logo"></span>
                                                                    <!--<span class="slogan">Dedicated Care Always Nearby</span>-->
    <!--                                                        </a>
                                                        </h1>
                                                        <h4 style="color:#803937;">We do the paperwork of Life!</h4>
                                                </div>
                                        </div>
				</div>
			</div>
		</div>
	</div>
     -->   
</header>