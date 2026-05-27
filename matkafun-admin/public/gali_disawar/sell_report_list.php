<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mb-4">
                            <label>Date</label>
                            <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                    </div>



                    <div class="col-md-2">
                        <div class="form-group mb-4 reloaded-divs">
                            <label>Game Name</label>
                            <select class="selectpicker form-control" name="game_id" title="Select Game" id="slect_job_cat" value="">
                                <option value="All">All</option>
                                <?php foreach ($games as $value) :
                                    $category_idss = $_POST['game_id'] ?? '';
                                ?>
                                    <option value="<?php is($value['id'], 'show'); ?>" <?php echo ($value['id'] == $category_idss) ? "selected" : ""; ?>>
                                        <?php is($value['name'], 'showCapital'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group mb-4 reloaded-divs">
                            <label>Game Type</label>
                            <select class="selectpicker form-control" name="game_type" title="Select Game Type" id="slect_job_cat" value="">
                                <option value="All">All</option>
                                <option value="left_digit">Left Digit</option>
                                <option value="right_digit">Right Digit</option>
                                <option value="jodi_digit">Jodi Digit</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 text-centre">
                        <button type="submit" class="btn btn-primary" style="margin-top:30px;" name="filter" value="filter">Submit</button>
                        <button class="btn btn-danger" id="clearrr_cat" style="color:azure; margin-top:30px;"><a href=" <?= SITE_URL; ?>report_user_bid_history_list/report">Clear</a></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row mt-5" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <center class="sell-report-box"><h4>Left Digit</h4></center>
            <form method="post">
                <div class="mb-4 mt-4">
                    <div class="row">
                    <!-- Zero Configuration  Starts-->	
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mytable">
                                        <div class="row sr_td_data">
                                            <div class="form-group bord st_br_l col-md-2">
                                                <h5 class="st_br_ht">Digit</h5>
                                                <h5 class="st_br_hb">Point</h5>
                                            </div>
                                        <?php foreach($leftDigitReport as $sdKey =>$sdvalue):?>
                                            <div class="form-group bord col-md-1">
                                                <h5 class="st_br_ht"><?php echo $sdvalue['number']; ?></h5>
                                                <h5 class="st_br_hb"><badge class="badge-report <?=($sdvalue['count']>0)?'badge-success':'badge-danger'?>"><?php echo $sdvalue['count']; ?></badge></h5>
                                            </div>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>    
        </div>
    </div>
</div>

<div class="row mt-5" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <center class="sell-report-box"><h4>Right Digit</h4></center>
            <form method="post">
                <div class="mb-4 mt-4">
                    <div class="row">
                    <!-- Zero Configuration  Starts-->	
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mytable">
                                        <div class="row sr_td_data">
                                            <div class="form-group bord st_br_l col-md-2">
                                                <h5 class="st_br_ht">Digit</h5>
                                                <h5 class="st_br_hb">Point</h5>
                                            </div>
                                        <?php foreach($rightDigitReport as $rdKey =>$rdvalue):?>
                                            <div class="form-group bord col-md-1">
                                                <h5 class="st_br_ht"><?php echo $rdvalue['number']; ?></h5>
                                                <h5 class="st_br_hb"><badge class="badge-report <?=($rdvalue['count']>0)?'badge-success':'badge-danger'?>"><?php echo $rdvalue['count']; ?></badge></h5>
                                            </div>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>    
        </div>
    </div>
</div>
<div class="row mt-5" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <center class="sell-report-box"><h4>Jodi Digit</h4></center>
            <form method="post">
                <div class="mb-4 mt-4">
                    <div class="row">
                    <!-- Zero Configuration  Starts-->	
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mytable">
                                        <div class="row sr_td_data">
                                            <div class="form-group bord st_br_l col-md-2">
                                                <h5 class="st_br_ht">Digit</h5>
                                                <h5 class="st_br_hb">Point</h5>
                                            </div>
                                        <?php foreach($jodiDigitReport as $jdKey =>$jdvalue):?>
                                            <div class="form-group bord col-md-1">
                                                <h5 class="st_br_ht"><?php echo $jdvalue['number']; ?></h5>
                                                <h5 class="st_br_hb"><badge class="badge-report <?=($jdvalue['count']>0)?'badge-success':'badge-danger'?>"><?php echo $jdvalue['count']; ?></badge></h5>
                                            </div>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>    
        </div>
    </div>
</div>