<?php

//DB configuration Constants - published website
/*
$dsn = 'mysql:host=localhost;dbname=dcan;charset=utf8';
$username = 'pamska5_jburns14';
$password = 'Hopehope1!';
*/

 
//DB configuration Constants - local
$dsn = 'mysql:host=127.0.0.1;dbname=dcan;charset=utf8';
$username = 'root';
$password = '';
 

// PDO Database Connection
try {  
    $db = new PDO($dsn, $username, $password); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /*
    if($db instanceof PDO){
        echo '<p style="color:red;">$db is instanceof PDO. Connected to DB!</p>';
    } 
    else {
        echo 'Error: $db is not instanceof PDO';
    }
    */
} 
catch(PDOException $e) {
    $error = 'Unable to connect to the database. Try again later. ' . $e->getMessage();
    include 'error.html.php';
exit();
}