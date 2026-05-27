<?php breadcrumb_start('game', 'list/game', 'game_list'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Left Digit Value 1</lable>
                            <input type="number" class="form-control" id="left_digit_value_1" name="left_digit_value_1" placeholder="Left Digit Value 1" value="<?php echo $left_digit ['cost_amount']; ?>">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Left Digit Value 2</lable>
                            <input type="number" class="form-control" id="left_digit_value_2" name="left_digit_value_2" placeholder="Left Digit Value 2" value="<?php echo $left_digit ['earning_amount']; ?>">

                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Right digit Value 1</lable>
                            <input type="number" class="form-control" id="right_digit_1" name="right_digit_1" placeholder="Right digit Value 1" value="<?php echo $right_digit['cost_amount']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Right Digit Value 2</lable>
                            <input type="number" class="form-control" id="right_digit_2" name="right_digit_2" placeholder="Right digit Value 2 " value="<?php echo $right_digit['earning_amount']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Jodi Digit Value 1</lable>
                            <input type="number" class="form-control" id="jodi_digit_1" name="jodi_digit_1" placeholder="Jodi Digit Value 1" value="<?php echo $jodi_digit['cost_amount']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Jodi Digit Value 2</lable>
                            <input type="number" class="form-control" id="jodi_digit_2" name="jodi_digit_2" placeholder="Jodi Digit Value 2" value="<?php echo $jodi_digit['earning_amount']; ?>">
                        </div>
                    </div>
                </div>
                
                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Triple Digit Value 1</lable>
                            <input type="number" class="form-control" id="triple_digit_1" name="triple_digit_1" placeholder="Triple Digit Value 1" value="<?php echo $triple_digit['cost_amount']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Triple Digit Value 2</lable>
                            <input type="number" class="form-control" id="triple_digit_2" name="triple_digit_2" placeholder="Triple Digit Value 2" value="<?php echo $triple_digit['earning_amount']; ?>">
                        </div>
                    </div>
                </div>


                <div class="ml-xl-5">
                    <button type="submit" name="addGamerate" value="addGamerate" class="ml-xl-4 btn btn-primary mt-4">Add Game Rate</button>
                </div>
            </form>
        </div>
    </div>
</div>