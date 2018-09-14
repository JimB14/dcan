<?php
include '../includes/login-check.inc.php';
//echo $_SERVER['PHP_SELF'] . '<br>';
///echo $_SERVER['DOCUMENT_ROOT'] . '<br>';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<div class="table-responsive">
    <p class="red"><?php if (isset($errMsg)) htmlout($errMsg); ?></p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">        
        <table class="table table-bordered insert-post bg-fff">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Title</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($categories as $category): ?>
                <tr>
                    <td><?php echo $category['cat_id']; ?></td>
                    <td><?php echo $category['cat_title']; ?></td>
                    <td><a class="btn btn-default btn-sm" href="index.php?edit_category=<?php echo $category['cat_id'] ?>">Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="index.php?delete_category=<?php echo $category['cat_id'] ?>" onclick="return confirm('Permanently delete this category?');">&times;</a></td>
                </tr>
                <?php  endforeach; ?>

            </tbody>
        </table>

    </form>
    
</div><!-- // .table-responsive  -->     