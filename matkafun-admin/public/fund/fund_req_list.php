<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 2%">#</th>
                                <th>Username</th>
                                <th>Points</th>
                                <th>Receipt Image</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $i = 1;
                            if (!empty($userData)) :

                                foreach ($userData as $key => $value) :
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>


                                        <td class="text-center"><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value->user_id;  ?>">
                                            <?php if (empty($value->user_id)) {
                                                echo "N/A";
                                            } else {
                                                $returnss = get_signle_data_from('users', ['id' => $value->user_id]);
                                                $return1ww = $returnss->username;
                                                if ($return1ww) {
                                                    echo ($return1ww);
                                                } else {
                                                    echo "N/A";
                                                }
                                            } ?>
                                        </td>


                                        <td class="text-center">
                                            <?php echo $value->points; ?>
                                        </td>

                                        <td class="text-center">
                                            <div class="rounded-lg">
                                                <?php if (is($value->receipt_image)) : ?>
                                                    <img src="<?php is($value->receipt_image, 'show'); ?>" class="img-fluid shadow rounded-lg" style="border: 2px solid #d3d3d3; width:80px; height:80px;" alt="">
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <?php 
                                                if($value->created_at !== "0000-00-00 00:00:00"){
                                                    $date = $value->created_at;
                                                    $time = date("d-M-Y H:i", strtotime($date));
                                                }else{
                                                    $time = "0000-00-00 00:00";
                                                }
                                                ?>
                                            <?php echo $time; ?>
                                        </td>

                                        <td class="text-center">
                                            <?php if (!empty($value->request_status)) {
                                                if ($value->request_status == "ACCEPTED" or ($value->request_status == "PENDING")) {
                                            ?>
                                                    <span class="badge badge-success"><?php echo $value->request_status; ?></span>
                                                <?php } else { ?>
                                                    <span class="badge badge-danger"><?php echo $value->request_status; ?></span>

                                                <?php };
                                            } else { ?>
                                                <span class="badge badge-danger">N/A</span>
                                            <?php }; ?>


                                        </td>

                                        <td class="text-center">
                                            <?php if (!empty($value->action_status)) {
                                                if ($value->action_status == "APPROVE") {
                                            ?>
                                                    <span class="badge badge-success"><?php echo $value->action_status; ?></span>
                                                <?php } else { ?>
                                                    <span class="badge badge-danger"><?php echo $value->action_status; ?></span>

                                                <?php };
                                            } else { ?>
                                                <span class="badge badge-danger">N/A</span>
                                            <?php }; ?>
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