<?php
/*
 * content_editors/index.php - Controller
 */
// Check if local or host server and store in variable
$server = htmlspecialchars($_SERVER['SERVER_NAME']);

require '../includes/access.inc.php';

// Check if user is logged in; if not display login form
if(!userIsLoggedIn())
{
    include '../login.html.php';
    exit();
}

// Check if logged in user has rights that link points to
if(!userHasRole('Content Editor'))
{
    $error = 'Only Content Editors may access this page.';
    
    include '../accessdenied.html.php';
    
    // Destroy session for user with credentials but no role
    session_destroy();
    exit();
}

// Send email when user with Content Provider role logs in
notify_login($_SESSION['email']);

// After SESSION['loggedIn'] === TRUE; include session timeout code for auto logout
//include '../includes/session_life.inc.php';



/* - - - - - - - - - - - - - - - - - Update post category  - - - - - - - - - - - - - - - - - */
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] === 'update_category') {

    //echo 'Success!'; exit();

    // Sanitize and post values
    $cat_id = htmlspecialchars($_GET['cat_id']);
    $cat_title = htmlspecialchars($_GET['cat_title']);

    // Check if fields have input  
    if(empty($cat_title)){
        $errMsg = '*Please fill in the category title field.';
        include 'includes/error.html.php';
        exit();
    } 
    else {

        // Set queried table name to variable
        $table = 'categories';

        // Check if on localhost or host server & connect to database
        if(isset($server) && $server != 'localhost'){
            include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
        } 
        else {
            include '../includes/dbconnect.php';
        }

        try {
            $sql = "UPDATE $table SET
                   cat_title = :cat_title
                   WHERE cat_id = :cat_id";
            $s = $db->prepare($sql);
            $s->bindValue(':cat_id', $cat_id);
            $s->bindValue(':cat_title', $cat_title);
            if( $s->execute() ){
                echo "<script>alert('Category title successfully updated!')</script>";
                echo "<script>window.location.href = 'index.php?goto=view_categories'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
            } 
        }
        catch (PDOException $e) {
            $errMsg = 'Error updating database:' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }

        // Close database connection
        $db = null;

        // Exit
        exit(); 
    }
}


/* - - - - - - - - - - - - - - - - -  Add new category  - - - - - - - - - - - - - - - - - */

if (isset($_POST['action']) && $_POST['action'] === 'add_new_category') {

    include '../includes/helper.php';
    $table = 'categories';

    // Sanitize and store user data in variable
    $new_category_name = sanitize($_POST['new_post_category']);

    // Check if on localhost or host server & connect to database
    if(isset($server) && $server != 'localhost'){
        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
    } 
    else {
        include '../includes/dbconnect.php';
    }

    // Insert new category into database
    try {
        $sql = "INSERT INTO $table SET
                cat_title = :cat_title";
        $s = $db->prepare($sql);
        $s->bindValue(':cat_title', $new_category_name);
        if($s->execute()){
            echo "<script>alert('New category added!')</script>";
            echo "<script>window.location.href = 'index.php?goto=view_categories'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
        }
    } 
    catch (PDOException $e) {
        $errMsg  = 'Error adding data to database: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Close database connection
    $db = null;

    // Exit
    exit();   
}



/* - - - - - - - - - - - - - - - - - Update comment  - - - - - - - - - - - - - - - - - */

if (isset($_POST['action']) && $_POST['action'] === 'update_comment') {

    // Include to access functions
    include '../includes/helper.php';  

    // Sanitize and post values
    $comment_id = sanitize($_POST['comment_id']);
    $post_id = sanitize($_POST['post_id']);
    $comment_date = sanitize($_POST['comment_date']);
    $comment_name = sanitize($_POST['comment_name']);
    $comment_email = sanitize($_POST['comment_email']);
    $comment_text = $_POST['comment_text'];
    $status = sanitize($_POST['status']);

    // Check if fields have input  
    if(empty($post_id) || empty($comment_date) || empty($comment_name)  || empty($comment_email) || empty($comment_text) || empty($status)){
        
        $errMsg = '*Please fill in all comment fields.';
        include 'includes/error.html.php';
        exit();
    } 
    else {

        // Set queried table name to variable
        $table = 'comments';

        // Check if on localhost or host server & connect to database
        if(isset($server) && $server != 'localhost'){
            include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
        } 
        else {
            include '../includes/dbconnect.php';
        }

        try {
            $sql = "UPDATE $table SET
                   post_id = :post_id,
                   comment_date = :comment_date,
                   comment_name = :comment_name,
                   comment_email = :comment_email,
                   comment_text = :comment_text,
                   status = :status
                   WHERE comment_id = :comment_id";
            $s = $db->prepare($sql);
            $s->bindValue(':comment_id', $comment_id);
            $s->bindValue(':post_id', $post_id);
            $s->bindValue(':comment_date', $comment_date);
            $s->bindValue(':comment_name', $comment_name);
            $s->bindValue(':comment_email', $comment_email);
            $s->bindValue(':comment_text', $comment_text);
            $s->bindValue(':status', $status);
            if( $s->execute() ){
                echo "<script>alert('Comment successfully updated!')</script>";
                echo "<script>window.location.href = 'index.php?goto=view_comments'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
            } 
        }
        catch (PDOException $e) {
            $errMsg = 'Error updating database:' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }

        // Close database connection
        $db = null;

        // Exit
        exit(); 
    }
}


   
/* - - - - - - - - - - - -   DEFAULT   - - - - - - - - - - - -  */

/* - - - - - - -   Get Count of Unapproved / Pending Comments (to display in sidebar menu)   - - - - - -  */
    // Set variables
    $table = 'comments'; 
    $status = 'unapproved';                               

    // Check if on localhost or host server & connect to database
        if(isset($server) && $server != 'localhost'){
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/dbconnect.php';
        } else {
            include '../includes/dbconnect.php';
        }

    // Query database 
    try {
        $sql = "SELECT * FROM $table
                WHERE status = :status";
        $s = $db->prepare($sql);
        $s->bindValue(':status', $status);
        $s->execute();
        
        // Get count of array elements
        $unapproved_count = $s->rowCount();
    } 
    catch (PDOException $e) {
        $errMsg  = 'Error updating database: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
            
    // Close database connection
    $db = null;  
    

// Display Reports form
include 'main.html.php';