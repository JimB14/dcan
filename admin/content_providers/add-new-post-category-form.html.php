<?php
include '../includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>


<div id="add-category-form"> 
    
    <form class="form-horizontal" method="post">

        <div class="form-goup">
            <label for="post_category" class="col-sm-3 control-label">Current categories:</label>
            <div class="col-sm-9 p1">
                <select class="form-control" name="post_category">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php htmlout($category['cat_id']) ?>"><?php htmlout($category['cat_title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-goup">
            <label for="new_post_category" class="col-sm-3 control-label">New category: </label>
            <div class="col-sm-9 p1">
                <input type="text" class="form-control" name="new_post_category" id="new_post_category" placeholder="Category name" required>
            </div>
        </div>

        <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="add_new_category">Add Category</button>
        </div>

    </form>
</div><!-- // #add-category-form  -->