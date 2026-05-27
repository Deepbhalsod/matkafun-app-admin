<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('game_rate', 'add/game_rate', 'game_rate_add'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form method="post">
                <div class="mb-4 mt-4">
                    <center><h4><?php echo ucwords(str_replace('_',' ',$slug)); ?></h4></center>
                    <div class="row mt-5 row-data-center">
                        <?php if($slug=="half_sangam" || $slug=="full_sangam"):
                            foreach($sec_num as $secKey => $secValue):
                                foreach($numbers as $key =>$val):
                        ?>
                        <div class="col-md-1 col-4 py-2">
                            <div class="number-box"><?php echo $secValue."-".$val; ?></div>
                        </div>
                        <?php endforeach;
                        endforeach; 
                            if($slug=="half_sangam"):
                                foreach($numbers as $key =>$val):
                                    foreach($sec_num as $secKey => $secValue):
                        ?>
                        <div class="col-md-1 col-4 py-2">
                            <div class="number-box"><?php echo $val."-".$secValue; ?></div>
                        </div>
                        <?php endforeach;
                        endforeach; endif;
                        else:
                            foreach($numbers as $key =>$val):?>
                            <div class="col-md-1 col-4 py-2">
                                <div class="number-box"><?php echo ($val); ?></div>
                            </div>
                        <?php endforeach; endif;?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>