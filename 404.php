<?php
$title = 'Error';
$body = '';
$description = 'Error | DCAN';
include 'includes/header.php';
?>

<div class="container">
    <div class="row p1">
        <div class="col-sm-12">
            <header>
                <h2 class="wow bounceInDown" data-wow-duration="1s" data-wow-delay="1s" data-wow-offset="10"><?php echo htmlspecialchars($title); ?></h2>
            </header>
        </div>
    </div>
    <div class="row p2">        
        <div class="col-md-12 col-sm-12">           
            <div class="panel panel-default wow bounceInLeft" data-wow-duration="1s" data-wow-delay="1.5s" data-wow-offset="50" data-wow-iteration="1">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <h3>Oops! Sorry, page not found!</h3>

                    <h4 class="wow bounceInRight" data-wow-duration="1s" data-wow-delay="2s" data-wow-offset="10" data-wow-iteration="1">Please try again.</h4>
                </div>
            </div>   
        </div>
    </div>
</div> <!-- // container -->

<?php
include 'includes/footer.php';
?>