<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 2%">#</th>
                                <th>Username</th>
                                <th>Phone Number</th>
                                <th>Amount</th>
                                <th>Details</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $i = 1;
                            if (!empty($userData)) :

                                foreach ($userData as $key => $value) :
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>
                                        <td><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>"><?=$value['username']?></a></td>
                                        <td><a href="<?php echo SITE_URL . 'user_detail_list/user/' . $value['user_id'];  ?>"><?=$value['mobile']?></a></td>
                                        <td><?=$value['points']?></td>
                                        <td><?=$value['details']?></td>
                                        <td><?=date('d-m-Y h:i A', strtotime($value['created_at']))?></td>
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