
<p class="text-center bg-aqua">
    Search
</p>
<div style="margin-bottom: 35px;">

    <form class="form-inline" role="search" method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
        <!-- Inline button styling resource:  http://stackoverflow.com/questions/10615872/bootstrap-align-input-with-button  -->
        <div class="input-group">
            <input type="text" class="form-control small" name="search_query" placeholder="Search for..." required>
            <span class="input-group-btn">
                <input type="hidden" name="action" value="search">
                <button type="submit" class="btn btn-default">Search</button>
            </span>
        </div>
        
    </form>

</div>

<p class="text-center bg-aqua">
    Posts by Category
</p>

<div id="category-list">                    
    <ul>                   
        <?php foreach ($categories as $category): ?>       
        <li><a href="?cat_id=<?php echo htmlspecialchars($category['cat_id']); ?>&cat_title=<?php echo htmlspecialchars(strtolower((preg_replace("~[^0-9a-z-]~i", "",(str_replace(' ', '-', $category['cat_title'])))))); ?>"><?php echo htmlspecialchars($category['cat_title']); ?></a></li>
        <?php endforeach; ?>
        <li><a href="index.php?goto=blog">All posts</a></li>
    </ul>
</div>                 