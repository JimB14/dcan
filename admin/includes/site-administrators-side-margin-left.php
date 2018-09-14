<div style="margin-top: 49px;">
    <?php
    $tasks = array(
        'Display users' => 'user',
        'Edit user' => 'user',
        'Add user' => 'user',
        'Display user role' => 'user',
        'Assign user role' => 'user',
    );
    ?>

    <ul class="list-group">
        <li class="list-group-item bold">Tasks</li>
        <?php foreach ($tasks as $key => $task): ?>
            <li class="list-group-item"><a href="index.php?task=<?php htmlout($key); ?>"><?php htmlout($key); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <p><a href="..">Return to CMS home</a></p>
    
    <div style="margin-top:20px;">
        <?php include '../includes/logout.inc.php'; ?>
    </div>  
    
</div>