<?php

if(isset($_GET['user_id'])){
      
    // Receive value of user variable from ajax script @script.js and store in variable
    $user_id = htmlspecialchars($_GET['user_id']);
    
    // Check if localhost or host server & connect to database
    if(isset($server) && $server != 'localhost'){
        include $_SERVER['DOCUMENT_ROOT'] . 'admin/includes/dbconnect.php';
    } else {
        include '../includes/dbconnect.php';
    }
    
    // Get user data
    try {
        $sql = "SELECT userid, roleid FROM userrole
                WHERE userid = :userid";
        $s = $db->prepare($sql);
        $s->bindValue(':userid', $user_id);
        $s->execute();
        
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $roles[] = array(
                'userid' => $row['userid'],
                'roleid' => $row['roleid']
            );          
        }
        /*
        foreach($roles as $value){
            if(in_array("Content Provider", $value, true)){
            echo 'Found Content Provider';
            } 
        }
        exit();
        
        echo '<pre>';
        print_r($roles);
        echo '</pre>';
        */
    } 
    catch (PDOException $e) {
        $error = 'Error fetching user data:' . $e->getMessage();
        include '../includes/error.html.php';
        exit();
    }  
}
?>
     

<!-- Resource (Alan Geleynse) to find value in two dimensional array (3-dimensional requires recursive function): http://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array   -->
<!--  Find out what roles already assigned; for those disable the checkbox so they cannot be re-added (generates an error message)  -->
<div class="checkbox">
    <label>
        <input type="checkbox" name="roles[]" value="Content Provider" 
            <?php
                if(isset($roles)){
                    foreach($roles as $role){
                        if( in_array("Content Provider", $role, true )) {
                            echo ' disabled';                  
                        }  
                    }
                }
            ?>>
        Content Provider
    </label>
</div>
<div class="checkbox">
    <label>
        <input type="checkbox" name="roles[]" value="Content Editor" 
            <?php
                if(isset($roles)){
                    foreach($roles as $role){
                        if( in_array("Content Editor", $role, true )) {
                            echo ' disabled'; 
                        }
                    }
                }
            ?>>
        Content Editor
    </label>
</div>
<div class="checkbox">
    <label>
        <input type="checkbox" name="roles[]" value="Site Administrator" 
            <?php
                if(isset($roles)){
                    foreach($roles as $role){
                        if( in_array("Site Administrator", $role, true )){
                            echo ' disabled';
                        }
                    }
                }
            ?>>
        Site Administrator
    </label>
</div>