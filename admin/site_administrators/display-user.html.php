<?php
include '../includes/login-check.inc.php';
?>


<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<div class="table-responsive">

    <table style="border-radius:4px;" class="table table-bordered table-hover table-striped">
        <thead>                                                         
            <tr>
                <?php foreach ($table_fields as $fields): ?>
                    <th><?php htmlout($fields); ?></th>
                <?php endforeach; ?>
                    <th>edit user</th>
                    <th>delete user</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>                        
                    <td><?php htmlout($user['id']); ?></td>
                    <td><?php htmlout($user['name']); ?></td>
                    <td><?php htmlout($user['email']); ?></td>
                    <td><?php htmlout(substr($user['password'],0,15)); ?></td>
                    <td>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                            <input type="hidden" name="id" value="<?php htmlout($user['id']); ?>"> 
                            <button class="btn btn-default btn-sm" type="submit" name="action" value="edit_user" onclick="return confirm('Edit &quot;<?php htmlout($user['name']); ?>?&quot')">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                            <input type="hidden" name="id" value="<?php htmlout($user['id']); ?>">                                   
                            <button class="btn btn-danger btn-sm" name="action" value="delete_user" onclick="return confirm('Permanently delete user &quot;<?php htmlout($user['name']); ?>?&quot;');">&times;</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div><!-- // .table-responsive -->