<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('Redeem List', 'list/redeem'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">

            <div class="table-responsive mb-4 mt-4">
                <table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
                    <thead>
                        <tr class="">
                            <th>#</th>
                            <th class="">User Name</th>
                            <th class="">Wallet Amount</th>
                            <th class="">Request Amount</th>
                            <th class="">Reason</th>
                            <th>Created date</th>
                            <th>Pay</th>
                            <th>Cancel</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php if (!empty($redeemData)) :
                            $i = 1;
                            foreach ($redeemData as $key => $value) : ?>
                                <tr>
                                    <td><?php echo $i++; ?>.</td>


                                    <td class="admin-name">
                                        <?php if (empty($value->employee_id)) {
                                            echo "N.A.";
                                        } else {
                                            $return = get_signle_data_from('employees', ['id' => $value->employee_id]);
                                            $return1 = $return->name;
                                            if ($return1) {
                                                echo ucfirst($return1);
                                            } else {
                                                echo "N.A.";
                                            }
                                        } ?>
                                    </td>

                                    <td class="admin-name">
                                        <?php if (empty($value->employee_id)) {
                                            echo "N.A.";
                                        } else {
                                            $amt = get_signle_data_from('employees', ['id' => $value->employee_id]);
                                            $amount = $amt->wallet_amount;
                                            if ($amount) {
                                                echo ucfirst($amount);
                                            } else {
                                                echo "N.A.";
                                            }
                                        } ?>
                                    </td>
                                    </td>

                                    <td>
                                        <p class="admin-name">
                                            <?php is($value->amount, 'showCapital'); ?>
                                        </p>
                                    </td>

                                    <td>
                                        <p class="admin-name">
                                            <?php is($value->reason, 'showCapital'); ?>
                                        </p>
                                    </td>

                                    <td>
                                        <?php if (!is_null($value->created_date)) : ?>
                                            <?php echo date('M d, Y', strtotime($value->created_date)),
                                            ' At<br>',
                                            date('h: i A', strtotime($value->created_date)); ?>
                                        <?php endif; ?>
                                    </td>


                                    <td>
                                        <a href="#" class="btn btn-success">Pay</a>

                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success">Decline</a>

                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>