<?php
include '../includes/login-check.inc.php';
//echo '$_SERVER["PHP_SELF"] => ' . $_SERVER['PHP_SELF'] . '<br>';
//echo '$_SERVER["DOCUMENT_ROOT"] => ' . $_SERVER['DOCUMENT_ROOT'] . '<br>';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<div id="edit-post-form">
    <p class="red"><?php if(isset($errMsg)) htmlout($errMsg); ?></p>
    
    <form action="process-update-post.php" method="post" enctype="multipart/form-data">
        
        <?php foreach($posts as $post): ?>

        <div class="form-goup">
            <label for="post_title" class="col-sm-3 control-label">Post Title: </label>
            <div class="col-sm-9 p1">
                <input type="text" class="form-control" name="post_title" value="<?php if(isset($post['post_title'])) {echo $post['post_title'];} ?>">
            </div>
        </div>

        <?php
        
        // Check if on localhost or host server & connect to database
        if(isset($server) && $server != 'localhost'){
            include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
        } 
        else {
            include '../includes/dbconnect.php';
        }
        
        $table = 'categories';

        // Get selected post_category_id
        try {
            $sql = "SELECT * FROM $table
                    WHERE cat_id = :post_category_id";
            $s = $db->prepare($sql);
            $s->bindValue(':post_category_id', $post['post_category_id']);
            $s->execute();                                       

            // Store single row of results in $item array
            $item = $s->fetch(PDO::FETCH_ASSOC);                                      
        }
        catch (PDOException $e) {
            $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }


        // Get all category fields to display in select drop down
        try {
            $sql = "SELECT * FROM $table";
            $s = $db->prepare($sql);
            $s->execute();

            // Loop below not required. I don't know why. When used it produces double results
            // in drop-down, which appears to mean that the $categories array must already exist

            while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                $categories[] = array(
                    'cat_id' => $row['cat_id'],
                    'cat_title' => $row['cat_title']
                );
            }
        } 
        catch (PDOException $e) {
            $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }

        // Close database connection
        $db = null;

        ?>
         <div class="form-goup">
            <label for="post_category" class="col-sm-3 control-label">Post Category:</label>
            <div class="col-sm-9 p1">
                <select class="form-control" name="post_category_id">
                    <option value="<?php echo $item['cat_id']; ?>"><?php echo $item['cat_title']; ?></option>  
                    <?php foreach($categories as $category): ?>
                    <option value="<?php echo $category['cat_id'] ?>"><?php echo $category['cat_title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div> 
         </div>

        <div class="form-goup">
            <label for="post_author" class="col-sm-3 control-label">Post Author: </label>
            <div class="col-sm-9 p1">
                <input type="text" class="form-control" name="post_author" value="<?php if(isset($post['post_author'])) {echo $post['post_author'];} ?>">
            </div>
        </div>

        <div class="form-goup">
            <label for="post_keywords" class="col-sm-3 control-label">Post Keywords: </label>
            <div class="col-sm-9 p1">
                <input type="text" class="form-control" name="post_keywords" value="<?php if(isset($post['post_keywords'])) {echo $post['post_keywords'];} ?>">
            </div>
        </div>

        <div class="form-goup">
            <label for="post_image" class="col-sm-3 control-label">Post Image: </label>
            <div class="col-sm-9 p1">
                <input type="file" name="post_image">
                <br>
                <p>Current image:</p>
                <p><img style="padding:7px 0px 4px 0px;" src="../uploaded_post_images/<?php if(isset($post['post_image'])) {echo $post['post_image'];} ?>" width="110"></p>
            </div>
        </div>

        <div class="form-goup">
            <label for="post_content" class="col-sm-3 control-label">Post Content: </label>
            <div class="col-sm-9 p1">
                <textarea class="form-control" name="post_content" id="post_content" placeholder="Post Content"  rows="15"><?php if(isset($post['post_content'])) {echo $post['post_content'];} ?></textarea>
            </div>
        </div>

        <div class="col-sm-offset-3 col-sm-9">
            <input type="hidden" value="<?php echo $post['post_id']; ?>" name="post_id">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="update_post_content" title="MAKE SURE&#10;YOU SELECTED&#10;AN IMAGE">Update</button>
        </div>

        <?php endforeach; ?>
    </form>   
</div>