<?php
$title = 'New address';
$description = 'New address.';
$body = 'index-1';
?>
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
                
                <script type="text/javascript">
                function poponload(){
                    //testwindow = window.open("new-address.php", "mywindow", "width=800, height=400");
                    //testwindow.moveTo(0,0);
                    //testwindow.document.write('<h1>We moved!</h1><h2>DCAN has a new address</h2><p>Please update your records.</p><p>3948 Sunbeam Rd Ste 8</p><p>Jacksonville, FL 32257</p>')
                }
                </script>
	</head>
        <!--<body onload="javascript: poponload()" class="<?php echo htmlspecialchars($body); ?>">-->
        <body class="<?php echo htmlspecialchars($body); ?>">
<!-- ==============================header================================= -->




<section id="content">
    <div class="container">
        <div class="block-3" style="margin-bottom: 30px;">
            <div class="row">
                <div class="grid_12">
                    <header class="text-center">
                        <p style="font-size:50px; margin-top:30px; margin-bottom: 30px; color:#ff0000;"><span>WE MOVED!</span></p>
                        <p style="font-size:32px;margin-bottom: 50px;">Please update your records</p>
                        <p style="font-size:46px;margin-bottom: 30px;">New address:</p>
                        <p style="font-size:32px;margin-bottom: 15px;">
                            DCAN
                        </p>
                        <p style="font-size:32px;margin-bottom: 15px;">
                            3948 Sunbeam Rd Ste 8
                        </p>
                        <p style="font-size:32px;margin-bottom: 15px;">
                            Jacksonville, FL 32257
                        </p>
                        <p style="font-size:32px;margin-bottom: 15px;">
                            904-607-7935 
                            <span style="display:block; margin-top:9px; margin-bottom:20px; font-size:18px">(same telephone)</span>
                        </p>
                        <button type="button" class="btn btn-info" onclick="window.close();">Close this window </button>
                    </header>
                </div>
            </div>
        </div>
    </div>
</section>