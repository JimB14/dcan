<?php
include '../includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>
   
    <p class="red"><?php if (isset($errMsg)) {htmlout($errMsg);} ?></p>
    
<div id="new-post-form">  
    
    <form method="POST" class="form-horizontal" action="process-add-new-post.php"  enctype="multipart/form-data">

        <div class="form-goup">
            <label for="post_title" class="col-sm-2 control-label">Post Title: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="post_title" id="post_title" placeholder="Post Title" value="<?php if (isset($post_title)) {echo htmlspecialchars($post_title);} ?>" autofocus required>
            </div>
        </div>
        

        <div class="form-goup">
            <label for="post_category_id" class="col-sm-2 control-label">Post Category:</label>
            <div class="col-sm-10 p1">
                <select class="form-control" name="post_category_id">
                    <option value="">Select category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php htmlout($category['cat_id']) ?>"><?php htmlout($category['cat_title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        

        <div class="form-goup">
            <label for="post_author" class="col-sm-2 control-label">Post Author: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="post_author" id="post_author" placeholder="Post Author" value="<?php if (isset($_SESSION['name'])) echo htmlspecialchars($_SESSION['name']); ?>" required>
            </div>
        </div>
        

        <div class="form-goup">
            <label for="post_keywords" class="col-sm-2 control-label">Post Keywords: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="post_keywords" id="post_keywords" placeholder="Post Keywords" value="<?php if (isset($post_keywords)) echo htmlspecialchars($post_keywords); ?>" required>
            </div>
        </div>
        

        <div class="form-goup">
            <label for="post_image" class="col-sm-2 control-label">Post Image: </label>
            <div class="col-sm-10 p1">
                <input type="file" name="post_image" id="post_image">
            </div>
        </div>
        

        <div class="form-goup">
            <label for="post_content" class="col-sm-2 control-label">Post Content: </label>
            <div class="col-sm-10 p1">
                <textarea class="form-control" name="post_content" id="post_content" placeholder="Post Content"  rows="15"><?php if (isset($post_content)) echo htmlspecialchars($post_content); ?></textarea>
            </div>
        </div>
        

        <div class="col-sm-offset-2 col-sm-10 p1">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="insert_post_content">Publish Now</button>
        </div>       

    </form><!--  // .form  --> 
    
</div><!-- // #new-post-form  -->