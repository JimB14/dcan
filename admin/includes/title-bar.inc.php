<div class="col-md-12">
    <p>
        <span class="blue pull-right"><?php echo date('M d, Y'); ?></span>
        <span class="glyphicon glyphicon-user text-size120"></span> &nbsp;<span class="blue"><?php if (isset($_SESSION['name'])) htmlout($_SESSION['name']); ?></span>
    </p>           
</div><!-- // .col-md-12 -->
        
<div class="col-md-12">
    <h1 class=" well well-sm text-center text-center">
        <span class="text-capitalize">
            <?php if (isset($pageTitle)) {htmlout($pageTitle);} ?>
        </span>               
    </h1>
</div><!-- // .col-md-12 -->

