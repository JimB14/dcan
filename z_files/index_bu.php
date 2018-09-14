<?php
/*
 * site_administrators/index.php - Controller
 */
$server = $_SERVER['SERVER_NAME'];
require '../includes/access.inc.php';

// Check if user is logged in; if not display login form
if(!userIsLoggedIn())
{
    include '../login.html.php';
    exit();
}

// Check if logged in user has rights that link points to
if(!userHasRole('Site Administrator'))
{
    $error = 'Only Site Adminisrators may access this page.';
    include '../accessdenied.html.php';
    
    // Destroy session for user with credentials but no role
    session_destroy();
    exit();
}

// Send email when user with Content Provider role logs in
notify_login($_SESSION['email']);

// After SESSION['loggedIn'] === TRUE; include session timeout code for auto logout
//include '../includes/session_life.inc.php';




////////////////------   USER MANAGEMENT    -------//////////////////

/*-----------------------  DISPLAY USER (view only)  -------------------------------*/
if(isset($_GET['task']) && $_GET['task'] === "Display users") {
    
    echo '$_SERVER[\'DOCUMENT_ROOT\'] => ' . $_SERVER['DOCUMENT_ROOT'] . '<br>';
    echo '$_SERVER["PHP_SELF"] => ' . $_SERVER["PHP_SELF"] . '<br>';
    echo '$_SERVER[\'REQUEST_URI\'] => ' . $_SERVER['REQUEST_URI'];
    
    // Assign queried table name to variable
    $table = 'user';
    
    // Assign content for title tag
    $title = 'Admin';
    
    // Assign page title to variable
    $pageTitle = 'Users';
    
    // Connect to database
    include '../includes/dbconnect.php';
    
    try {
        $sql = "SELECT * FROM $table ORDER BY name";
        $result = $db->query($sql);
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $users[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => $row['password']
            );
        }     
    } 
    catch (PDOException $e) {
        $error = 'Error fetching data.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    // How to capture table fields in array; http://stackoverflow.com/questions/5428262/php-pdo-get-the-columns-name-of-a-table
    try {
        $sql2 = "DESCRIBE $table";
        $s2= $db->prepare($sql2);
        $s2->execute();
        $table_fields = $s2->fetchAll(PDO::FETCH_COLUMN);
    }
    catch (PDOException $e){
        $error = 'Error fetching data from database.';
        include 'error.html.php';
        exit();
    }
         
    include 'display-user.html.php';
    exit();
}


/* - - - - - - - - - - - - -  USER CLICKS Edit User link in sidebar  - - - - - - - - - - - - - */
if(isset($_GET['task']) && $_GET['task'] === 'Edit user') {   
    
    // Assign queried table name to variable
    $table = 'user';
    
    // Assign content for title tag
    $title = 'Admin';
    
    // Assign page title to variable
    $pageTitle = 'Edit users';
    
    // Connect to database
    include '../includes/dbconnect.php';
    
    try {
        $sql = "SELECT id, name, email, password, roleid FROM $table
               INNER JOIN userrole
               ON user.id = userrole.userid 
               ORDER BY name";        
        $result = $db->query($sql);
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $users[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => $row['password'],
            'roleid' => $row['roleid'],
            );
        }     
    } 
    catch (PDOException $e) {
        $error = 'Error fetching data.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    // How to capture table fields in array; http://stackoverflow.com/questions/5428262/php-pdo-get-the-columns-name-of-a-table
    try {
        $sql2 = "DESCRIBE $table";
        $s2= $db->prepare($sql2);
        $s2->execute();
        $table_fields = $s2->fetchAll(PDO::FETCH_COLUMN);
    }
    catch (PDOException $e){
        $error = 'Error fetching data from database.';
        include 'error.html.php';
        exit();
    }
         
    include 'edit-user.html.php';
    exit();     
}


