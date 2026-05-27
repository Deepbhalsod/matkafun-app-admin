<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row mt-5" id="cancel-row">
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
                                <option value="single_digit">Single Digit</option>
                                <option value="jodi_digit">Jodi Digit</option>
                                <option value="single_panna">Single Panna</option>
                                <option value="double_panna">Double Panna</option>
                                <option value="triple_panna">Triple Panna</option>
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
            <center class="sell-report-box"><h4>Single Digit</h4></center>
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
                                        <?php foreach($singleDigitReport as $sdKey =>$sdvalue):?>
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

<div class="row mt-5" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <center class="sell-report-box"><h4>Single Panna</h4></center>
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
                                        <?php foreach($singlePannaReport as $spKey =>$spvalue):?>
                                            <div class="form-group bord col-md-1">
                                                <h5 class="st_br_ht"><?php echo $spvalue['number']; ?></h5>
                                                <h5 class="st_br_hb"><badge class="badge-report <?=($spvalue['count']>0)?'badge-success':'badge-danger'?>"><?php echo $spvalue['count']; ?></badge></h5>
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
            <center class="sell-report-box"><h4>Double Panna</h4></center>
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
                                        <?php foreach($doublePannaReport as $dpKey =>$dpvalue):?>
                                            <div class="form-group bord col-md-1">
                                                <h5 class="st_br_ht"><?php echo $dpvalue['number']; ?></h5>
                                                <h5 class="st_br_hb"><badge class="badge-report <?=($dpvalue['count']>0)?'badge-success':'badge-danger'?>"><?php echo $dpvalue['count']; ?></badge></h5>
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
            <center class="sell-report-box"><h4>Triple Panna</h4></center>
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
                                        <?php foreach($triplePannaReport as $tpKey =>$tpvalue):?>
                                            <div class="form-group bord col-md-1">
                                                <h5 class="st_br_ht"><?php echo $tpvalue['number']; ?></h5>
                                                <h5 class="st_br_hb"><badge class="badge-report <?=($tpvalue['count']>0)?'badge-success':'badge-danger'?>"><?php echo $tpvalue['count']; ?></badge></h5>
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