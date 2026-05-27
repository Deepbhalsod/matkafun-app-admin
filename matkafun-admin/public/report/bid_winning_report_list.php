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
                            <select class="selectpicker form-control" name="game_id" title="Select Category" id="slect_job_cat" value="">
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
                    <div class="col-md-2 text-centre">
                        <button type="submit" class="btn btn-primary" style="margin-top:30px;" name="filter" value="filter">Submit</button>
                        <button class="btn btn-danger" id="clearrr_cat" style="color:azure; margin-top:30px;"><a href=" <?= SITE_URL; ?>bid_winning_report_list/report">Clear</a></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <h4>Bid Winning Reort</h4>
            <div class="table-responsive mb-4 mt-4">
                <table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
                    <tbody>
                        <tr>
                            <td style="width: 50%">Total Bids Amount</td>
                            <td style="width: 30%"  id="msg">₹<?=$bidReport['total_bid_points']?></td>
                            <td style="width: 20%"><a href=" <?= SITE_URL; ?>report_user_bid_history_list/report">View</a></td>
                        </tr>
                        <tr>
                            <td style="width: 50%">Total Win Amount</td>
                            <td style="width: 30%" id="msgwin">₹<?=$bidReport['total_win_points']?></td>
                            <td style="width: 20%"><a href=" <?= SITE_URL; ?>winning_report_list/report">View</a></td>
                        </tr>
                        <tr>
                            <td style="width: 50%">Total Profit Amount</td>
                            <td style="width: 30%" id="msgprofit">₹<?=$bidReport['total_profit_points']?></td>
                            <td style="width: 20%">View</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <h4>Bids List</h4>
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="table_id" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 2%">#</th>
                                <th>Date</th>
                                <th>User Name</th>
                                <th>Game Name</th>
                                <th>Game Type</th>
                                <th>Session</th>
                                <th>Open Panna</th>
                                <th>Open Digit</th>
                                <th>Close Panna</th>
                                <th>Close Digit</th>
                                <th>Points</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $i = 1;
                            if (!empty($userData)) :

                                foreach ($userData as $key => $value) :
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>
                                        <td class="text-center"><?=date('d-m-Y h:i A', strtotime($value['bidded_at']))?></td>
                                        <td class="text-center"><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>"><?=$value['username']?></a></td>
                                        <td class="text-center"><?=$value['game_name']?></td>
                                        <td class="text-center"><?=$value['game_type']?></td>
                                        <td class="text-center"><?=$value['session']?></td>
                                        <td class="text-center"><?=$value['open_panna']?></td>
                                        <td class="text-center"><?=$value['open_digit']?></td>
                                        <td class="text-center"><?=$value['close_panna']?></td>
                                        <td class="text-center"><?=$value['close_digit']?></td>
                                        <td class="text-center"><?=$value['bid_points']?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <h4>Winning List</h4>
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="winlistreport" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 2%">#</th>
                                <th>Date</th>
                                <th>User Mobile</th>
                                <th>User Name</th>
                                <th>Game Name</th>
                                <th>Game Type</th>
                                <th>Open Panna</th>
                                <th>Open Digit</th>
                                <th>Close Panna</th>
                                <th>Close Digit</th>
                                <th>Winning Amount</th>
                                <th>Points</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $i = 1;
                            if (!empty($dataWin)) :

                                foreach ($dataWin as $winKey => $win) :
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>
                                        <td class="text-center"><?=date('d-m-Y h:i A', strtotime($win['won_at']))?></td>
                                        <td class="text-center"><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>"><?=$win['mobile']?></a></td>
                                        <td class="text-center"><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>"><?=$win['username']?></a></td>
                                        <td class="text-center"><?=$win['game_name']?></td>
                                        <td class="text-center"><?=$win['game_type']?></td>
                                        <td class="text-center"><?=$win['open_panna']?></td>
                                        <td class="text-center"><?=$win['open_digit']?></td>
                                        <td class="text-center"><?=$win['close_panna']?></td>
                                        <td class="text-center"><?=$win['close_digit']?></td>
                                        <td class="text-center"><?=$win['win_points']?></td>
                                        <td class="text-center"><?=$win['bid_points']?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>