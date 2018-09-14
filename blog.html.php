<?php
$title = 'DCAN Blog';
$page_id = 'blog';
$body = 'index-7';
$description = 'At DCAN we are daily money managers governed internally by a strict set of ethical guidelines.';
include 'includes/helper.php';
include 'includes/blog-header.php';
?>

<!-- - - - - - - - -  content - - - - - - - - - -  -->

<section id="content">
    <div class="container">
        <div id="blog" style="margin-bottom: 30px; float:none;">
            <div class="row">
                
                <div class="col-md-12 col-sm-12">
                    
                    <header>
                        <h2 class="wow bounceInDown" data-wow-duration="1s" data-wow-delay="1s" data-wow-offset="10"><?php echo htmlspecialchars($title); ?></h2>
                    </header>
                    
                </div><!-- // .col-md-12  -->                 
                
                
                    
                <div class="col-md-9 col-sm-9">     

                    <p class="text-size90" style="margin:-11px 0px 5px 4px;color:#878787"><?php echo date('l'. ', j F Y'); ?></p>            

                    <?php include 'includes/post_content.inc.php'; 

                        if(isset($no_post_message)) {
                            echo '<div class="alert alert-warning text-center">';
                            echo '<h4 style="margin-bottom:0px;">' . htmlspecialchars($no_post_message) . '</h4>';
                            echo '</div>';
                        }
                    ?>

                </div><!-- // .col-md-9  -->
                

                <div class="col-md-3 col-sm-3">

                    <?php include 'includes/blog-sidebar-right.inc.php'; ?>

                </div><!--  //  .col-md-3  -->
                                

            </div>
        </div>
    </div>
</section>

<!-- - - - - - - - -  footer   - - - - - - - - - -->
<?php
include 'includes/footer.php';