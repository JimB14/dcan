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
    $error = 'Only Site Administrators may access this page.';
    include '../accessdenied.html.php';
    exit();
}


   
/*  - - - - - - - - - -  DEFAULT   - - - - - - - - - - */

include 'main.html.php';   