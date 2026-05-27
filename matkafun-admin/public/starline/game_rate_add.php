<?php breadcrumb_start('game', 'list/game', 'game_list'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Single Digit Value 1</lable>
                            <input type="number" class="form-control" id="single_digit_value_1" name="single_digit_value_1" placeholder="Single Digit Value 1 " value="<?php echo $single_d_Data['cost_amount']; ?>">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Single Digit Value 2</lable>
                            <input type="number" class="form-control" id="single_digit_value_2" name="single_digit_value_2" placeholder="Single Digit Value 2 " value="<?php echo $single_d_Data['earning_amount']; ?>">

                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Single Pana Value 1</lable>
                            <input type="number" class="form-control" id="single_pana_value_1" name="single_pana_value_1" placeholder="Single Pana Value 1 " value="<?php echo $single_pana_Data['cost_amount']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Single Pana Value 2</lable>
                            <input type="number" class="form-control" id="single_pana_value_2" name="single_pana_value_2" placeholder="Single Pana Value 2 " value="<?php echo $single_pana_Data['earning_amount']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Double Pana Value 1</lable>
                            <input type="number" class="form-control" id="double_pana_value_1" name="double_pana_value_1" placeholder="Double Pana Value 1 " value="<?php echo $double_pana_Data['cost_amount']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Double Pana Value 2</lable>
                            <input type="number" class="form-control" id="double_pana_value_2" name="double_pana_value_2" placeholder="Double Pana Value 2 " value="<?php echo $double_pana_Data['earning_amount']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Triple Pana Value 1</lable>
                            <input type="number" class="form-control" id="triple_pana_value_1" name="triple_pana_value_1" placeholder="Triple Pana Value 1 " value="<?php echo $triple_pana_Data['cost_amount']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Triple Pana Value 2</lable>
                            <input type="number" class="form-control" id="triple_pana_value_2" name="triple_pana_value_2" placeholder="Triple Pana Value 2" value="<?php echo $triple_pana_Data['earning_amount']; ?>">
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