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
                    <th>Post ID</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th> 
                    <th>Text</th> 
                    <th>Status</th>
                    <th>Change to</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php if(isset($comments) && count($comments) > 0){
                    foreach($comments as $comment) { ?>
                <tr>
                    <td><?php echo $comment['comment_id']; ?></td>
                    <td><?php echo $comment['post_id']; ?></td>
                    <td><?php echo $comment['comment_date']; ?></td>
                    <td><?php echo $comment['comment_name']; ?></td>
                    <td><?php echo $comment['comment_email']; ?></td>
                    <td><?php echo $comment['comment_text']; ?></td>
                    <td>
                        <?php 
                            if(isset($comment['status']) && $comment['status'] === 'unapproved') {
                                echo '<span class="red">' . $comment['status'] . '</span>';                           
                            }
                            else {
                                echo '<span>' . $comment['status'] . '</span>';
                            }                        
                        ?>
                    </td>
                    <td>
                        <?php
                            if(isset($comment['status']) && $comment['status']  == 'approved') {
                                echo '<a href="index.php?unapprove_comment=' . $comment['comment_id'] . '" title=\'Change to unapprove\'>unapprove</a>';
                            }
                            else {
                                echo '<a href="index.php?approve_comment=' . $comment['comment_id'] . '" title=\'Change to approve\'>approve</a>';
                            }
                        ?>                                               
                    </td>
                    <td><a class="btn btn-default btn-sm" href="index.php?edit_comment=<?php echo $comment['comment_id'] ?>">Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="index.php?delete_comment=<?php echo $comment['comment_id'] ?>" onclick="return confirm('Permanently delete this comment?');">&times;</a></td>
                </tr>
                    <?php }
                } else {
                    echo '<div class="alert alert-warning">';
                    echo '<h4 style="margin-bottom:0px">No commments to display.</h4>';
                    echo '</div>';
                }?> 
            </tbody>
        </table>

    </form>
    
</div><!-- // .table-responsive  -->  