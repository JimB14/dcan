<?php
@session_start;
$title = 'Admin';
$server = htmlspecialchars($_SERVER['SERVER_NAME']);
$pageTitle = 'Content Editors';
$permission_level = 'content editors';
include '../includes/header.php';
include '../includes/helper.php';

/*
echo '$_SERVER["PHP_SELF"] => ' . $_SERVER['PHP_SELF'] . '<br>';
echo '$_SERVER["DOCUMENT_ROOT"] => ' . $_SERVER['DOCUMENT_ROOT'] . '<br>';
echo '$_SERVER["SERVER_NAME"] => ' . $_SERVER['SERVER_NAME'] . '<br>';
if($_SESSION['loggedIn']){echo 'Logged in';} else {'Not logged in';}
*/
?>

<div class="container-fluid">
    <div class="row p2">
        
        <div class="col-md-12">
            <p>
                <span class="blue pull-right"><?php echo date('M d, Y'); ?></span>
                <span class="glyphicon glyphicon-user text-size120"></span> &nbsp;<span class="blue"><?php if (isset($_SESSION['name'])) {htmlout($_SESSION['name']);} else {echo htmlout($_SESSION['email']);} ?>  -- Content Editor</span>
            </p>           
        </div><!-- // .col-md-12 -->
        

<!--        <div class="col-md-12">
            <h1 class=" well well-sm text-center text-center">
                <span class="text-capitalize">
                    <?php// if (isset($pageTitle)) {htmlout($pageTitle);} ?>
                </span>-->
                <!--<span style="display:block;margin-top: 0px; font-size: 12px;"><span class="red">* </span>Content Editors can add, delete and modify data.</span> -->
            <!--   </h1> -->
