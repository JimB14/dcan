<?php
$title = 'Blog';
$page_id = 'blog';
$body = 'blog';
$description = '';
include 'includes/helper.php';
include 'includes/blog-header.php';

/*
echo '<pre>';
print_r($posts);
echo '</pre>';

 if(is_array($post)){
 	echo 'Is array.';
 } else {
 	echo 'Not array';
 }
 */
?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<!--  Content   -->

<div class="container">
    <div class="row">

        <div class="col-md-9 col-sm-9">
        	
            <h1 style="letter-spacing: 10px;" class="text-center text-uppercase"><?php echo htmlspecialchars($title); ?></h1>

            <p class="text-size90" style="margin:-11px 0px 5px 4px;color:#878787"><?php echo date('l'. ', j F Y'); ?></p>            

            <?php include 'includes/post_content.inc.php'; 
            
                if(isset($no_post_message)) {
                    echo '<div class="alert alert-warning text-center">';
                    echo '<h4 style="margin-bottom:0px;">' . htmlspecialchars($no_post_message) . '</h4>';
                    echo '</div>';
                }
            ?>
            
        </div><!-- // .col-md-9  -->


        <div class="col-md-3 col-sm-3" style="margin-top:60px;">
        
            <?php include 'includes/blog-sidebar-right.inc.php'; ?>
                  
        </div><!--  //  .col-md-3  -->

    </div><!-- // .row  -->
</div><!--  //  .container  -->


<?php
include 'includes/footer.php';