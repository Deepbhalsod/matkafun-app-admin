<link rel="stylesheet" href="/dashboard.css">

<?php
$activeUser   = $data->activeusers   ? $data->activeusers   : 0;
$inactiveUser = $data->inactiveusers ? $data->inactiveusers : 0;
$demoUser     = $data->demoaccount   ? $data->demoaccount   : 0;
$totalUser    = $activeUser + $inactiveUser + $demoUser;
?>

<div class="dash-container">

    <!-- ==============================
         SECTION 1 — OVERVIEW STATS
         ============================== -->
    <div class="dash-section">
        <div class="dash-section-title">📊 Overview</div>
        <div class="stat-grid">

            <!-- Total Users -->
            <a href="<?php echo SITE_URL; ?>list/user" class="stat-card sc-orange">
                <div class="card-icon">
                    <img src="<?php echo SITE_URL; ?>/assets/img/svg/2users.svg" alt="Users">
                </div>
                <div class="card-value">
                    <?= $totalUser ?>
                    <span>(<?= $activeUser ?>)</span>
                </div>
                <p class="card-label">Total Users</p>
            </a>

            <!-- Total Games -->
            <a href="<?php echo SITE_URL; ?>list/game" class="stat-card sc-pink">
                <div class="card-icon">
                    <img src="<?php echo SITE_URL; ?>/assets/img/svg/game.svg" alt="Games">
                </div>
                <div class="card-value"><?php is($data->games, "show"); ?></div>
                <p class="card-label">Total Games</p>
            </a>

            <!-- Unapproved Users -->
            <a href="<?php echo SITE_URL; ?>unapprove_user_list/user" class="stat-card sc-brown">
                <div class="card-icon">
                    <img src="<?php echo SITE_URL; ?>/assets/img/svg/unuser.svg" alt="Unapproved">
                </div>
                <div class="card-value"><?php is($data->inactiveusers, "show"); ?></div>
                <p class="card-label">Unapproved Users</p>
            </a>

            <!-- Total Bid Amount -->
            <div class="stat-card sc-blue">
                <div class="card-icon">
                    <img src="<?php echo SITE_URL; ?>/assets/img/svg/bid.svg" alt="Bid">
                </div>
                <div class="card-value">
                    <?php
                    if (!empty($querryy)) {
                        foreach ($querryy as $keyll => $vaall) {
                            echo $vaall->total_bid_amount;
                        }
                    } else {
                        echo '0';
                    }
                    ?>
                </div>
                <p class="card-label">Total Bid Amount</p>
            </div>

        </div>
    </div>

    <!-- ==============================
         SECTION 2 — TODAY'S ACTIVITY
         ============================== -->
    <div class="dash-section">
        <div class="dash-section-title">📅 Today's Activity</div>
        <div class="stat-grid">

            <!-- Today Withdrawal -->
            <a href="<?php echo SITE_URL; ?>withdraw_report_list/report" class="stat-card sc-rose">
                <div class="card-icon">
                    <img src="<?php echo SITE_URL; ?>/assets/img/svg/2users.svg" alt="Withdrawal">
                </div>
                <div class="card-value"><?= $today_withdrawal ?></div>
                <p class="card-label">Today Withdrawal</p>
            </a>

            <!-- Today Deposit -->
            <a href="<?php echo SITE_URL; ?>auto_deposite_history_list/report" class="stat-card sc-teal">
                <div class="card-icon">
                    <img src="<?php echo SITE_URL; ?>/assets/img/svg/2users.svg" alt="Deposit">
                </div>
                <div class="card-value"><?= $today_deposit ?></div>
                <p class="card-label">Today Deposit</p>
            </a>

            <!-- Today Registration -->
            <a href="<?php echo SITE_URL; ?>list/user" class="stat-card sc-purple">
                <div class="card-icon">
                    <img src="<?php echo SITE_URL; ?>/assets/img/svg/2users.svg" alt="Registration">
                </div>
                <div class="card-value"><?= $today_regis ?></div>
                <p class="card-label">Today Registration</p>
            </a>

            <!-- Today Deposit By Admin -->
            <a href="<?php echo SITE_URL; ?>add_fund_report_list/report" class="stat-card sc-indigo">
                <div class="card-icon">
                    <img src="<?php echo SITE_URL; ?>/assets/img/svg/2users.svg" alt="Admin Deposit">
                </div>
                <div class="card-value"><?= $today_depositadmin ?></div>
                <p class="card-label">Today Deposit By Admin</p>
            </a>

        </div>
    </div>

    <!-- ==============================
         SECTION 3 — ANK BID ANALYSIS
         ============================== -->
    <div class="dash-section">
        <div class="dash-section-title">🎯 Ank Bid Analysis</div>
        <p style="font-size:0.82rem; color:#6b7280; margin-bottom:1rem; margin-top:-0.5rem;">
            Total Bids on Single Ank &mdash; <?php echo date("d M Y"); ?>
        </p>

        <!-- Filter Form -->
        <form method="post" id="getankForm">
            <div class="filter-form-wrap">
                <div class="form-group">
                    <label for="ank_game_id">Game Name</label>
                    <select class="selectpicker form-control-me" name="ank_game_id" title="Select Game" id="ank_game_id">
                        <option value="All">All</option>
                        <?php foreach ($appliee as $value) :
                            $category_idss = $_POST["game_id"] ?? ""; ?>
                            <option value="<?php is($value["id"], "show"); ?>"
                                <?php echo $value["id"] == $category_idss ? "selected" : ""; ?>>
                                <?php is($value["name"], "showCapital"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ank_date">Date</label>
                    <input type="date" class="form-control-me" id="ank_date" name="ank_date"
                        value="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label for="ank_market">Market Time</label>
                    <select class="form-control-me" name="ank_market" id="ank_market">
                        <option value="Open">Open Market</option>
                        <option value="Close">Close Market</option>
                    </select>
                </div>

                <div class="filter-btns">
                    <button type="submit" class="btnGet" name="ank_filter" value="ank_filter" onclick="return clickankButton();">Get</button>
                    <button class="btnClear" id="clearrr_cat"><a href="<?= SITE_URL ?>dashboard">Clear</a></button>
                </div>
            </div>
        </form>

        <!-- Ank Cards Grid -->
        <div class="ank-grid" id="row_bid" style="margin-top: 1.4rem;">

            <?php
            $ankData = [
                ['label' => 'Ank 0', 'count_id' => 'zero_ank_count', 'sum_id' => 'zero_ank_sum', 'count' => $zero_ank_data ?? '0', 'sum' => $sum_zero ?? '0'],
                ['label' => 'Ank 1', 'count_id' => 'one_ank_count',  'sum_id' => 'one_ank_sum',  'count' => $onw_ank_data  ?? '0', 'sum' => $sum_onw  ?? '0'],
                ['label' => 'Ank 2', 'count_id' => 'two_ank_count',  'sum_id' => 'two_ank_sum',  'count' => $two_ank_data  ?? '0', 'sum' => $sum_two  ?? '0'],
                ['label' => 'Ank 3', 'count_id' => 'thr_ank_count',  'sum_id' => 'thr_ank_sum',  'count' => $thre_ank_data ?? '0', 'sum' => $sum_thre ?? '0'],
                ['label' => 'Ank 4', 'count_id' => 'four_ank_count', 'sum_id' => 'four_ank_sum', 'count' => $four_ank_data ?? '0', 'sum' => $sum_four ?? '0'],
                ['label' => 'Ank 5', 'count_id' => 'fiv_ank_count',  'sum_id' => 'fiv_ank_sum',  'count' => $fiv_ank_data  ?? '0', 'sum' => $sum_fiv  ?? '0'],
                ['label' => 'Ank 6', 'count_id' => 'six_ank_count',  'sum_id' => 'six_ank_sum',  'count' => $six_ank_data  ?? '0', 'sum' => $sum_six  ?? '0'],
                ['label' => 'Ank 7', 'count_id' => 'sev_ank_count',  'sum_id' => 'sev_ank_sum',  'count' => $svn_ank_data  ?? '0', 'sum' => $sum_svn  ?? '0'],
                ['label' => 'Ank 8', 'count_id' => 'eght_ank_count', 'sum_id' => 'eght_ank_sum', 'count' => $eght_ank_data ?? '0', 'sum' => $sum_eght ?? '0'],
                ['label' => 'Ank 9', 'count_id' => 'nine_ank_count', 'sum_id' => 'nine_ank_sum', 'count' => $nin_ank_data  ?? '0', 'sum' => $sum_nin  ?? '0'],
            ];
            foreach ($ankData as $ank) : ?>
                <div class="ank-card">
                    <div class="ank-card-body">
                        <p>Total Bids</p>
                        <b id="<?= $ank['count_id'] ?>"><?= $ank['count'] ?></b>
                        <p class="ank-amount"><span id="<?= $ank['sum_id'] ?>"><?= $ank['sum'] ?></span> Amount</p>
                    </div>
                    <div class="ank-card-footer"><?= $ank['label'] ?></div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <!-- ==============================
         SECTION 4 — REPORTS
         ============================== -->
    <div class="report-grid">

        <!-- Bid Winning Report -->
        <div class="report-card">
            <h4>Bid Winning Report</h4>

            <form method="post" id="dashform">
                <div class="filter-form-wrap">
                    <div class="form-group">
                        <label for="win_from_date">Date</label>
                        <input type="date" class="form-control-me" id="win_from_date" name="filter_from_date"
                            value="<?php echo date("Y-m-d"); ?>">
                    </div>

                    <div class="form-group">
                        <label for="slect_g_name_win">Game Name</label>
                        <select class="form-control-me" name="filter_game_id" id="slect_g_name_win">
                            <option value="All">All</option>
                            <?php foreach ($appliee as $value) :
                                $category_idss = $_POST["game_id"] ?? ""; ?>
                                <option value="<?php is($value["id"], "show"); ?>"
                                    <?php echo $value["id"] == $category_idss ? "selected" : ""; ?>>
                                    <?php is($value["name"], "showCapital"); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-btns">
                        <button class="btnGet" type="submit" id="dib_win_filter" name="bid_win_filter"
                            value="bid_win_filter" onclick="return clickButton();">Get</button>
                        <button class="btnClear" id="clearrr_cat"><a href="<?= SITE_URL ?>dashboard">Clear</a></button>
                    </div>
                </div>
            </form>

            <div class="winning-stats-grid">
                
                <div class="win-stat-card wg-primary">
                    <div class="win-stat-icon">🎯</div>
                    <div class="win-stat-info">
                        <p>Total Bids</p>
                        <h3 id="msg">
                            ₹<?php
                            if (!empty($bid_point)) {
                                foreach ($bid_point as $key_bid => $vaal_bid) {
                                    echo $vaal_bid->filter_total_bid_amount ?? '0';
                                }
                            } else {
                                echo '0';
                            }
                            ?>
                        </h3>
                    </div>
                    <a href="<?= SITE_URL ?>report_user_bid_history_list/report" class="win-stat-view">View</a>
                </div>

                <div class="win-stat-card wg-success">
                    <div class="win-stat-icon">🏆</div>
                    <div class="win-stat-info">
                        <p>Total Win</p>
                        <h3 id="msgwin">
                            ₹<?php
                            if (!empty($win_point)) {
                                foreach ($win_point as $keyll2 => $vaawin_point) {
                                    echo $vaawin_point->win_point ?? '0';
                                }
                            } else {
                                echo '0';
                            }
                            ?>
                        </h3>
                    </div>
                    <a href="<?= SITE_URL ?>winning_report_list/report" class="win-stat-view">View</a>
                </div>

                <div class="win-stat-card wg-warning">
                    <div class="win-stat-icon">📈</div>
                    <div class="win-stat-info">
                        <p>Total Profit Amount</p>
                        <h3 id="msgprofit">₹<?php echo $profit ?? '0'; ?></h3>
                    </div>
                    <a href="javascript:void(0);" class="win-stat-view" style="opacity:0.5; cursor:default;">View</a>
                </div>

                <div class="win-stat-card wg-danger">
                    <div class="win-stat-icon">💸</div>
                    <div class="win-stat-info">
                        <p>Withdrawal request</p>
                        <h3 id="msgwithdraw">₹<?php echo $report_withdrawal ?? '0'; ?></h3>
                    </div>
                    <a href="<?= SITE_URL ?>withdraw_report_list/report" class="win-stat-view">View</a>
                </div>

                <div class="win-stat-card wg-purple">
                    <div class="win-stat-icon">➕</div>
                    <div class="win-stat-info">
                        <p>Add funds (manually)</p>
                        <h3 id="msgaddfunds">₹<?php echo $report_depositadmin ?? '0'; ?></h3>
                    </div>
                    <a href="<?= SITE_URL ?>add_fund_report_list/report" class="win-stat-view">View</a>
                </div>

                <div class="win-stat-card wg-info">
                    <div class="win-stat-icon">🏦</div>
                    <div class="win-stat-info">
                        <p>Total Deposits</p>
                        <h3 id="msgdeposit">₹<?php echo $report_deposit ?? '0'; ?></h3>
                    </div>
                    <a href="<?= SITE_URL ?>auto_deposite_history_list/report" class="win-stat-view">View</a>
                </div>

            </div>
        </div>

        <!-- Auto Deposit History (Commented out) -->
        <!--
        <div class="report-card">
            <h4>Fund Request Auto Deposit History</h4>

            <div class="deposit-table-wrap">
                <form id="cancel-row" method="post">
                    <table class="deposit-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (!empty($userDatare)) :
                                foreach ($userDatare as $key_userDatare => $value_use) : ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>
                                        <td>
                                            <a href="<?php echo SITE_URL . "user_detail_list/user/" . $value_use->user_id; ?>">
                                                <?php
                                                if (empty($value_use->user_id)) {
                                                    echo "NA";
                                                } else {
                                                    $return = get_signle_data_from("users", ["id" => $value_use->user_id]);
                                                    echo $return ? (ucfirst($return->username) ?: "N.A.") : "N.A.";
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo SITE_URL . "user_detail_list/user/" . $value_use->user_id; ?>">
                                                <?php
                                                if (empty($value_use->user_id)) {
                                                    echo "NA";
                                                } else {
                                                    $return = get_signle_data_from("users", ["id" => $value_use->user_id]);
                                                    echo $return ? (ucfirst($return->mobile) ?: "N.A.") : "N.A.";
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        <td><?php echo ucwords($value_use->points); ?></td>
                                        <td>
                                            <?php
                                            if ($value_use->created_at !== "" && $value_use->created_at != "0000-00-00 00:00:00") {
                                                echo date("Y-m-d", strtotime($value_use->created_at));
                                            } else {
                                                echo "0000-00-00";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        -->

    </div>
    <!-- end .report-grid -->

</div>
<!-- end .dash-container -->