<?php
include '../includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>


<div id="add-category-form"> 
    
    <form class="form-horizontal" method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <?php foreach($categories as $category): ?>
        <div class="form-goup">
            <label for="cat_id" class="col-sm-4 control-label">Category ID (display only): </label>
            <div class="col-sm-8 p1">
                <input type="text" class="form-control" name="cat_id" value="<?php if(isset($category['cat_id'])) {echo $category['cat_id'];} ?>" readonly>
            </div>
        </div>

        <div class="form-goup">
            <label for="cat_title" class="col-sm-4 control-label">Category Title: </label>
            <div class="col-sm-8 p1">
                <input type="text" class="form-control" name="cat_title" value="<?php if(isset($category['cat_title'])) {echo $category['cat_title'];} ?>">
            </div>
        </div>

        <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-primary p1"  name="action" value="update_category" onclick="return confirm('Update category title now?');">Update</button>
        </div>
        <?php endforeach; ?>
    </form>
</div><!-- // #add-category-form  -->                