<?php

/* -- - - - - - - - - - - - - - - - - -  Update post  - - - - - - - - - - - - - - - - - */

if (isset($_POST['action']) && $_POST['action'] === 'update_post_content') {

    // Include to access functions
    include '../includes/helper.php';  

    // Sanitize and post values
    $post_id = sanitize($_POST['post_id']);
    $post_category_id = sanitize($_POST['post_category_id']);
    $post_title = sanitize($_POST['post_title']);
    $post_author = sanitize($_POST['post_author']);
    $post_keywords = sanitize($_POST['post_keywords']);
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];
    $post_content = $_POST['post_content'];


    /* Test
    if(isset($post_category_id))echo '$post_category_id isset and = ' . $post_category_id . '<br>'; else echo ' !isset <br>';
    if(isset($post_title))      echo '$post_title isset and = ' . $post_title . '<br>';             else echo ' !isset <br>';
    if(isset($post_author))     echo '$post_author isset and = ' . $post_author . '<br>';           else echo ' !isset <br>';
    if(isset($post_keywords))   echo '$post_keywords isset and = ' . $post_keywords . '<br>';       else echo ' !isset <br>';
    if(isset($post_image))      echo '$post_image isset and = ' . $post_image . '<br>';             else echo ' !isset <br>';
    if(isset($post_image_tmp))  echo '$post_image_tmp isset and = ' . $post_image_tmp . '<br>';     else echo ' !isset <br>';
    if(isset($post_content))    echo '$post_content isset and = ' . $post_content . '<br>';         else echo ' !isset <br>';
    exit();
     */



    // Check if fields have input  
    if(empty($post_title) || empty($post_category_id) || empty($post_author) || empty($post_keywords) || empty($post_content) ){
        $errMsg = '*Please fill in all fields before submitting (make sure image is selected).';
        include '../includes/error.html.php';
        exit();
    } 
    
    // Check if post image was uploaded; if true, process, if false process differently
    if(!empty($_FILES['post_image']['tmp_name'])){

        // Move uploaded file to assigned folder (here "uploaded_images") http://php.net/manual/en/function.move-uploaded-file.php
        move_uploaded_file($post_image_tmp, "../uploaded_post_images/$post_image");

        // Set queried table name to variable
        $table = 'posts';

        // Check if on localhost or host server & connect to database
        if(isset($server) && $server != 'localhost'){
            include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
        } 
        else {
            include '../includes/dbconnect.php';
        }

        try {
            $sql = "UPDATE $table SET
               post_category_id = :post_category_id,
               post_title = :post_title,
               post_author = :post_author,
               post_keywords = :post_keywords,
               post_image = :post_image,
               post_content = :post_content
               WHERE post_id = :post_id";
           $s = $db->prepare($sql);
           $s->bindValue(':post_id', $post_id);
           $s->bindValue(':post_category_id', $post_category_id);
           $s->bindValue(':post_title', $post_title);
           $s->bindValue(':post_author', $post_author);
           $s->bindValue(':post_keywords', $post_keywords);
           $s->bindValue(':post_image', $post_image);
           $s->bindValue(':post_content', $post_content);
           if( $s->execute() ){
               echo "<script>alert('Post (with new image) successfully updated!')</script>";
               echo "<script>window.location.href = 'index.php?goto=view_posts'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
            } 
        }
        catch (PDOException $e) {
            $errMsg = 'Error updating database:' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }
    }
    else {
        
        // Set queried table name to variable
        $table = 'posts';

        // Check if on localhost or host server & connect to database
        if(isset($server) && $server != 'localhost'){
            include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
        } else {
            include '../includes/dbconnect.php';
        }

        try {
            $sql = "UPDATE $table SET
               post_category_id = :post_category_id,
               post_title = :post_title,
               post_author = :post_author,
               post_keywords = :post_keywords,
               post_content = :post_content
               WHERE post_id = :post_id";
           $s = $db->prepare($sql);
           $s->bindValue(':post_id', $post_id);
           $s->bindValue(':post_category_id', $post_category_id);
           $s->bindValue(':post_title', $post_title);
           $s->bindValue(':post_author', $post_author);
           $s->bindValue(':post_keywords', $post_keywords);
           $s->bindValue(':post_content', $post_content);
           if( $s->execute() ){
               echo "<script>alert('Post successfully updated!')</script>";
               echo "<script>window.location.href = 'index.php?goto=view_posts'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
            } 
        }
        catch (PDOException $e) {
            $errMsg = 'Error updating database:' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }
    }

        // Close database connection
        $db = null;

        // Exit
        exit(); 
}