<!--        </div><!-- // .col-md-12 -->
        
        
        
        <div class="col-md-2 col-sm-2">
            <?php include '../includes/sidebar-left-content-editors.inc.php'; ?>
        </div>
                
        <div class="col-md-10 col-sm-10">
            
            <?php
            
            /* -- - - - - - - - - - - - - - - - - -  User clicks "New post"  - - - - - - - - - - - - - - - - - - */
                
                
                if (isset($_GET['goto']) && $_GET['goto'] === 'newpost') {

                    $page_title = 'Create new post';
                    
                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }
                      
                    // Assign queried table name to variable
                    $table = 'categories';

                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $categories[] = array(
                                'cat_id' => $row['cat_id'],
                                'cat_title' => $row['cat_title']
                            );
                        }
                    } catch (PDOException $e) {
                        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;                 

                    include 'add-new-post-form.html.php';
                    exit();
                }
                
                
                
                /* -- - - - - - - - - - - -  User clicks "View posts"    - - - - - - - - - - - - - - - - - */
                
                if (isset($_GET['goto']) && $_GET['goto'] === 'view_posts') {

                    $page_title = 'Posts';
                    $table = 'posts';

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }

                    try {
                        $sql = "SELECT * FROM $table
                                ORDER BY post_id DESC";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $posts[] = array(
                                'post_id' => $row['post_id'],
                                'post_category_id' => $row['post_category_id'],
                                'post_title' => $row['post_title'],
                                'post_date' => $row['post_date'],
                                'post_author' => $row['post_author'],
                                'post_keywords' => $row['post_keywords'],
                                'post_image' => $row['post_image'],
                                'post_content' => $row['post_content']
                            );
                        }
                        
                        if(isset($posts)){
                            $post_count = count($posts);
                        }
                        
                    } catch (PDOException $e) {
                        
                        $errMsg = 'Error fetching posts:' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }                   

                    // Close database connection
                    $db = null;

                    include 'view-posts.html.php';
                    exit();
                };
                
                
                
                /* -- - - - - - - - -  User clicks "Edit" button to edit Post   - - - - - - - - - - - - - */
                
                if (isset($_GET['edit_post'])){
                    
                    // Set variables
                    $page_title = 'Edit post';
                    $table = 'posts';
                    
                    // Retrieve post_id  value and store in $post_id variable
                    $post_id = sanitize($_GET['edit_post']);
                    
                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } 
                    else {
                        include '../includes/dbconnect.php';
                    }
                    
                    // Query database for post data of specified id
                    try {
                        $sql = "SELECT posts.post_id, posts.post_category_id, posts.post_title, posts.post_date, posts.post_author, posts.post_keywords, posts.post_image, posts.post_content, categories.cat_title
                                FROM $table
                                INNER JOIN categories
                                ON posts.post_category_id = categories.cat_id
                                WHERE post_id = :post_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':post_id', $post_id);
                        $s->execute();
                        
                        // Store results in $posts array
                        while ($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $posts[] = array(
                                'post_id' => $row['post_id'],  
                                'post_category_id' => $row['post_category_id'],
                                'post_title' => $row['post_title'],
                                'post_date' => $row['post_date'],
                                'post_author' => $row['post_author'],
                                'post_keywords' => $row['post_keywords'],
                                'post_image' => $row['post_image'],
                                'post_content' => $row['post_content'],
                                'cat_title' => $row['cat_title'],
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error fetching data: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Close database connection
                    $db = null;
                    
                    // Include form to display results for editing
                    include 'edit-post-form.html.php';
                    exit();
                } 
                
                
                
                /* - - - - - - - - - - - - - - - - - - -  Create new post category    - - - - - - - - - - - - - - - - - */
                
                if (isset($_GET['goto']) && $_GET['goto'] === 'create_category') {
                    
                    $page_title = 'Add new post category';
                    
                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }
                    
                    
                    $table = 'categories';

                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $categories[] = array(
                                'cat_id' => $row['cat_id'],
                                'cat_title' => $row['cat_title']
                            );
                        }
                    } catch (PDOException $e) {
                        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                    

                    include 'add-new-post-category-form.html.php';
                    exit();                   
                }
                
                
                
                
                /* - - - - - - - - - - - - - - - - - - -  View post categories   - - - - - - - - - - - - - - - - - */
                
                if (isset($_GET['goto']) && $_GET['goto'] === 'view_categories') {                   
                    
                    $page_title = 'Post Categories';
                    $table = 'categories';
                    
                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }                   
                    
                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

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
                  
                    include 'view-post-categories.html.php';
                    exit();
                }
                
                
                
                
                /* - - - - - - - - - - - - - - - - -  Edit Post Category    - - - - - - - - - - - - - - - - - - */
                
                if (isset($_GET['edit_category'])){

                    // Set variables
                    $page_title = 'Edit post category title (name)';
                    $table = 'categories';

                    // Retrieve post_id  value and store in $post_id variable
                    $cat_id = sanitize($_GET['edit_category']);

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }

                    // Query database for post data of specified id
                    try {
                        $sql = "SELECT * FROM $table
                                WHERE cat_id = :cat_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':cat_id', $cat_id);
                        $s->execute();

                        // Store results in $posts array
                        while ($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $categories[] = array(
                                'cat_id' => $row['cat_id'],  
                                'cat_title' => $row['cat_title']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error fetching data: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Include form to display results for editing
                    include 'edit-post-category-form.html.php';
                    exit();
                }
                
                
                
                
                
                
                /* - - - - - - - - - - - - - - - - - - -  View Post Comments   - - - - - - - - - - - - - - - - - - - */
                
                if (isset($_GET['goto']) && $_GET['goto'] === 'view_comments') {                   
                    
                    $page_title = 'Post Comments';
                    $table = 'comments';
                    
                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }                   
                    
                    try {
                        $sql = "SELECT * FROM $table ORDER BY comment_id DESC, post_id";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $comments[] = array(
                                'comment_id' => $row['comment_id'],
                                'post_id' => $row['post_id'],
                                'comment_date' => $row['comment_date'],
                                'comment_name' => $row['comment_name'],
                                'comment_email' => $row['comment_email'],
                                'comment_text' => substr($row['comment_text'], 0, 50),
                                'status' => $row['status']
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
                  
                    include 'view-post-comments.html.php';
                    exit();
                }
                
                
                
                /* - - - - - - - - - - - - - - - - - - -  Edit Post Comments    - - - - - - - - - - - - - - - - - - */
                
                if (isset($_GET['edit_comment'])){

                    // Set variables
                    $page_title = 'Edit post comments';
                    $table = 'comments';

                    // Retrieve post_id  value and store in $post_id variable
                    $comment_id = sanitize($_GET['edit_comment']);

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }

                    // Query database for post data of specified id
                    try {
                        $sql = "SELECT * FROM $table
                                WHERE comment_id = :comment_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':comment_id', $comment_id);
                        $s->execute();

                        // Store results in $posts array
                        while ($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $comments[] = array(
                                'comment_id' => $row['comment_id'],
                                'post_id' => $row['post_id'],  
                                'comment_date' => $row['comment_date'],
                                'comment_name' => $row['comment_name'],  
                                'comment_email' => $row['comment_email'],
                                'comment_text' => $row['comment_text'],  
                                'status' => $row['status']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error fetching data: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Include form to display results for editing
                    include 'edit-comments-form.html.php';
                    exit();
                } 
                
                
                
                /* - - - - - - - - - - - - - - - - - - -  Delete Post    - - - - - - - - - - - - - - - - - */

                if (isset($_GET['delete_post'])){

                    // Retrieve post_id and image values and store in variables
                    $post_id = htmlspecialchars($_GET['delete_post']); 
                    $image = htmlspecialchars($_GET['image']);

                    // Check if running locally or at host server
                    if(isset($server) && $server === 'localhost'){
                        // Execute if server is localhost (local server)
                        $image = $_SERVER['DOCUMENT_ROOT'].'/dcan.us/admin/uploaded_post_images/' . $image;
                    }
                    else {
                        // Execute if server is not localhost
                        $image = $_SERVER['DOCUMENT_ROOT'].'/admin/uploaded_post_images/' . $image;
                    }

                    /*
                    // Testing
                    echo '$image: ' . $image . '<br>';
                    echo '$server: ' . $server;
                    exit();
                    */

                    // Check if image and thumbnail exist; if true delete images
                    if(file_exists($image)){
                        unlink($image);
                    }

                    // Set variables
                    $table = 'posts';

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } 
                    else {
                        include '../includes/dbconnect.php';
                    }

                    // Query database for post data of specified id
                    try {
                        $sql = "DELETE FROM $table
                                WHERE post_id = :post_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':post_id', $post_id);
                        if($s->execute()){
                            echo "<script>alert('Post deleted!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_posts'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error deleting post: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit();   
                }
                
                
                
                
                /*-- - - - - - - - - - - - - - - - - -  Delete Category    - - - - - - - - - - - - - - - - - */

                if (isset($_GET['delete_category'])){

                    // Set variables
                    $table = 'categories';                  

                    // Retrieve post_id  value and store in $post_id variable
                    $cat_id = htmlspecialchars($_GET['delete_category']);                                     

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }

                    // Query database for post data of specified id
                    try {
                        $sql = "DELETE FROM $table
                                WHERE cat_id = :cat_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':cat_id', $cat_id);
                        if($s->execute()){
                            echo "<script>alert('Category deleted!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_categories'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error deleting category: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit();   
                }

               


                /*-- - - - - - - - - - - - - - - - - -  Delete Comment    - - - - - - - - - - - - - - - - - */

                if (isset($_GET['delete_comment'])){

                    // Set variables
                    $table = 'comments';                  

                    // Retrieve post_id  value and store in $post_id variable
                    $comment_id = htmlspecialchars($_GET['delete_comment']);                                     

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }

                    // Query database for post data of specified id
                    try {
                        $sql = "DELETE FROM $table
                                WHERE comment_id = :comment_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':comment_id', $comment_id);
                        if($s->execute()){
                            echo "<script>alert('Comment deleted!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_comments'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error deleting comment: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit();   
                }
                
                
                
                /*-- - - - - - - - - - - - - - - - - -  Unapprove Comment    - - - - - - - - - - - - - - - - - */

                if (isset($_GET['unapprove_comment'])){

                    // Set variables
                    $table = 'comments'; 
                    $status = 'unapprove';

                    // Retrieve post_id  value and store in $post_id variable 
                    $comment_id = htmlspecialchars($_GET['unapprove_comment']);                                     

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }

                    // Query database 
                    try {
                        $sql = "UPDATE $table SET
                                status = :status
                                WHERE comment_id = :comment_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':comment_id', $comment_id);
                        $s->bindValue(':status', $status);
                        if($s->execute()){
                            echo "<script>alert('Comment status changed to unapproved!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_comments'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error updating database: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit();     
                }


                /*-- - - - - - - - - - - - - - - - - -  Approve Comment    - - - - - - - - - - - - - - - - - */

                if (isset($_GET['approve_comment'])){

                    // Set variables
                    $table = 'comments'; 
                    $status = 'approved';

                    // Retrieve post_id  value and store in $post_id variable 
                    $comment_id = htmlspecialchars($_GET['approve_comment']);                                     

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include '../includes/dbconnect.php';
                    }

                    // Query database 
                    try {
                        $sql = "UPDATE $table SET
                                status = :status
                                WHERE comment_id = :comment_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':comment_id', $comment_id);
                        $s->bindValue(':status', $status);
                        if($s->execute()){
                            echo "<script>alert('Comment status changed to approved!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_comments'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error updating database: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit();     
                }
                
                
                
                
                ?>
            
            
        </div><!-- // .col-md-10  -->           

    </div><!-- // .row -->
</div><!-- // .container-fluid  -->