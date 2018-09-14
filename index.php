<?php
session_start();

/* - - - - - - - - - - - - - - - User clicks Blog - - - - - - - - - - - - - - - - - - - -   */
if(isset($_GET['goto']) && $_GET['goto'] === 'blog'){    

    include 'includes/dbconnect.php';

    // Retrieve category titles for menu
    try{
        $sql = "SELECT * FROM categories";
        $s = $db->prepare($sql);
        $s->execute();
        
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
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



    // Retrieve posts for blog.html.php and order by RAND
    try {
        $sql = "SELECT post_id, post_category_id, post_title, post_date, post_author, post_keywords, post_image, post_content, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                ORDER BY post_date DESC";
        $s = $db->prepare($sql);
        $s->execute();
        
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $posts[] = array(
                'post_id' => $row['post_id'],  
                'post_category_id' => $row['post_category_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_keywords' => $row['post_keywords'],
                'post_image' => $row['post_image'],
                'post_content' => substr($row['post_content'], 0,240),  //http://php.net/manual/en/function.substr.php
                'cat_title' => $row['cat_title'],
            );
        } 
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }


    // Retrieve posts and order by most recent for sidebar
    try {
        $sql = "SELECT post_id, post_title, post_date, post_author, post_image, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                ORDER BY 1 DESC LIMIT 0,4";
        $s = $db->prepare($sql);
        $s->execute();
        
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $recent_posts[] = array(
                'post_id' => $row['post_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_image' => $row['post_image'],
                'cat_title' => $row['cat_title'],
            );
        } 
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    include 'blog.html.php';
    exit();
}


/* - - - - - - - - - - - - - - -  Search   - - - - - - - - - - - - - - - - - - - - */  
if(isset($_GET['action']) && $_GET['action'] === 'search'){
    
    // Connect to database
    include 'includes/dbconnect.php';
    
    // Retrieve category titles for menu
    try {
        $sql = "SELECT * FROM categories";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
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
     
    // Check if input box is empty
    if( empty($_GET['search_query']) ){
        
        $errMsg = 'Please enter data to search.';
        include 'includes/error.html.php';
        exit();       
    } 
    else { 
        
        // Sanitize user data
        $search = htmlspecialchars($_GET['search_query']);

        // Store $search content into $_SESSIONS['search'] for conditional logic use below in Add item conditional statement
        $_SESSION['search'] = $search;
        
        // Remove comment to test
        //echo '$search: ' . $search;
    }  
    
    // Query keywords entered into search box
    try {
        $sql = "SELECT post_id, post_category_id, post_title, post_date, post_author, post_keywords, post_image, post_content, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                WHERE post_content LIKE '%$search%'
                OR post_title LIKE '%$search%'
                OR post_author LIKE '%$search%'
                OR post_keywords LIKE '%$search'";     //"SELECT * FROM parts WHERE id LIKE %$search% OR description LIKE %$search% OR part_number LIKE %$search%";
        $s = $db->prepare($sql);
        $s->execute();
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching data' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
    
     if($s->rowCount() < 1){
            $errMsg = 'Sorry, no match found for: ' . $_SESSION['search'];
            include 'includes/error.html.php';
            exit();
    } 
    else {
                
        if($s->rowCount() > 0){
            while($row = $s->fetch(PDO::FETCH_ASSOC)){
                $posts[] = array(
                    'post_id' => $row['post_id'],  
                    'post_category_id' => $row['post_category_id'],
                    'post_title' => $row['post_title'],
                    'post_date' => $row['post_date'],
                    'post_author' => $row['post_author'],
                    'post_keywords' => $row['post_keywords'],
                    'post_image' => $row['post_image'],
                    'post_content' => substr($row['post_content'], 0,280),  //http://php.net/manual/en/function.substr.php
                    'cat_title' => $row['cat_title'],
                );
            }                
        }
    } 
    
     // Retrieve posts and order by most recent for sidebar
    try {
        $sql = "SELECT post_id, post_title, post_date, post_author, post_image, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                ORDER BY 1 DESC LIMIT 0,5";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $recent_posts[] = array(
                'post_id' => $row['post_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_image' => $row['post_image'],
                'cat_title' => $row['cat_title'],
            );
        }
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
    
    // Close database connection
    $db = null;
    
    include 'results.html.php';
    exit();
}



/*-------------------------  Submit comment    -------------------------------*/    

if(isset($_POST['action']) && $_POST['action'] === 'submit_comment'){
    
    // Must query database to populate category fields for menu in header.php;
    // this is required because if there's an error, error.html.php is included
    include 'includes/dbconnect.php';
    include 'includes/helper.php';
    
    // Retrieve category titles for menu
    try {
        $sql = "SELECT * FROM categories";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
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
    
    $post_id = sanitize($_POST['post_id']);
    $comment_name = sanitize($_POST['name']);
    $comment_email = sanitize($_POST['email']);
    $comment_text = strip_tags($_POST['comment']);
    $status = 'unapproved';
    
    // Validate user data
    if( empty($comment_name) ||  empty($comment_email) || empty($comment_text) ){
        $errMsg = 'Please fill in all fields.';
        include 'includes/error.html.php';
        exit();
    } 
    else {
     
        $table = 'comments'; 
        $location = 'index.php?getpost=' . $post_id;
        
        // Insert comments into database
        try {
            $sql = "INSERT INTO $table SET
                    post_id = :post_id,
                    comment_name = :comment_name,
                    comment_email = :comment_email,
                    comment_text = :comment_text,
                    status = :status";
            $s = $db->prepare($sql);
            $s->bindValue(':post_id', $post_id);
            $s->bindValue(':comment_name', $comment_name);
            $s->bindValue(':comment_email', $comment_email);
            $s->bindValue(':comment_text', $comment_text);
            $s->bindValue(':status', $status);
            if($s->execute()){
                echo "<script>alert('Your comment was submitted. It will be published pending approval.')</script>";
                echo "<script>window.location.href = '.'</script>";
            }
        } 
        catch (PDOException $e) {
            $errMsg = 'Error connecting to database: ' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }
                                  
        // Close database connection
        $db = null;

        // Exit
        exit();       
    }     
}

/*  - - - - - - - - - - View posts by Category - - - - - - - - - - - - - - - - - - - */

if(isset($_GET['cat_id'])){
    
    $post_category_id = htmlspecialchars($_GET['cat_id']);
    $_SESSION['category_id'] = $post_category_id;
    $table = 'posts';
    include 'includes/dbconnect.php';
    
    // Retrieve posts by category
    try {
        $sql = "SELECT post_id, post_category_id, post_title, post_date, post_author, post_keywords, post_image, post_content, cat_title
                FROM $table
                INNER JOIN categories
                ON post_category_id = cat_id
                WHERE post_category_id = :post_category_id ORDER BY post_date DESC";
        $s = $db->prepare($sql);
        $s->bindValue(':post_category_id',$post_category_id);
        $s->execute();
        
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $posts[] = array(
                'post_id' => $row['post_id'],  
                'post_category_id' => $row['post_category_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_keywords' => $row['post_keywords'],
                'post_image' => $row['post_image'],
                'post_content' => substr($row['post_content'],0,200),
                'cat_title' => $row['cat_title'],
            );
        }
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching post: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
    
    if(isset($posts)){
        $cat_post_count = count($posts);
    }
    
    // Retrieve category titles for menu
    try {
        $sql = "SELECT * FROM categories";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
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
    
    
    // Retrieve posts and order by most recent for sidebar
    try {
        $sql = "SELECT post_id, post_title, post_date, post_author, post_image, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                ORDER BY 1 DESC LIMIT 0,5";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $recent_posts[] = array(
                'post_id' => $row['post_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_image' => $row['post_image'],
                'cat_title' => $row['cat_title'],
            );
        }
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Close database connection
    $db = null;
    
    include 'category-post.html.php';
    exit();
}

/*------------------  View a single post  ----------------------*/

if(isset($_GET['getpost'])){
    
    $post_id = htmlspecialchars($_GET['getpost']);
    $table = 'posts';
    $status = 'approved'; // for use below
    include 'includes/dbconnect.php';
    
    try {
        $sql = "SELECT post_id, post_category_id, post_title, post_date, post_author, post_keywords, post_image, post_content, cat_title
                FROM $table
                INNER JOIN categories
                ON post_category_id = cat_id
                WHERE post_id = :post_id";
        $s = $db->prepare($sql);
        $s->bindValue(':post_id',$post_id);
        $s->execute();
        
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
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
        $errMsg = 'Error fetching post: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
    
    // Retrieve category titles for menu
    try {
        $sql = "SELECT * FROM categories";
        $s = $db->prepare($sql);
        $s->execute();
    
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
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
    
    
    // Retrieve posts and order by most recent for sidebar
    try {
        $sql = "SELECT post_id, post_title, post_date, post_author, post_image, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                ORDER BY 1 DESC LIMIT 0,5";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $recent_posts[] = array(
                'post_id' => $row['post_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_image' => $row['post_image'],
                'cat_title' => $row['cat_title'],
            );
        }
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
    
    // Display comments that are approved
    try {
        $sql = "SELECT * FROM comments
                WHERE post_id = :post_id AND status = :status
                ORDER BY comment_id DESC LIMIT 0,15";
        $s = $db->prepare($sql);
        $s->bindValue(':post_id', $post_id);
        $s->bindValue(':status', $status);
        $s->execute();
        
        // Declare comments array
        $comments = array();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $comments[] = array(
                'comment_id' => $row['comment_id'],
                'post_id' => $row['post_id'],
                'comment_date' => $row['comment_date'],
                'comment_name' => $row['comment_name'],
                'comment_email' => $row['comment_email'],
                'comment_text' => $row['comment_text'],
                'status' => $row['status'],
            );
        }
        // Check if there are any comments; if true, get count & store in variable $comment_count
        if(count($comments) > 0){
            $comment_count = count($comments);
        }
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
       
    // Close database connection
    $db = null;
    
    include 'single-post.html.php';
    exit();
}

/*  - - - - - - -  - - - - - -  DEFAULT   - - - - - - - - - - - - - - */


 
include 'main.html.php';