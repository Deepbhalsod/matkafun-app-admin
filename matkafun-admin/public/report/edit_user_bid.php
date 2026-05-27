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
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Session</lable>
                            <input type="text" class="form-control" id="pre_session" name="session" value="<?php echo $ratingssssData['session']; ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Open Panna</lable>
                            <input type="number" class="form-control" id="open_panna" name="open_panna" value="<?php echo $ratingssssData['open_panna']; ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Open Digit</lable>
                            <input type="number" class="form-control" id="open_digit" name="open_digit" value="<?php echo $ratingssssData['open_digit']; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Close Panna</lable>
                            <input type="number" class="form-control" id="close_panna" name="close_panna" value="<?php echo $ratingssssData['close_panna']; ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Close Digit</lable>
                            <input type="number" class="form-control" id="close_digit" name="close_digit" value="<?php echo $ratingssssData['close_digit']; ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" name="editbidHIS" value="sfddsfs" class="btn btn-primary mt-4">Update Bid</button>
            </form>
        </div>
    </div>
</div>