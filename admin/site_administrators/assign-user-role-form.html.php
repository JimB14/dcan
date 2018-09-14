<?php
include '../includes/login-check.inc.php';
?>


<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>
           
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get"> 

    <select class="form-control p1" name="user" id="user">
        <option value="">Select User</option>
        <?php foreach($users as $user): ?>
        <option value="<?php htmlout($user['id']); ?>"> <?php htmlout($user['name']); ?></option>
        <?php endforeach; ?>
    </select>


    <!-- Insert multiple checkbox selections into MySQL database: See Yank "PHP and MySQL" p. 307 -->
    <h4>Select role(s)</h4>
    <p> *Checkbox disabled (will not accept a click) if role already assigned</p>
    <div id="user_roles">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="roles[]" value="Content Provider">
                Content Provider
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="roles[]" value="Content Editor">
                Content Editor
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="roles[]" value="Site Administrator">
                Site Administrator
            </label>
        </div>
    </div>
    <!--<input type="hidden" name="id" value="<?php// htmlout($user['id']) ?>">-->
    <button type="submit" onclick="return confirm('Assign role(s)?');" class="btn btn-buy" name="action" value="insert_into_userrole">Submit</button>
</form>  