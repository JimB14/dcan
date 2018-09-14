<?php
include '../includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<div id="edit-comments-form">
                <p class="red"><?php if(isset($errMsg)) htmlout($errMsg); ?></p>
                <form class="form-horizontal" method="post">
                    <?php foreach($comments as $comment): ?>

                    <div class="form-goup">
                        <label for="post_id" class="col-sm-3 control-label">Post ID <small>(display only)</small>: </label>
                        <div class="col-sm-9 p1">
                            <input type="text" class="form-control" name="post_id" value="<?php if(isset($comment['post_id'])) {htmlout($comment['post_id']);} ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="form-goup">
                        <label for="comment_date" class="col-sm-3 control-label">Date <small>(display only)</small>: </label>
                        <div class="col-sm-9 p1">
                            <input type="text" class="form-control" name="comment_date" value="<?php if(isset($comment['comment_date'])) {htmlout($comment['comment_date']);} ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="form-goup">
                        <label for="comment_name" class="col-sm-3 control-label">Name: </label>
                        <div class="col-sm-9 p1">
                            <input type="text" class="form-control" name="comment_name" value="<?php if(isset($comment['comment_name'])) {htmlout($comment['comment_name']);} ?>">
                        </div>
                    </div>
                    
                    <div class="form-goup">
                        <label for="comment_email" class="col-sm-3 control-label">Email: </label>
                        <div class="col-sm-9 p1">
                            <input type="text" class="form-control" name="comment_email" value="<?php if(isset($comment['comment_email'])) {htmlout($comment['comment_email']);} ?>">
                        </div>
                    </div>
                        
                    <div class="form-goup">
                        <label for="comment_text" class="col-sm-3 control-label">Text: </label>
                        <div class="col-sm-9 p1">
                            <textarea class="form-control" name="comment_text" id="post_content" rows="15"><?php if(isset($comment['comment_text'])) {echo $comment['comment_text'];} ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-goup">
                        <label for="status" class="col-sm-3 control-label">Status: </label>
                        <div class="col-sm-9 p1">
                            <input type="text" class="form-control" name="status" value="<?php if(isset($comment['status'])) {htmlout($comment['status']);} ?>">
                        </div>
                    </div>

                    <div class="col-sm-offset-3 col-sm-9 p1">
                        <input type="hidden" name="comment_id" value="<?php htmlout($comment['comment_id']); ?>">
                        <button type="submit" class="btn btn-primary center-block p1"  name="action" value="update_comment" onclick="return confirm('Update comment now?');">Update</button>
                    </div>

        <?php endforeach; ?>
    </form>
</div><!-- // #edit-comments-form  -->        