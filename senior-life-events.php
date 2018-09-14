<?php
$title = 'Senior Events';
$description = 'At DCAN we are the extra hand that helps seniors keep their lives running.';
$body = 'index-1';
include 'includes/header.php';
?>



<section id="content">
    <div class="container">
        <div class="block-3" style="margin-bottom: 30px;">
            <div class="row">
                <div class="grid_10 col-center-block">
                    
                    <?php include 'includes/senior-events-table.inc.php'; ?>

                </div>
            </div>
        </div>
    </div>
</section>


<?php
include 'includes/footer.php';