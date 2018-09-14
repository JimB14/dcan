<?php
include '../includes/login-check.inc.php';
?>


<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<form class="p2" method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">            

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autofocus value="<?php htmlout($user['name']); ?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php htmlout($user['email']); ?>">
    </div>
    <div class="form-group">
        <label for="password">Password (display only)</label>
        <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php htmlout($user['password']); ?>" readonly>
    </div>

    <input type="hidden" name="id" value="<?php htmlout($user['id']); ?>">
    <button type="submit" onclick="return confirm('Update &quot;<?php htmlout($user['name']); ?>&quot; data now?');" class="btn btn-buy" name="action" value="update_user">Update user</button>

</form> 


<h2 style="margin-bottom: 10px;">Change user password</h2>

<form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 

    <div class="form-group">
        <!--<label for="new_password" style="color:#838383">New Password</label>-->
        <input type="text" class="form-control" name="new_password" id="new_password" placeholder="New Password">
    </div>

    <input type="hidden" name="id" value="<?php htmlout($user['id']); ?>">
    <button type="submit" onclick="return confirm('Update <?php htmlout($user['name']); ?>\'s password now?');" class="btn btn-buy" name="action" value="update_password">Update password</button>

</form>
