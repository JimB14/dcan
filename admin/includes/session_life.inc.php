<?php
   
// Assign time in seconds
$timeout = 900; 

// Check if timeout field exists.
if(isset($_SESSION['timeout'])) 
{
    // Check if number of seconds since last visit is larger than timeout period
    $duration = time() - (int)$_SESSION['timeout'];
    if($duration > $timeout) 
    {
        // Destroy the session and redirect
        session_destroy();
        header('Location: ..');
    }
}    
// Update the timout field with the current time.
$_SESSION['timeout'] = time();