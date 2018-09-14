<?php
$title = 'Search Results';
$page_id = 'blog';
$description = 'snippet here';
$body = 'index-7';
include 'includes/helper.php';
include 'includes/blog-header.php';
?>


<div class="container">
    <div class="row"> 

        <div class="col-md-9 col-sm-9">
            
            <h3 class="text-center" style="margin: 27px 0px;">Search results for <span style="color:#3b3bff;">&quot;<?php htmlout($_SESSION['search']); ?></span>&quot;</h3>

            <?php include 'includes/post_content.inc.php'; ?>

        </div><!-- // .col-md-9  -->


        <div class="col-md-3 col-sm-3" style="margin-top:60px;">

            <?php include 'includes/blog-sidebar-right.inc.php'; ?>

        </div><!-- // .col-md-3  -->

    </div><!-- // .row  -->
</div><!-- // .container -->


<!-- // end -->
<?php
include 'includes/footer.php';