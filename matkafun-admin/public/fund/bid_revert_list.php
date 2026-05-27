<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row mt-5" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mb-4">
                            <label>Date</label>
                            <input type="date" class="form-control" id="bid_revert_from_date" name="from_date" value="<?php echo date("Y-m-d"); ?>">
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
                        <button class="btn btn-danger" id="clearrr_cat" style="color:azure; margin-top:30px;"><a href=" <?= SITE_URL; ?>bid_revert_list/fund">Clear</a></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">

            <div class="table-responsive mb-4 mt-4">
                <button id="myrevertFunction">Revert Bid</button>
                <table id="html5-extension rever_bid_list" class="style-3 table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 1%">#</th>
                            <th>Date</th>
                            <th>Username</th>
                            <th>Game Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($userData)) :
                            
                            $i = 1;
                            foreach($userData as $key=>$value):
                        ?>
                            <tr>
                                <td><?php echo $i++; ?>.</td>
                             

                                <td>
                                    <?php echo ($value['bidded_at']); ?>

                                </td>

                                <td><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>">
                                    <?php echo ($value['user_name']); ?>

                                </a></td>

                                <td>
                                    <?php echo ($value['game_type']); ?>

                                </td>




                            </tr>
                             <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
 
      