<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($title); ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags --> 

        <meta name="description" content="DCAN provides Senior Life Management Services">
        <!-- Bootstrap -->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" href="../images/apple-touch-icon.png">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/animate.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Londrina+Shadow|Vast+Shadow|Dancing+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

       <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <!-- tinymce.com text editor -->
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>tinymce.init({selector: 'textarea'});</script>
        <!-- http://stackoverflow.com/questions/13841986/tinymce-adding-p-tags-automatically  -->
        <!-- DOES NOT WORK  -->
        <script>
            tinyMCE.init({
                mode: "textareas",
                theme: "advanced",
                force_br_newlines: false,
                force_p_newlines: false,
                forced_root_block: '',
            });
        </script>
        
        <!--  Scripts -->        
        <script src="../js/jquery-ui.min.js"></script>
        <script src="../js/script.js"></script>
        
        <!-- Datepicker for event_date @https://jqueryui.com/datepicker/#default -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

        <!-- Must be below bootstrap styles -->
        <link rel="stylesheet" href="../css/style-admin.css">

        <style>
            /* Note: Try to remove the following lines to see the effect of CSS positioning */
            .affix {
                top: 0;
                width: 100%;
            }

            .affix + .container-fluid {
                padding-top: 70px;
            }
        </style>
    </head>
    <body>
        <!-- Add data-spy="affix" to the element you want affixed. -->
        <nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="250"> 
            <div class="container">
                <div id="admin-header-text">
                    <a href="index.php?goto=logout" title="Logout and go to home page"><h1 class="text-center" style="color: #fff; padding:5px 0px;">Dedicated Care Always Nearby</h1></a>                
                </div>
            </div><!-- // .container  -->
        </nav>