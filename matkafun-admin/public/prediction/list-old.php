<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6" id="prediv">
            <form class="p-3" method="post">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mb-4">
                            <label>Date</label>
                            <input type="date" class="form-control" id="pre_from_date" name="from_date" value="<?php echo Date('Y-m-d'); ?>" required="">
                        </div>
                    </div>



                    <div class="col-md-2">
                        <div class="form-group mb-4 reloaded-divs">
                            <label>Game Name</label>
                            <select class="selectpicker form-control" name="game_id" title="Select Game" id="pre_game_id" value="" required="">
                                <option value="">Select Game</option>
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
                            <label>Session</label>
                            <select class="selectpicker form-control" name="session" title="Select Session" id="pre_session" value="" required="">
                                <option value="Open">Open</option>
                                <option value="Close">Close</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-4 reloaded-divs">
                            <label>Open Pana</label>
                            <select class="selectpicker form-control" name="open_panna" title="Select Pana" id="pre_open_pana" value="">
                                <option value="">Select</option>
                                <?php foreach ($number as $val) :
                                    $category_idss = $_POST['pana'] ?? '';
                                ?>
                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-4 reloaded-divs">
                            <label>Close Pana</label>
                            <select class="selectpicker form-control" name="close_pana" title="Select Pana" id="pre_close_pana" value="">
                                 <option value="">Select</option>
                                <?php foreach ($number as $val) :
                                    $category_idss = $_POST['pana'] ?? '';
                                ?>
                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 text-centre">
                      <button type="submit" class="btn btn-primary" id="dib_win_filter" style="margin-top:30px;" name="pre_filter" onclick="return clickpredictionButton();" value="pre_filter">Get</button>

                        <button class="btn btn-danger" style="color:azure; margin-top:30px;" onclick="return clickrefresh();">Clear</button>
                    </div>
                </div>
            </form>
        
            <form method="post">
                <button class="primary">Total Bid Amount 30</button>
                <button class="primary">Total Winning Amount 17</button>
                
                <div class="table-responsive mb-4 mt-4">
                    <table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 2%">#</th>
                                <th>Date</th>
                                <th>User Phone</th>
                                <th>User Name</th>
                                <th>Game Name</th>
                                <th>Game Type</th>
                                <th>Session</th>
                                <th>Open Pana</th>
                                <th>Open Result</th>
                                <th>Close Pana</th>
                                <th>Close Result</th>
                                <th>Points</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                             
                            <?php 
                            $i = 1;
                           if (!empty($chk)):
                                foreach ($chk as $key => $value) :
                            ?>
                                    <tr>
                                       
                                        <td><?php echo $i++; ?>.</td>

                                        <td>
                                            
                                                <?php 
                                                if($value['bidded_at']!==""){
                                                    
                                                    $date = $value['bidded_at'];

                                                     $time = date("Y-m-d",strtotime($date));
                                                    
                                                }else{
                                                    $time=0000-00-00;
                                                }
                                                ?>
                                            <?php echo $time; ?>
                                            
                                        </td>


                                        <td class="text-center">
                                           
                                                <?php if (empty($value['user_id'])) {
                                                    echo "N/A";
                                                } else {
                                                    $return = get_signle_data_from('users', ['id' => $value['user_id']]);
                                                    
                                                    if ($return) {
                                                        $return1 = $return->mobile;
                                                        echo ($return1);
                                                    } else {
                                                        echo "N/A";
                                                    }
                                                } ?>
                                           
                                        </td>

                                        <td class="text-center">
                                            
                                                <?php if (empty($value['user_id'])) {
                                                    echo "N/A";
                                                } else {
                                                    $return_name = get_signle_data_from('users', ['id' => $value['user_id']]);
                                                    
                                                    if ($return_name) {
                                                        $returnmm = $return_name->username;
                                                        echo ($returnmm);
                                                    } else {
                                                        echo "N/A";
                                                    }
                                                } ?>
                                            
                                        </td>
                                        
                                        <td class="text-center">
                                            <?php if (empty($value['game_id'])) {
                                                echo "N/A";
                                            } else {
                                                $returnss = get_signle_data_from('games', ['id' => $value['game_id']]);
                                               
                                                if (!empty($returnss->name)){
                                                    echo ($returnss->name);
                                                } else {
                                                    echo "N/A";
                                                }
                                            } ?>
                                        </td>

                                        <td class="text-center">
                                            
                                                <?php echo ($value['game_type']); ?>
                                           
                                        </td>
                                        <td class="text-center">
                                            
                                                <?php echo ($value['session']); ?>
                                           
                                        </td>

                                        <td class="">
                                            <?php echo $value['open_panna']; ?>
                                        </td>

                                        <td class="">
                                            <?php echo $value['open_digit']; ?>
                                        </td>

                                        <td class="">
                                            <?php echo $value['close_panna']; ?>
                                        </td>

                                        <td class="">
                                            <?php echo $value['close_digit']; ?>
                                        </td>

                                        <td>
                                            
                                         <?php echo ($value['bid_points']); ?>
                                           
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