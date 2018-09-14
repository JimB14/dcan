<?php
if(isset($posts) && count($posts) > 0) {

    foreach ($posts as $post) { ?>

        <div class="post-single-main">
            <p style="margin-bottom:15px; font-size: 22px;">  <a href="index.php?getpost=<?php htmlout($post['post_id']);?>&gettitle=<?php htmlout(strtolower((preg_replace("~[^0-9a-z-]~i", "",(str_replace(' ', '-', $post['post_title'])))))); ?>"><?php echo $post['post_title']; ?></a><p>                     
            <img class="img-responsive pull-left p1" src="admin/uploaded_post_images/<?php htmlout($post['post_image']); ?>" alt="<?php htmlout($post['post_title']); ?>">           
            <span class="shadows-font">Category </span><span style="padding-left:0px; color:#000;" class="bold"><?php htmlout($post['cat_title']); ?></span>
            <br>
            <span class="shadows-font">Posted by </span> <span style="padding-left:0px; color:#000;" class="bold"><?php htmlout($post['post_author']); ?></span> &nbsp; 
            <span class="shadows-font">On </span> <span style="color:#000;" class="bold"><?php htmlout($post['post_date']); ?></span>
            <p class="text-justify">
                <!-- Search, Replace, Subject http://stackoverflow.com/questions/35879256/how-to-highlight-keywords-in-mysql-search-results?noredirect=1#comment59423877_35879256 -->
                <?php
                // Do not use htmlout to echo content because it will display HTML tags
                if (isset($search)) {
                    echo str_replace($search, "<span class='bg-yellow'>$search</span>", $post['post_content']);
                } else {
                    echo $post['post_content'];
                }
                ?>   
            </p>
            <p style="padding-bottom: 20px;" class="pull-right p2"><a href="index.php?getpost=<?php htmlout($post['post_id']); ?>">  Read more <i style="margin-top: 4px;" class="fa fa-angle-double-right"></i></a></p>
        </div>
        <?php
    }
} else {
    $no_post_message = 'Sorry, no posts to display!';
}