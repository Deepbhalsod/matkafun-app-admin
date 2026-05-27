<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 shadow">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>User Name</lable>
                             <input type="text" class="form-control" id="new_bid" name="username" value="<?php echo $ratingssssData['username']; ?>" readonly>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Points</lable>
                             <input type="text" class="form-control" id="result_point" name="bid_points" value="<?php echo $ratingssssData['bid_points']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Game Name</lable>
                            <input type="text" class="form-control" id="report_bid_game_id" name="game_id" value="<?php echo $ratingssssData['game_name']; ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Game Type</lable>
                            <input type="text" class="form-control" id="report_bid_game_type" name="game_type" value="<?php echo $ratingssssData['game_type']; ?>" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Right Digit</lable>
                            <input type="number" class="form-control" id="panna" name="panna" value="<?php echo $ratingssssData['right_digit']; ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Left Digit</lable>
                            <input type="number" class="form-control" id="digit" name="digit" value="<?php echo $ratingssssData['left_digit']; ?>">
                        </div>
                    </div>
                </div>
                <button type="submit" name="editbidhisstarline" value="sfddsfs" class="btn btn-primary mt-4">Update Bid</button>
            </form>
        </div>
    </div>
</div>