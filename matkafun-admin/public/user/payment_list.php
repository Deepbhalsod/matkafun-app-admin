<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('user', 'list/user', 'user_list'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">

            <div class="table-responsive mb-4 mt-4">
                <table id="html5-extension" class="style-3 table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 1%">#</th>
                            <th>Bank Name</th>
                            <th>Branch Address</th>
                            <th>A/c Holder Name</th>
                            <th>A/c No.</th>
                            <th>IFSC Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($userData)) :
                            $i = 1;
                        ?>
                            <tr>
                                <td><?php echo $i++; ?>.</td>
                                <td>
                                    <?php echo ($userData['bank_name']); ?>
                                </td>

                                <td>
                                    <?php echo ($userData['branch_address']); ?>

                                </td>

                                <td>
                                    <?php echo ($userData['account_holder_name']); ?>

                                </td>

                                <td>
                                    <?php echo ($userData['bank_account_no']); ?>

                                </td>

                                <td>
                                    <?php echo ($userData['ifsc_code']); ?>

                                </td>




                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>