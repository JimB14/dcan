<?php
@session_start;
$title = 'Admin';
$server = htmlspecialchars($_SERVER['SERVER_NAME']);
$pageTitle = 'Content Providers';
$permission_level = 'content provider';
include '../includes/header.php';
include '../includes/helper.php';
?>

<div class="container-fluid">
    <div class="row p2">
        
        <div class="col-md-12">
            <p>
                <span class="blue pull-right"><?php echo date('M d, Y'); ?></span>
                <span class="glyphicon glyphicon-user text-size120"></span> &nbsp;<span class="blue"><?php if (isset($_SESSION['name'])) {htmlout($_SESSION['name']);} else {echo htmlout($_SESSION['email']);} ?>  -- Content Provider</span>
            </p>           
        </div><!-- // .col-md-12 -->
        

<!--        <div class="col-md-12">
            <h1 class=" well well-sm text-center text-center">
                <span class="text-capitalize">
                    <?php// if (isset($pageTitle)) {htmlout($pageTitle);} ?>
                </span>-->
                <!--<span style="display:block;margin-top: 0px; font-size: 12px;"><span class="red">* </span>Content Providers can add new data, but cannot delete or modify data.</span>--> 
<!--            </h1> -->
<!--        </div><!-- // .col-md-12 -->
        
        
        
        <div class="col-md-2 col-sm-2">
            <?php include '../includes/sidebar-left-content-providers.inc.php'; ?>
        </div>
                
        <div class="col-md-10 col-sm-10">
            
            <?php
            /* - - - - - - - - - - - - - - - - - Add new post to database  - - - - - - - - - - - - - - - -  */
                if (isset($_POST['action']) && $_POST['action'] === 'insert_post_content') {

                    include '../includes/helper.php';
                    $errMsg[] = array();

                    $post_category_id = sanitize($_POST['post_category_id']);
                    $post_title = sanitize($_POST['post_title']);
                    $post_date = date('m-d-Y');
                    $post_author = sanitize($_POST['post_author']);
                    $post_keywords = sanitize($_POST['post_keywords']);
                    $post_image = $_FILES['post_image']['name'];
                    $post_image_tmp = $_FILES['post_image']['tmp_name'];
                    $post_content = $_POST['post_content'];

                    /* testing posted variables
                    if(isset($post_category_id))echo '$post_category_id isset and = ' . $post_category_id . '<br>'; else echo ' !isset <br>';
                    if(isset($post_title))      echo '$post_title isset and = ' . $post_title . '<br>';             else echo ' !isset <br>';
                    if(isset($post_date))       echo '$post_date isset and = ' . $post_date . '<br>';               else echo ' !isset <br>';
                    if(isset($post_author))     echo '$post_author isset and = ' . $post_author . '<br>';           else echo ' !isset <br>';
                    if(isset($post_keywords))   echo '$post_keywords isset and = ' . $post_keywords . '<br>';       else echo ' !isset <br>';
                    if(isset($post_image))      echo '$post_image isset and = ' . $post_image . '<br>';             else echo ' !isset <br>';
                    if(isset($post_image_tmp))  echo '$post_image_tmp isset and = ' . $post_image_tmp . '<br>';     else echo ' !isset <br>';
                    if(isset($post_content))    echo '$post_content isset and = ' . $post_content . '<br>';         else echo ' !isset <br>';
                    */



                    // Check if fields have input  
                    if(!isset($post_title) || $post_title === '' || !isset($post_category_id) || $post_category_id === '' || !isset($post_author) || 
                        $post_author === '' || !isset($post_keywords) || $post_keywords === '' || !isset($post_content) || $post_content === '' ){

                        $errMsg = '*Please fill in all fields before submitting.';
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Check if post image was uploaded; if true, process, if false process differently
                    if(!empty($_FILES['post_image']['tmp_name'])){
                    
                        // Move uploaded file to assigned folder (here "uploaded_images") http://php.net/manual/en/function.move-uploaded-file.php
                        move_uploaded_file($post_image_tmp, "../uploaded_post_images/$post_image");
                        

                        // Check if on localhost or host server & connect to database
                        if(isset($server) && $server != 'localhost'){
                            include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                        } 
                        else {
                            include '../includes/dbconnect.php';
                        }
                        
                        $table = 'posts';

                        try {
                            $sql = "INSERT INTO $table SET
                                    post_category_id = :post_category_id,
                                    post_title = :post_title,
                                    post_date = :post_date,
                                    post_author = :post_author,
                                    post_keywords = :post_keywords,
                                    post_image = :post_image,
                                    post_content = :post_content";

                            $s = $db->prepare($sql);
                            $s->bindValue(':post_category_id', $post_category_id);
                            $s->bindValue(':post_title', $post_title);
                            $s->bindValue(':post_date', $post_date);
                            $s->bindValue(':post_author', $post_author);
                            $s->bindValue(':post_keywords', $post_keywords);
                            $s->bindValue(':post_image', $post_image);
                            $s->bindValue(':post_content', $post_content);
                            if( $s->execute() ){
                                echo "<script>alert('New post created!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_posts'</script>";

                                /*
                                echo "<div style='padding:30px; font-family:Arial;'>";
                                echo "<h2 style='color:red;'>New post published!</h2>";
                                echo "<p><a href='index.php?goto=newpost'>Add another post</a></p>";
                                echo "<p><a href='.'>Go to dashboard</a></p>";
                                echo "</div>"; 
                                */
                            } 
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }
                    }
                    else {
                        
                        // Check if on localhost or host server & connect to database
                        if(isset($server) && $server != 'localhost'){
                            include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                        } 
                        else {
                            include '../includes/dbconnect.php';
                        }
                        
                        $table = 'posts';

                        try {
                            $sql = "INSERT INTO $table SET
                                    post_category_id = :post_category_id,
                                    post_title = :post_title,
                                    post_date = :post_date,
                                    post_author = :post_author,
                                    post_keywords = :post_keywords,
                                    post_content = :post_content";

                            $s = $db->prepare($sql);
                            $s->bindValue(':post_category_id', $post_category_id);
                            $s->bindValue(':post_title', $post_title);
                            $s->bindValue(':post_date', $post_date);
                            $s->bindValue(':post_author', $post_author);
                            $s->bindValue(':post_keywords', $post_keywords);
                            $s->bindValue(':post_content', $post_content);
                            if( $s->execute() ){
                                echo "<script>alert('New post created (without an image)!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_posts'</script>";

                                /*
                                echo "<div style='padding:30px; font-family:Arial;'>";
                                echo "<h2 style='color:red;'>New post published!</h2>";
                                echo "<p><a href='index.php?goto=newpost'>Add another post</a></p>";
                                echo "<p><a href='.'>Go to dashboard</a></p>";
                                echo "</div>"; 
                                */
                            } 
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }
                        
                    }

                        // Close database connection
                        $db = null;

                        // End script
                        exit();                    
                }
                ?>
            
            <!-- - - - - - - - - - - - - - - - - -  Create New Post  - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'newpost') {

                    $page_title = 'Create new post';
                    
                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } 
                    else {
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

                    include 'add-new-post-form.html.php';
                    exit();
                }
                ?>
        
        </div>           

    </div><!-- // .row -->
</div>