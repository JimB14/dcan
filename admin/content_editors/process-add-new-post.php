<?php

/*-- - - - - - - - - - - - - - - - - - Insert new post into database  - - - - - - - - - - - - - - - -  */
                
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'insert_post_content') {
                    
                    //echo 'Success!'; exit();
                    
                    include '../includes/helper.php';

                    $errMsg = array();

                    $post_category_id = sanitize($_POST['post_category_id']);
                    $post_title = sanitize($_POST['post_title']);
                    $post_date = date('m-d-Y');
                    $post_author = sanitize($_POST['post_author']);
                    $post_keywords = sanitize($_POST['post_keywords']);
                    $post_image = $_FILES['post_image']['name'];
                    $post_image_tmp = $_FILES['post_image']['tmp_name'];
                    $post_content = $_POST['post_content'];

                    /* testing posted variables
                    if(isset($post_category_id))echo '$post_category_id isset and = ' . $post_category_id . '<br>'; else echo ' !isset <br>';
                    if(isset($post_title))      echo '$post_title isset and = ' . $post_title . '<br>';             else echo ' !isset <br>';
                    if(isset($post_date))       echo '$post_date isset and = ' . $post_date . '<br>';               else echo ' !isset <br>';
                    if(isset($post_author))     echo '$post_author isset and = ' . $post_author . '<br>';           else echo ' !isset <br>';
                    if(isset($post_keywords))   echo '$post_keywords isset and = ' . $post_keywords . '<br>';       else echo ' !isset <br>';
                    if(isset($post_image))      echo '$post_image isset and = ' . $post_image . '<br>';             else echo ' !isset <br>';
                    if(isset($post_image_tmp))  echo '$post_image_tmp isset and = ' . $post_image_tmp . '<br>';     else echo ' !isset <br>';
                    if(isset($post_content))    echo '$post_content isset and = ' . $post_content . '<br>';         else echo ' !isset <br>';
                    */

                // Check if fields have input  
                if(!isset($post_title) || $post_title === '' || !isset($post_category_id) || $post_category_id === '' || !isset($post_author) || 
                        $post_author === '' || !isset($post_keywords) || $post_keywords === '' || !isset($post_content) || $post_content === '' ){

                        $errMsg = '*Please fill in all fields before submitting.';
                        include 'includes/error.html.php';
                        exit();
                }      
                        
                // Check if post image was uploaded; if true, process, if false process differently
                if(!empty($_FILES['post_image']['tmp_name'])){

                        // Move uploaded file to assigned folder (here "uploaded_post_images") http://php.net/manual/en/function.move-uploaded-file.php
                        move_uploaded_file($post_image_tmp, "../uploaded_post_images/$post_image");

                        // Check if on localhost or host server & connect to database
                        if(isset($server) && $server != 'localhost'){
                            include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                        } 
                        else {
                            include '../includes/dbconnect.php';
                        }
                        
                        
                        // Assing queried table name to variable
                        $table = 'posts';

                        try {
                            $sql = "INSERT INTO $table SET
                                    post_category_id = :post_category_id,
                                    post_title = :post_title,
                                    post_date = :post_date,
                                    post_author = :post_author,
                                    post_keywords = :post_keywords,
                                    post_image = :post_image,
                                    post_content = :post_content";
                            $s = $db->prepare($sql);
                            $s->bindValue(':post_category_id', $post_category_id);
                            $s->bindValue(':post_title', $post_title);
                            $s->bindValue(':post_date', $post_date);
                            $s->bindValue(':post_author', $post_author);
                            $s->bindValue(':post_keywords', $post_keywords);
                            $s->bindValue(':post_image', $post_image);
                            $s->bindValue(':post_content', $post_content);
                            if( $s->execute() ){
                                echo "<script>alert('New post created!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_posts'</script>";
                            } 
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }
                }
                else {
                    
                    // Check if on localhost or host server & connect to database
                    if(isset($server) && $server != 'localhost'){
                        include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                    } 
                    else {
                        include '../includes/dbconnect.php';
                    }


                    // Assing queried table name to variable
                    $table = 'posts';

                    try {
                        $sql = "INSERT INTO $table SET
                                post_category_id = :post_category_id,
                                post_title = :post_title,
                                post_date = :post_date,
                                post_author = :post_author,
                                post_keywords = :post_keywords,
                                post_content = :post_content";
                        $s = $db->prepare($sql);
                        $s->bindValue(':post_category_id', $post_category_id);
                        $s->bindValue(':post_title', $post_title);
                        $s->bindValue(':post_date', $post_date);
                        $s->bindValue(':post_author', $post_author);
                        $s->bindValue(':post_keywords', $post_keywords);
                        $s->bindValue(':post_content', $post_content);
                        if( $s->execute() ){
                            echo "<script>alert('New post (without image) created!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_posts'</script>";
                        } 
                    }
                    catch (PDOException $e) {
                        $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                }

                    // Close database connection
                    $db = null;

                    //header('Location: .');
                    exit(); 
                }

