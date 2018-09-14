        <div class="col-md-12">
            <p>
                <span class="blue pull-right"><?php echo date('M d, Y'); ?></span>
                <span class="glyphicon glyphicon-user text-size120"></span> &nbsp;<span class="blue"><?php if (isset($_SESSION['name'])) htmlout($_SESSION['name']); ?></span>
            </p>           
        </div><!-- // .col-md-12 -->

        <div class="col-md-12">
            <h1 class=" well well-sm text-center text-center"><span class="text-capitalize"><?php
                    if (isset($pageTitle)) {
                        htmlout($pageTitle);
                    }
                    ?></span></h1>
        </div>

        <div class="col-md-2 col-sm-2">
            
            <ul class="list-group">
                <li class="list-group-item bold">Tables</li>
                <?php foreach ($DBtables as $key => $table): ?>
                <li class="list-group-item">
                    <a href="?table=<?php htmlout($table); ?>"><?php htmlout($key); ?> &nbsp;
                        <?php 
                        if(isset($accessories_count) && $table === 'accessories') {echo '<span class="badge">' . $accessories_count . '</span>'; } 
                        if(isset($holster_count) && $table === 'holster') {echo '<span class="badge">' . $holster_count . '</span>'; } 
                        if(isset($laser_count) && $table === 'laser') {echo '<span class="badge">' . $laser_count . '</span>'; } 
                        if(isset($pistol_brand_count) && $table === 'pistol_brand') {echo '<span class="badge">' . $pistol_brand_count . '</span>'; } 
                        if(isset($pistol_model_count) && $table === 'pistol_model') {echo '<span class="badge">' . $pistol_model_count . '</span>'; } 
                        if(isset($flx_count) && $table === 'flx') {echo '<span class="badge">' . $flx_count . '</span>'; } 
                        ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            
            <ul class="list-group">
                <li class="list-group-item bold">Lookup Tables</li>
                <?php foreach ($lookuptables as $key => $table): ?>
                    <li class="list-group-item"><a href="?table=<?php htmlout($table); ?>"><?php htmlout($key); ?></a></li>
                <?php endforeach; ?>
            </ul>

            <p><a href="..">Return to CMS home</a></p>
            <?php include '../includes/logout.inc.php'; ?>
        </div>