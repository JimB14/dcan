<?php

/* - - - - - - - - -  USER CLICKS EDIT BUTTON IN USER DISPLAY TABLE  - - - - - - - - - - */
if(isset($_POST['action']) && $_POST['action'] === "edit_user") {
    
    echo 'Success!';
    exit();
        
    // Assign queried table name to variable
    $table = 'user';
    
    // Assign page title to variable
    $pageTitle = 'Edit user form';
    
    // Sanitize posted data
    $id = htmlspecialchars($_POST['id']);
    
    // Check if on localhost or host server & connect to database
    if(isset($server) && $server != 'localhost'){
        include $_SERVER['DOCUMENT_ROOT'] . 'admin/includes/dbconnect.php';
    } else {
        include '../includes/dbconnect.php';
    }
    
    try {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $s = $db->prepare($sql);
        $s->bindValue(':id', $id);
        $s->execute();          
    } 
    catch (PDOException $e) {
        $error = 'Error fetching data.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    // Store single row result in $item associative array
    $user = $s->fetch(PDO::FETCH_ASSOC);  
    
    // Close database connection to prepare to send email
    $db = null;
            
    include 'edit-user-form.html.php';
    exit();
}




/* - - - - - - - - - - - - -  UPDATE USER   - - - - - - - - - - - - - */
if(isset($_POST['action']) && $_POST['action'] === 'update_user') {
    
    var_dump($_POST);
    
    // Assign queried table name to variable
    $table = 'user';
    
    // Sanitize posted data
    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    
    // Check if on localhost or host server & connect to database
    if(isset($server) && $server != 'localhost'){
        include $_SERVER['DOCUMENT_ROOT'] . 'admin/includes/dbconnect.php';
    } else {
        include 'dbconnect.php';
    }
      
    try {
        $sql = "UPDATE $table SET
                name = :name,
                email = :email
                WHERE id = :id";
        $s = $db->prepare($sql);
        $s->bindValue(':id', $id);
        $s->bindValue(':name', $name);
        $s->bindValue(':email', $email);
        if( $s->execute() ){
            $_SESSION['message'] = 'Data updated successfully!';
        } else {
            $_SESSION['message'] = 'Error';
        }           
    } 
    catch (PDOException $e) {
        $error = 'Error updating user.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    // Close database connection to prepare to send email
    $db = null;
    
    // Return to previous page to view updated data
    header('Location: ' . htmlspecialchars($_SERVER['REQUEST_URI']));
    exit();
    
}