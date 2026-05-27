<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mb-4">
                            <label>Date</label>
                            <input type="date" class="form-control" id="from_date" name="from_date">
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
                        <button class="btn btn-danger" id="clearrr_cat" style="color:azure; margin-top:30px;"><a href=" <?= SITE_URL; ?>starline_win_report_list/starline">Clear</a></button>
                    </div>
                </div>
            </form>
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 2%">#</th>
                                <th>Date</th>
                                <th>User Phone</th>
                                <th>Username</th>
                                <th>Game Name</th>
                                <th>Game Type</th>
                                <th>Right Digit</th>
                                <th>Left Digit</th>
                                <th>Winning Amount</th>
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

                                        <td class="text-center">
                                            <?php 
                                                if($value['won_at']!==""){
                                                    if($value['won_at']=="0000-00-00 00:00:00")
                                                    {
                                                      $time="0000-00-00";  
                                                    }else{
                                                       $date = $value['won_at'];

                                                       $time = date("Y-m-d",strtotime($date)); 
                                                    }
                                                    
                                                }else{
                                                    $time="0000-00-00";
                                                }
                                                ?>
                                            <?php echo $time; ?>
                                        </td>

                                        <td class="text-center"><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>">
                                            <?php if (empty($value['user_id'])) {
                                                echo "N/A";
                                            } else {
                                                $returnssm = get_signle_data_from('users', ['id' => $value['user_id']]);
                                                $return1wwmm = $returnssm->mobile;
                                                if ($return1wwmm) {
                                                    echo ($return1wwmm);
                                                } else {
                                                    echo "N/A";
                                                }
                                            } ?>
                                        </a></td>

                                        <td class="text-center"><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>">
                                            <?php if (empty($value['user_id'])) {
                                                echo "N/A";
                                            } else {
                                                $returnss = get_signle_data_from('users', ['id' => $value['user_id']]);
                                                $return1ww = $returnss->username;
                                                if ($return1ww) {
                                                    echo ($return1ww);
                                                } else {
                                                    echo "N/A";
                                                }
                                            } ?>
                                        </a></td>

                                        <td class="text-center">
                                            <?php if (empty($value['game_id'])) {
                                                echo "N/A";
                                            } else {
                                                $returnssss = get_signle_data_from('gali_disawar_game', ['id' => $value['game_id']]);

                                                if ($returnssss) {

                                                    $return1wssw = $returnssss->name;
                                                    echo ($return1wssw);
                                                } else {
                                                    echo "N/A";
                                                }
                                            } ?>
                                        </td>

                                        <td class="text-center">
                                            <?php echo $value['game_type']; ?>
                                        </td>

                                        <td class="text-center">
                                            <?php echo $value['right_digit']; ?>
                                        </td>


                                        <td class="text-center">
                                            <?php echo $value['left_digit']; ?>
                                        </td>

                                        <td class="text-center">
                                            <?php echo $value['win_points']; ?>
                                        </td>

                                        <td class="text-center">
                                            <?php echo $value['bid_points']; ?>
                                        </td>



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