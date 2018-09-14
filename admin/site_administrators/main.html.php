<?php
@session_start;
$pageTitle = 'Site Administrator';
$title = 'Admin';
$server = htmlspecialchars($_SERVER['SERVER_NAME']);
$permission_level = 'site administrators';
include '../includes/header.php';
include '../includes/helper.php';
?>

<div class="container-fluid">
    <div class="row p2">
                
        <div class="col-md-12">
            <p>
                <span class="blue pull-right"><?php echo date('M d, Y'); ?></span>
                <span class="glyphicon glyphicon-user text-size120"></span> &nbsp;<span class="blue"><?php if (isset($_SESSION['name'])) {htmlout($_SESSION['name']);} else {echo htmlout($_SESSION['email']);} ?> -- Site Administrator</span>
            </p>           
        </div><!-- // .col-md-12 -->
        
        
        
<!--        <div class="col-md-12">
            <h1 class=" well well-sm text-center text-center">
                <span class="text-capitalize">
                    <?php// if (isset($pageTitle)) {htmlout($pageTitle);} ?>
                </span>
                <!--<span style="display:block;margin-top: 0px; font-size: 12px;"><span class="red">* </span>Site Administrators can manage User data.</span>--> 
 <!--           </h1>-->
<!--        </div><!-- // .col-md-12 -->
        
        
        <div class="col-md-2 col-sm-2">
            
            <?php include '../includes/site-administrators-side-margin-left.php'; ?>
            
        </div>


        <div class="col-md-10 col-sm-10">


            <?php
                ////////////////------   USER MANAGEMENT    -------//////////////////
            
                /* - - - - - - - - - -  DISPLAY USER (view only)  - - - - - - - - - - */
                if(isset($_GET['task']) && $_GET['task'] === "Display users") {

                    //echo '$_SERVER["DOCUMENT_ROOT"] => ' . $_SERVER['DOCUMENT_ROOT'] . '<br>';

                    // Assign queried table name to variable
                    $table = 'user';

                    // Assign page title to variable
                    $page_title = 'Users';

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include 'dbconnect.php';
                    }

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

                    // Close database connection to prepare to send email
                    $db = null;

                    include 'display-user.html.php';
                    exit();
                }
                
                
                /* - - - - - - - - - -  USER CLICKS Edit User link in sidebar  - - - - - - - - - - */
                if(isset($_GET['task']) && $_GET['task'] === 'Edit user') {  

                    // Assign queried table name to variable
                    $table = 'user';

                    // Assign content for title tag
                    $title = 'Admin';

                    // Assign page title to variable
                    $page_title = 'Edit user role';

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include 'dbconnect.php';
                    }

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

                    include 'edit-user-role.html.php';
                    exit();     
                }


                /* - - - - - - - - - -  USER CLICKS EDIT BUTTON IN USER DISPLAY TABLE  - - - - - - - - - - */
                if(isset($_GET['action']) && $_GET['action'] === 'edit_user') {

                    //var_dump($_GET);

                    // Assign queried table name to variable
                    $table = 'user';

                    // Assign page title to variable
                    $page_title = 'Edit user form';

                    // Sanitize posted data
                    $id = htmlspecialchars($_GET['id']);

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include 'dbconnect.php';
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

                    /*
                    echo '<pre>';
                    print_r($user);
                    echo '</pre>';
                    */

                    // Close database connection to prepare to send email
                    $db = null;

                    include 'edit-user-form.html.php';
                    exit();
                }


                /* - - - - - - - - - - - - -  UPDATE USER   - - - - - - - - - - - - - */
                if(isset($_GET['action']) && $_GET['action'] === 'update_user') {

                    var_dump($_GET);
                    //exit();

                    // Assign queried table name to variable
                    $table = 'user';

                    // Sanitize posted data
                    $id = htmlspecialchars($_GET['id']);
                    $name = htmlspecialchars($_GET['name']);
                    $email = htmlspecialchars($_GET['email']);

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
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
                    header('Location:  ?task=Display users');
                    exit();

                }


                /* - - - - - - - - - -  UPDATE USER PASSWORD   - - - - - - - - - - */
                if(isset($_GET['action']) && $_GET['action'] === "update_password") {

                    // Assign queried table name to variable
                    $table = 'user';

                    // Sanitize posted data
                    $id = htmlspecialchars($_GET['id']);
                    $new_password = htmlspecialchars($_GET['new_password']);

                    /*
                    echo '$id => ' . $id . '<br>';
                    echo '$new_password => ' . $new_password . '<br>';
                    exit();
                    */

                    // Hash password
                    $hash_password = password_hash($new_password, PASSWORD_DEFAULT);

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include 'dbconnect.php';
                    }

                    try {
                        $sql = "UPDATE $table SET
                                password = :password
                                WHERE id = :id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':password', $hash_password);
                        $s->bindValue(':id', $id);
                        $s->execute();
                    } 
                    catch (PDOException $e) {
                        $error = 'Error updating user.' . $e->getMessage();
                        include 'error.html.php';
                        exit();
                    }

                    // Close database connection to prepare to send email
                    $db = null;

                    // Return to previous page to view updated data
                    header('Location: ?task=Display users');
                    exit();

                }


                /* - - - - - - - - - -  ASSIGN USER ROLE    - - - - - - - - - - */
                if(isset($_POST['action']) && $_POST['action'] === "assign_user_role") { 

                    // Assign queried table name to variable
                    $table = 'user';

                    // Assign page title to variable
                    $page_title = 'Assign user role form';

                    // Sanitize posted data
                    $id = sanitize($_POST['id']);
                    $roleid = sanitize($_POST['roleid']);

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include 'dbconnect.php';
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

                    include 'assign-user-role-form.html.php';
                    exit();
                }



                /*  - - - - - - - - - -  DISPLAY ADD USER FORM   - - - - - - - - - - */
                if(isset($_GET['task']) && $_GET['task'] === 'Add user') {

                    // Assign value for title tag
                    $title = 'Admin';

                    // Assign page title to variable
                    $page_title = 'Add new user';

                    include 'add-user-form.html.php';
                    exit();
                }


                /*  - - - - - - - - - -  ADD USER    - - - - - - - - - - */
                if(isset($_GET['action']) && $_GET['action'] === "add_user") {

                    // Assign queried table name to variable
                    $table = 'user';

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include 'dbconnect.php';
                    }

                    // Sanitize posted data
                    $name = htmlspecialchars($_GET['name']);
                    $email = htmlspecialchars($_GET['email']);
                    $password = htmlspecialchars($_GET['password']);

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


                /*  - - - - - - - - - -  DELETE USER    - - - - - - - - - -  */
                if(isset($_GET['action']) && $_GET['action'] === "delete_user") {

                    // Assign queried table name to variable
                    $table = 'user';

                    // Sanitize posted data
                    $id = htmlspecialchars($_GET['id']);

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include 'dbconnect.php';
                    }

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
                    header('Location: ?task=Display users');
                    exit();
                }


                /*  - - - - - - - - - -  DISPLAY USER ROLE(S)   - - - - - - - - - - */
                if(isset($_GET['task']) && $_GET['task'] === 'Display user role') {

                    // Assign value for title tag
                    $title = 'Admin';

                    // Assign queried table name to variable
                    $table = 'user';

                    // Assign page title to variable
                    $page_title = 'User roles';

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include 'dbconnect.php';
                    }

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



                /*  - - - - - - - - - -  DELETE USER ROLE    - - - - - - - - - - */
                if(isset($_GET['action']) && $_GET['action'] === "delete_user_role") {

                    // Assign queried table name to variable
                    $table = 'userrole';

                    // Sanitize posted data
                    $userid = htmlspecialchars($_GET['id']);
                    $roleid = htmlspecialchars($_GET['roleid']);

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include 'dbconnect.php';
                    }

                    try {
                        $sql = "DELETE FROM $table WHERE userid = :userid AND roleid = :roleid";
                        $s = $db->prepare($sql);
                        $s->bindValue(':userid', $userid);
                        $s->bindValue(':roleid', $roleid);
                        $s->execute();
                    } 
                    catch (PDOException $e) {
                        $error = 'Error fetching user data.' . $e->getMessage();
                        include 'error.html.php';
                        exit();
                    }

                    // After deleting user role, check if user has any roles. If not, delete user from user table
                    try {
                        $sql = "SELECT * FROM userrole
                                WHERE userid = :userid";
                        $s = $db->prepare($sql);
                        $s->bindValue(':userid', $userid);
                        $s->execute();

                        // Store array in variable
                        $result = $s->fetchALL(PDO::FETCH_OBJ);

                        // Get count of array elements and store in variable
                        $count = count($result);

                        if( $count < 1 ){
                            try {
                                $sql = "DELETE FROM user WHERE id = :id";
                                $s = $db->prepare($sql);
                                $s->bindValue(':id', $userid);
                                $s->execute();             
                            } 
                            catch (Exception $ex) {
                                $error = 'Error fetching user data.' . $e->getMessage();
                                include 'error.html.php';
                                exit();
                            }
                        }       
                    } 
                    catch (PDOException $e) {
                        $error = 'Error fetching user data.' . $e->getMessage();
                        include 'error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Return to previous page to view updated data
                    header('Location: ?task=Display users');
                    exit();   
                }


                /*  - - - - - - - - - -  ASSIGN USER ROLE (user clicks "Assign user role" in left sidebar)   - - - - - - - - - - */
                if(isset($_GET['task']) && $_GET['task'] === 'Assign user role') {

                    // Assign queried table name to variable
                    $table = 'user';

                    // Assign value for title tag
                    $title = 'Admin';

                    // Assign page title to variable
                    $page_title = 'Assign user role'; 

                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } else {
                        include 'dbconnect.php';
                    }

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


                /*  - - - - - - - - - -  INSERT USER ROLE INTO USERROLE (user clicks "Submit" in Assign User Role form)   - - - - - - - - - - */
                if(isset($_GET['action']) && $_GET['action'] === "insert_into_userrole") {  

                    if(empty($_GET['user'])){
                        $error = "Error detected: No user selected. Please select a user.";
                        include '../includes/error.html.php';
                        exit();
                    }

                    // Check if role or roles selected 
                    if(empty($_GET['roles'])){
                        $error = 'Error detected: no role selected. Please select at least one role.';
                        include '../includes/error.html.php';
                        exit();
                    }
                    else {
                        $roles = $_GET['roles'];       
                        $count = count($roles);         
                        //echo $count;
                        //var_dump($roles);

                        // Assign queried table name to variable
                        $table = 'userrole';

                        // Sanitize posted data
                        $id = htmlspecialchars($_GET['user']);

                        // Check if localhost or host server & connect to database
                        if(isset($server) && $server != 'localhost'){
                            include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                        } else {
                            include 'dbconnect.php';
                        }

                        /* Insert multiple checkbox selections into MySQL database using foreach loop: See Kevin Yank "PHP and MySQL" p. 307 */
                        // Execute the $sql for each element of the roles array as $role; this inserts the same userid for each roleid -> beautiful! 
                        //foreach($_GET['roles'] as $role) {  
                        foreach($roles as $role) {
                            try {
                                $sql = "INSERT INTO $table SET
                                        userid = :userid,
                                        roleid = :roleid";
                                $s = $db->prepare($sql);
                                $s->bindValue(':userid', $id);
                                $s->bindValue(':roleid', $role);
                                $s->execute(); 
                            } 
                            catch (PDOException $e) {
                                $error = 'Error assigning role to user.' . $e->getMessage();
                                include '../includes/error.html.php';
                                exit();
                            }
                        }

                        // Close database connection to prepare to send email
                        $db = null;

                        header('Location: ?task=Display user role');
                        exit();
                    }

                }
            
            
            ?>


        </div>
        
                  

    </div><!-- // .row -->
</div>