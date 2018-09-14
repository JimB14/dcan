<?php
include '../includes/login-check.inc.php';
?>
<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<div class="table-responsive">
    <p class="red"><?php if (isset($errMsg)) htmlout($errMsg); ?></p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">        
        <table class="table table-bordered insert-post bg-fff">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>CatID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Author</th>
                    <th>Keywords</th>
                    <th>Image</th>
                    <th>Comments</th>
                    <th>Content</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php if(isset($posts)){ 
                    foreach($posts as $post){ ?>
                <tr>
                    <td><?php echo $post['post_id']; ?></td>
                    <td><?php echo $post['post_category_id']; ?></td>
                    <td><?php echo $post['post_title']; ?></td>
                    <td><?php echo $post['post_date']; ?></td>
                    <td><?php echo $post['post_author']; ?></td>
                    <td><?php echo $post['post_keywords']; ?></td>
                    <td><img src="../uploaded_post_images/<?php echo $post['post_image']; ?>" width="60"></td>
                    <td align="center">
                    <?php
                    
                        // Check if on localhost or host server & connect to database
                        if(isset($server) && $server != 'localhost'){
                            include $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/dbconnect.php';
                        } else {
                            include '../includes/dbconnect.php';
                        }
                        
                        
                        try {                         
                            $sql = "SELECT * FROM comments WHERE post_id = :post_id";
                            $s = $db->prepare($sql);
                            $s->bindValue(':post_id', $post['post_id']);
                            $s->execute(); 
                            
                            // Get row count of PDO object
                            $comment_count = $s->rowCount();
                            
                            // Display results
                            echo $comment_count;
                        } 
                        catch (PDOException $e) {
                            $errMsg = 'Error fetching data: '  . $e->getMessage();
                            exit();
                        }
                    ?>
                    </td>
                    <td><?php echo substr($post['post_content'], 0,30); ?></td>
                    <td><a class="btn btn-default btn-sm" href="index.php?edit_post=<?php htmlout($post['post_id']); ?>">Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="index.php?delete_post=<?php htmlout($post['post_id']); ?>&image=<?php htmlout($post['post_image']); ?>" onclick="return confirm('Permanently delete this post?');">&times;</a></td>
                </tr>
                <?php  }
                } else {
                    $no_posts = 'No posts to display';
                } 
                
                if(isset($no_posts)) {
                    echo '<div class="alert alert-warning">';
                    echo '<h4 style="margin-bottom:0px;">' . htmlspecialchars($no_posts) . '</h4>';
                    echo '</div>';
                }?>

            </tbody>
        </table>

    </form>
    
</div><!-- // .table-responsive  -->     