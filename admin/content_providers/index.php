<?php
/*
 * content_providers/index.php - Controller
 */

require '../includes/access.inc.php';

// Check if user is logged in; if not display login form
if(!userIsLoggedIn())
{
    include '../login.html.php';
    exit();
}

// Check if logged in user has rights that link points to
if(!userHasRole('Content Provider')){
    
    $error = 'Only Content Providers may access this page.';
    include '../accessdenied.html.php';
    
    // Destroy session for user with credentials but no role
    session_destroy();
    exit();
} 

// Send email when user with Content Provider role logs in
notify_login($_SESSION['email']);

// After SESSION['loggedIn'] === TRUE; include session timeout code for auto logout
//include '../includes/session_life.inc.php';




/* - - - - - - - - - - - - - - - DEFAULT  - - - - - - - - - - - - - - - - - -  */

// Display Reports form
include 'main.html.php';