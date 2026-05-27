<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('user', 'list/user', 'user_list'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form method="post">
                <div class="table-responsive mb-4 mt-4">
                    <table id="html5-extension" class="style-3 table table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 2%">#</th>
                                <th>User Id</th>
                                <th>Username</th>
                                <th>Amount</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $i = 1;
                            if (!empty($userData) and !empty($userData->data)) :

                                foreach ($userData->data as $key => $value) :
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>

                                        <td class="text-center">
                                            <?php if (empty($value->user_id)) {
                                                echo "N/A";
                                            } else {
                                                $return = get_signle_data_from('users', ['id' => $value->user_id]);
                                                $return1 = $return->user_id;
                                                if ($return1) {
                                                    echo ($return1);
                                                } else {
                                                    echo "N/A";
                                                }
                                            } ?>
                                        </td>

                                        <td class="text-center">
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
                                            +<?php echo $value->amount; ?>
                                        </td>

                                        <td class="text-center">
                                            <?php echo $value->remark; ?>
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