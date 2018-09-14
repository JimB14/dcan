<?php
if(isset($posts)){
    foreach ($posts as $post){ 
$title = $post["cat_title"] . ' post';
$page_id = 'blog';
$body = 'index-7';
$description = 'Single post';
include 'includes/helper.php';
include 'includes/blog-header.php';
?>

<div class="container">
    <div class="row"> 

        <div class="col-md-12">
            
            <p style="letter-spacing: 3px; font-size: 36px; margin: 30px 0px;" class="text-center text-uppercase"><?php echo htmlspecialchars($title); ?><p>
            
            <div class="post-single">              
                    <h1 class="text-left" style="margin-bottom:15px;font-size: 22px;"><?php echo $post['post_title']; ?></h1>                    
                    <img class="img-responsive pull-left" src="admin/uploaded_post_images/<?php htmlout($post['post_image']); ?>">
                    <p style="padding-left:0px;margin-bottom:2px;color:#393939;">
                        <!--<span class="shadows-font">Category </span><span class="bold" style="color:#393939;"><?php // htmlout($post['cat_title']);  ?></span>-->
                        <span class="shadows-font">Posted by </span> <span class="bold" style="color:#393939;"><?php htmlout($post['post_author']); ?></span>&nbsp; 
                        <span class="shadows-font">On </span> <span class="bold" style="color:#393939;"><?php htmlout($post['post_date']); ?></span>
                        <span class="bold"> &nbsp;<?php if(isset($comment_count)) { echo '<span style="font-weight:normal;">Comments </span>' . '(<span style="color:#0000ff;">' . htmlspecialchars($comment_count) . '</span>)';} ?></span>
                    </p>
                    <br>
                    <p><?php echo $post['post_content']; ?> </p>
            </div>
            
            
                <!-- Nested columns -->
                <div class="col-md-12">
                    
                    <div style="padding-bottom: 30px;" class="comments-published">
                        <h2 style="padding-bottom:10px;"><?php if(isset($comment_count) && $comment_count < 1 ) {echo 'No Comments';} else {echo 'Comments';} ?> <span class="badge"><?php if(isset($comment_count)) {htmlout($comment_count);} ?></span></h2>

                        <?php if(isset($comment_count) && $comment_count > 0) foreach($comments as $comment): ?> 
                        <!-- Convert MySQL timestmp format into Month, Day, Year Hours:Minutes AM/PM:  http://stackoverflow.com/questions/5547252/convert-mysql-timestamp-into-actual-date-and-time -->
                        <p style="color:#aaa;"><i class="fa fa-user"></i> <span class="text-italic"><?php htmlout($comment['comment_name']); ?></span>&nbsp; on &nbsp;<span style="font-size:90%;"><?php echo date('M j Y g:i A', strtotime($comment['comment_date'])); ?></span></p>
                            <div class="comments-box"><?php echo $comment['comment_text']; ?></div>
                        <?php endforeach; ?>
                    </div><!--  // .comments-published  -->
                    
                </div>
                
                <!-- - - - - - - - - - - -  Leave a Comment  - - - - - - - - - - - - - - -->
                
                <div class="col-md-7">
                    <div class="comment-form">
                        <h3 class="p1">Leave a comment </h3>
                        <form class="p3" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
                            <div class="form-group">
                            <!--<label for="Name">Name</label>-->
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php if(isset($comment_name)) {htmlout($comment_name);} ?>" required>
                            </div>
                            <div class="form-group">
                                <!--<label for="email">Email</label>-->
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php if(isset($comment_email)) {htmlout($comment_email);} ?>" required>
                            </div>
                            <div class="form-group">
                                <!--<label for="comment">Comment</label>-->
                                <textarea class="form-control" rows="7" name="comment" id="comment" placeholder="Your comments"><?php if(isset($comment_text)) {htmlout($comment_text);} ?></textarea>
                            </div>
                            <input type="hidden" name="post_id" value="<?php htmlout($post['post_id']); ?>">
                            <button style="background-color: #65ABB4;" type="submit" class="btn btn-primary btn-block" name="action" value="submit_comment">Submit</button>            
                        </form>
                        <?php }
                            }?>
                    </div><!-- // .comment-box  -->
                </div><!--  // .col-md-7 -->                                             

        </div><!-- // .col-md-12  -->
        
        
    </div><!--  // .row  -->
</div><!-- // .container  -->

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56fad0667e200529"></script>


<?php include 'includes/footer.php';