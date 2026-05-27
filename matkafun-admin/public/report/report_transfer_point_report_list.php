<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
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

                    <div class="col-md-2 text-centre">
                        <button type="submit" class="btn btn-primary" style="margin-top:30px;" name="filter" value="filter">Submit</button>
                        <button class="btn btn-danger" id="clearrr_cat" style="color:azure; margin-top:30px;"><a href=" <?= SITE_URL; ?>report_transfer_point_report_list/report">Clear</a></button>
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
                                <th>Sender Name</th>
                                <th>Receiver Name</th>
                                <th>Amount</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $i = 1;
                            if (!empty($userData[0]['created_at'])) :
                                foreach ($userData as $key => $value) :
                            ?>
                                    <h6>Total Transfer Amount: <?php echo $value['total_amount']; ?></h6>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>
                                        <td class="text-center"><?=date('d-m-Y h:i A', strtotime($value['created_at']))?></td>
                                        <td class="text-center"><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['sender_id'];  ?>"><?=$value['user_sender']?></a></td>
                                        <td class="text-center"><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['receiver_id'];  ?>"><?=$value['user_receiver']?></a></td>
                                        <td class="text-center"><?=$value['points']?></td>
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