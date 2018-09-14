<?php
include '../includes/login-check.inc.php';
?>


<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" class="p1">            

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autofocus required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
    </div>              

    <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" name="password" id="password" placeholder="Password" required>
    </div>
    <button type="submit" onclick="return confirm('Add new user?');" class="btn btn-buy" name="action" value="add_user">Add user</button>
</form>
<p class="text-size90"><span class="red text-size130">*</span> You must assign a role or roles to every user. You will be taken there immediately after you submit this data.</p>