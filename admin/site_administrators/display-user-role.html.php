<?php
include '../includes/login-check.inc.php';
?>


<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<div class="table-responsive">

    <table style="border-radius:4px;" class="table table-bordered table-hover table-striped">
        <thead>                                                         
            <tr>
                <?php $column_titles = array('id', 'name', 'roleid'); ?>
                <?php foreach ($column_titles as $title): ?>
                <th><?php htmlout($title); ?></th>
                <?php endforeach; ?>
                <th>delete</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>                        
                    <td><?php htmlout($user['id']); ?></td>
                    <td><?php htmlout($user['name']); ?></td>
                    <td><?php htmlout($user['roleid']); ?></td>
                    <td>
                        <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <input type="hidden" name="id" value="<?php htmlout($user['id']); ?>"> 
                            <input type="hidden" name="roleid" value="<?php htmlout($user['roleid']); ?>"> 
                            <button class="btn btn-danger btn-sm" type="submit" name="action" value="delete_user_role" onclick="return confirm('Delete &quot;<?php htmlout($user['roleid']); ?>&quot; role for &quot;<?php htmlout($user['name']);  ?>?&quot;')">&times;</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div><!-- // .table-responsive -->