/* - - - - - - - - -  USER CLICKS EDIT BUTTON IN USER DISPLAY TABLE  - - - - - - - - - - */
if(isset($_GET['action']) && $_GET['action'] === 'edit_user') {
              
    // Assign queried table name to variable
    $table = 'user';
    
    // Assign content for title tag
    $title = 'Admin';
    
    // Assign page title to variable
    $pageTitle = 'Edit user form';
    
    // Sanitize posted data
    $id = htmlspecialchars($_GET['id']);
    
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


/* - - - - - - - - - - - - - -  UPDATE USER   - - - - - - - - - - - - - - - */
if(isset($_POST['action']) && $_POST['action'] === 'update_user') {
    
    // Assign queried table name to variable
    $table = 'user';
    
    // Sanitize posted data
    $id = sanitize($_POST['id']);
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    
    // Connect to database
    include '../includes/dbconnect.php';
      
    try {
        $sql = "UPDATE $table SET
                name = :name,
                email = :email
                WHERE id = :id";
        $s = $db->prepare($sql);
        $s->bindValue(':id', $id);
        $s->bindValue(':name', $name);
        $s->bindValue(':email', $email);
        $s->execute();
        /*        
        if( $s->execute() ){
            echo "<script>alert('User successfully updated!')</script>";
            echo "<script>window.location.href = 'index.php?task=Display users'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
        } 
        */         
    } 
    catch (PDOException $e) {
        $error = 'Error updating user.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    // Close database connection to prepare to send email
    $db = null;
    
    // Return to previous page (the page that requested the current page) to view updated data
    header('Location: ' . htmlspecialchars($_SERVER['REQUEST_URI']));
    exit();
    
}


/*-----------------------  UPDATE USER PASSWORD   -------------------------------*/
if(isset($_POST['action']) && $_POST['action'] === "update_password") {
    
    // Assign queried table name to variable
    $table = 'user';
    
    // Sanitize posted data
    $id = sanitize($_POST['id']);
    $new_password = sanitize($_POST['new_password']);
    
    // Hash password
    $hash_password = password_hash($new_password, PASSWORD_DEFAULT);
   
    // Connect to database
    include '../includes/dbconnect.php';
      
    try {
        $sql = "UPDATE $table SET
                password = :password
                WHERE id = :id";
        $s = $db->prepare($sql);
        $s->bindValue(':password', $hash_password);
        $s->bindValue(':id', $id);
        if( $s->execute() ){
            $_SESSION['message'] = 'Password updated successfully!';
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


/*-----------------------  ASSIGN USER ROLE   -------------------------------*/
if(isset($_POST['action']) && $_POST['action'] === "assign_user_role") { 
    
    // Assign queried table name to variable
    $table = 'user';
    
    // Assign page title to variable
    $pageTitle = 'Assign user role form';
    
    // Sanitize posted data
    $id = sanitize($_POST['id']);
    $roleid = sanitize($_POST['roleid']);
    
    // Connect to database
    include '../includes/dbconnect.php';
      
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
    
    include 'assign-user-role-form.html.php';
    exit();
}



/*-----------------------  DISPLAY ADD USER FORM  -------------------------------*/
if(isset($_GET['task']) && $_GET['task'] === 'Add user') {
    
    // Assign content for title tag
    $title = 'Admin';
    
    // Assign page title to variable
    $pageTitle = 'Add new user';
        
    include 'add-user-form.html.php';
    exit();
}


/*-----------------------  ADD USER   -------------------------------*/
if(isset($_POST['action']) && $_POST['action'] === "add_user") {
    
    // Assign queried table name to variable
    $table = 'user';
    
    // Connect to database
    include '../includes/dbconnect.php';
    
    // Sanitize posted data
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    
    // Hash password
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
        
    try {
       $sql = "INSERT INTO $table SET
            name = :name,
            email = :email,
            password = :password";
        $s = $db->prepare($sql);
        $s->bindValue(':name', $name);
        $s->bindValue(':email', $email);
        $s->bindValue(':password', $hash_password);
        $s->execute(); 
    } 
    catch (PDOException $e) {
        $error = 'Error adding user.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    try {
        $sql = "SELECT * FROM $table";
        $result =$db->query($sql);       
                       
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
            );
        }
    }    
    catch (PDOException $e) {
        $error = 'Error adding user.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
        
    // Close database connection
    $db = null;

    // Return to previous page to view updated data
    header('Location: ' . '?task=Assign user role');
    exit();
}


/*-----------------------  DELETE USER   -------------------------------*/
if(isset($_POST['action']) && $_POST['action'] === "delete_user") {
       
    // Assign queried table name to variable
    $table = 'user';
    
    // Sanitize posted data
    $id = sanitize($_POST['id']);
    
    // Connect to database
    include '../includes/dbconnect.php';
    
    // Delete from userrole table
     try {
        $sql = "DELETE FROM userrole WHERE userid = :userid";
        $s = $db->prepare($sql);
        $s->bindValue(':userid', $id);
        $s->execute();
    }
    catch(PDOException $e) {
        $error = 'Error deleting user role from database.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    // Delete from user table
    try {
        $sql = "DELETE FROM $table WHERE id = :id";
        $s = $db->prepare($sql);
        $s->bindValue(':id', $id);
        $s->execute();
    } 
    catch (PDOException $e) {
        $error = 'Error deleting user.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    // Close database connection
    $db = null;

    // Return to previous page to view updated data
    header('Location: ' . htmlspecialchars($_SERVER['HTTP_REFERER']));
    exit();
}


/*----------------  DISPLAY USER ROLE(S)  ---------------------*/
if(isset($_GET['task']) && $_GET['task'] === 'Display user role') {
  
    // Assign queried table name to variable
    $table = 'user';
    
    // Assign page title to variable
    $pageTitle = 'User roles';
    
    // Connect to database
    include '../includes/dbconnect.php';
    
    try {
        $sql = "SELECT id, name, roleid FROM $table 
                INNER JOIN userrole
                ON id = userrole.userid
                ORDER BY name";
        $result = $db->query($sql);
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $users[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'roleid' => $row['roleid'],
            );
        }     
    } 
    catch (PDOException $e) {
        $error = 'Error fetching data.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
      
    include 'display-user-role.html.php';
    exit();     
}



/*-----------------------  DELETE USER ROLE   -------------------------------*/
if(isset($_POST['action']) && $_POST['action'] === "delete_user_role") {
    
    // Assign queried table name to variable
    $table = 'userrole';
    
    // Sanitize posted data
    $userid = sanitize($_POST['id']);
    $roleid = sanitize($_POST['roleid']);
    
    // Connect to database
    include '../includes/dbconnect.php';
    
    try {
        $sql = "DELETE FROM $table WHERE userid = :userid AND roleid = :roleid";
        $s = $db->prepare($sql);
        $s->bindValue(':userid', $userid);
        $s->bindValue(':roleid', $roleid);
        $s->execute();
    } 
    catch (PDOException $e) {
        $error = 'Error fetching data.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    // Close database connection
    $db = null;

    // Return to previous page to view updated data
    header('Location: ' . htmlspecialchars($_SERVER['HTTP_REFERER']));
    exit();   
}


/*-----------------------  ASSIGN USER ROLE   -------------------------------*/
if(isset($_GET['task']) && $_GET['task'] === 'Assign user role') {
    
    // Assign queried table name to variable
    $table = 'user';
    
    // Assign page title to variable
    $pageTitle = 'Assign user role'; 
    
    // Connect to database
    include '../includes/dbconnect.php';
    
    // Fetch names from user table for dropdown 
    try {
        $sql = "SELECT * FROM $table ORDER BY name";
        $result =$db->query($sql);       
                       
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
            );
        }
    }    
    catch (PDOException $e) {
        $error = 'Error adding user.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
       
    include 'assign-user-role-form.html.php';
    exit();
}


/*--------------------  INSERT USER ROLE INTO USERROLE   -------------------------------*/
if(isset($_POST['action']) && $_POST['action'] === "insert_into_userrole") {
        
    // Assign queried table name to variable
    $table = 'userrole';
    
    // Sanitize posted data
    $id = sanitize($_POST['user']);
    
    // Connect to database
    include '../includes/dbconnect.php';
    
    /* Insert multiple checkbox selections into MySQL database using foreach loop: See Kevin Yank "PHP and MySQL" p. 307 */
    // Execute the $sql for each element of the roles array as $role; this inserts the same userid for each roleid -> beautiful! 
    foreach($_POST['roles'] as $role) {       
        try {
            $sql = "INSERT INTO $table SET
                    userid = :userid,
                    roleid = :roleid";
            $s = $db->prepare($sql);
            $s->bindValue(':userid', $id);
            $s->bindValue(':roleid', $role);
            if( $s->execute() ){
            $_SESSION['message'] = 'Data updated successfully!';
        } else {
            $_SESSION['message'] = 'Error';
        } 
        } 
        catch (PDOException $e) {
            $error = 'Error assigning role to user.' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
    }
        
    // Close database connection to prepare to send email
    $db = null;
    
    header('Location: .');
    exit();
}
   
/*------------------------  DEFAULT  ------------------------*/

include 'main.html.php'; 