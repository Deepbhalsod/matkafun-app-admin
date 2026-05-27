<div class="container">
    <div class="main-body">
        <style>
            p {
                color: var(--main-col-) !important;
            }

            #cancel-row {
                overflow: auto;
                gap: 2pc;
                padding-left: 2pc;
                display: flex;
                align-items: center;
                flex-direction: column;
                border-radius: 0.5pc;
                padding: 2pc;
                box-shadow: 4px 9px 49px -10px #2a223f18;
            }

            .list-group-item {
                position: relative;
                display: block;
                padding: 0.75rem 1.25rem;
                background-color: #fff;
                border: 1px solid #fff;
            }

            hr {
                border-top: 1px solid #fff !important;
            }

            @media only screen and (max-width: 500px) {
                h4 {
                    text-align: center;
                }

                #cancel-row {
                    padding-left: 0pc;
                    padding: 0pc;
                }

                .layout-spacing {
                    padding-bottom: 0px;
                }

                .widget-content-area {
                    padding: 5px;
                }
            }
        </style>
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">

                <div class="card">
                    <div class="mt-3">
                        <div class="d-flex flex-column align-items-center text-center">
                            <?php if ($userperData->profile_image != '') { ?>
                                <img src="<?= SITE_URL ?>uploads/
                    <?php echo $userperData->profile_image; ?>" alt="User" class="rounded-circle" width="150">
                            <?php } else { ?>
                                <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                <lord-icon src="https://cdn.lordicon.com/eszyyflr.json" trigger="hover"
                                    colors=" primary:#1c274c,secondary:#6f6af8" style="width:200px;height:200px">
                                </lord-icon>
                            <?php } ?>

                            <div class=" mt-3">
                                <h4>
                                    <?php echo $userperData->username ?>
                                </h4>
                                <p class="text-secondary mb-1">
                                    <?php echo $userperData->email; ?>
                                </p>
                                <p class="text-secondary mb-1">
                                    <?php echo $userperData->mobile; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4  mb-3">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">Security Pin:</h6>
                            <span class="text-secondary">
                                <?php echo $userperData->pin; ?>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">Active</h6>
                            <span class="badge outline-badge-danger">Yes</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">T P</h6>
                            <span class="badge outline-badge-danger">No</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

                            <a href="<?= SITE_URL ?>User/change_delete/<?php echo $userperData->id; ?>"><span
                                    class="badge outline-badge-danger">Delete</span></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">Available balance:</h6>
                            <span class="text-secondary">
                                <?php echo $userperData->available_points; ?>
                            </span>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-4  mb-3">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap"
                            data-toggle="modal" data-target="#myModal">

                            <span class="badge badge-success">Add Fund</span>

                        </li>
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <div class="modal-header">

                                        <h4 class="modal-title">Add Fund</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form
                                            action="<?php echo SITE_URL; ?>User/add_fund_adm/<?php echo $userperData->id; ?>"
                                            method="post" class="w-100 formDesignCustom">
                                            <div class="form-group">
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <input class="form-control" name="points" type="text"
                                                            placeholder="Points">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <button type="submit" class="btn btn-info btn-lg"
                                                            formaction="<?php echo SITE_URL; ?>User/add_fund_adm/<?php echo $userperData->id; ?>">Submit</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class=" modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                 </div> -->
                                </div>
                            </div>
                        </div>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap"
                            data-toggle="modal" data-target="#withdrawModal">

                            <span class="badge badge-danger">Withdraw Fund</span>
                        </li>
                        <div class="modal fade" id="withdrawModal" role="dialog">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <div class="modal-header">

                                        <h4 class="modal-title">Add Withdraw</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form
                                            action="<?php echo SITE_URL; ?>User/add_withdraw_adm/<?php echo $userperData->id; ?>"
                                            method="post" class="w-100 formDesignCustom">
                                            <div class="form-group">
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <input class="form-control" name="points" type="text"
                                                            placeholder="Points">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <button type="submit" class="btn btn-info btn-lg"
                                                            formaction="<?php echo SITE_URL; ?>User/add_withdraw_adm/<?php echo $userperData->id; ?>">Submit</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class=" modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                 </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <a href="<?php echo SITE_URL ?>payment_list/user/<?php echo $userperData->id; ?>">
                                <h6 class="mb-0">Payment Information</h6>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">

                            <a href="<?php echo SITE_URL ?>fund_credit_list/user/<?php echo $userperData->id; ?>">
                                <h6 class="mb-0">Fund Credit Report</h6>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <a href="<?php echo SITE_URL ?>fund_dedit_list/user/<?php echo $userperData->id; ?>">
                                <h6 class="mb-0">Fund Debit Report</h6>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <a href="<?php echo SITE_URL ?>fund_req_list/user/<?php echo $userperData->id; ?>">
                                <h6 class="mb-0">Fund Request List</h6>
                            </a>
                        </li> -->

                    </ul>
                </div>
            </div>
            <div class="col-md-10">

                <div class="card mt-10">

                    <div class="card-body-profile">
                        <h6 class="mb-0">Personal Information </h6>
                        <br>

                        <div class="row">
                            <div class="col-md-6">

                                <p class="mb-0">Full Name:
                                    <?php echo $userperData->username ?>
                                </p>

                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">Email:
                                    <?php echo ($userperData->email) ? ($userperData->email) : 'NA'; ?>
                                </p>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">Mobile:
                                    <?php echo ($userperData->mobile) ? ($userperData->mobile) : 'NA'; ?>
                                </p>

                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">Password:

                                    <?php $hash_pass = base64_decode($userperData->password);
                                    echo ($hash_pass) ?? 'NA'; ?>
                                </p>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">District Name:
                                    <?php echo "NA"; ?>
                                </p>

                            </div>
                            <div class="col-md-6">

                                <p class="mb-0">Flat/Plot No. :

                                    <?php echo 'NA'; ?>
                                </p>

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">Address Lane 1:
                                    <?php echo 'NA'; ?>
                                </p>

                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">Address Lane 2:
                                    <?php echo 'NA'; ?>
                                </p>


                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">Area:
                                    <?php echo 'NA'; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">Pin Code:
                                    <?php echo 'NA'; ?>
                                </p>

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">State Name:
                                    <?php echo 'NA'; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0">Creation Date:
                                    <?php echo ($userperData->registred_date) ? ($userperData->registred_date) : 'NA'; ?>
                                </p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <br><br>
        <h4>Payment Details: </h4>
        <br>
        <div class="col-md-10">

            <div class="card mt-10">

                <div class="card-body-profile">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">Paytm Mobile No.:
                                <?php echo ($userperData->paytm_mobile_no) ? ($userperData->paytm_mobile_no) : 'NA'; ?>
                            </p>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">Phone Pe Mobile No.:
                                <?php echo ($userperData->phonepe_mobile_no) ? ($userperData->phonepe_mobile_no) : 'NA'; ?>
                            </p>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">GooglePay Mobile No. :
                                <?php echo ($userperData->gpay_mobile_no) ? ($userperData->gpay_mobile_no) : 'NA'; ?>
                            </p>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">Bank Name:
                                <?php echo ($userperData->bank_name) ? ($userperData->bank_name) : 'NA'; ?>
                            </p>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">Branch Address:
                                <?php echo ($userperData->branch_address) ? ($userperData->branch_address) : 'NA'; ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">A/c Holder Name:
                                <?php echo ($userperData->account_holder_name) ? ($userperData->account_holder_name) : 'NA'; ?>
                            </p>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">IFSC Code:
                                <?php echo ($userperData->ifsc_code) ? ($userperData->ifsc_code) : 'NA'; ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0">A/c No.
                                <?php echo ($userperData->bank_account_no) ? ($userperData->bank_account_no) : 'NA'; ?>
                            </p>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <h4>Fund Credit Report: </h4>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="perfectPACMANscores" class="style-3 table table-hover" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 2%">#</th>
                                        <th>User Phone No.</th>
                                        <th>Username</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    if (!empty($funds)):
                                        foreach ($funds as $keyfunds => $value_funds):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>.
                                                </td>

                                                <td class="text-center">

                                                    <?php if (empty($value_funds->user_id)) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_funds->user_id]);
                                                        if ($return) {
                                                            $return1 = $return->mobile;
                                                            if ($return1) {
                                                                echo ucfirst($return1);
                                                            } else {
                                                                echo "N.A.";
                                                            }
                                                        } else {
                                                            echo "N.A.";
                                                        }
                                                    } ?>

                                                </td>
                                                <td class="text-center">
                                                    <?php if (empty($value_funds->user_id)) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_funds->user_id]);
                                                        if ($return) {
                                                            $return1 = $return->username;
                                                            if ($return1) {
                                                                echo ucfirst($return1);
                                                            } else {
                                                                echo "N.A.";
                                                            }
                                                        } else {
                                                            echo "N.A.";
                                                        }
                                                    } ?>


                                                </td>

                                                <td class="text-center">
                                                    +
                                                    <?php echo ($value_funds->points); ?>

                                                </td>

                                                <td class="text-center">
                                                    <?php echo $value_funds->created_at ? date("d-m-Y H:i:s", strtotime($value_funds->created_at)) : "N.A."; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_funds->rem); ?>
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
        <br>
        <br>
        <h4>Fund Debit Report: </h4>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="fundebit" class="style-3 table table-hover" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 2%">#</th>
                                        <th>User Phone No.</th>
                                        <th>Username</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    if (!empty($debit)):
                                        foreach ($debit as $keydebit => $value_debit):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>.
                                                </td>

                                                <td class="text-center">

                                                    <?php if (empty($value_debit->user_id)) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_debit->user_id]);
                                                        if ($return) {
                                                            $return1 = $return->mobile;
                                                            if ($return1) {
                                                                echo ucfirst($return1);
                                                            } else {
                                                                echo "N.A.";
                                                            }
                                                        } else {
                                                            echo "N.A.";
                                                        }
                                                    } ?>

                                                </td>
                                                <td class="text-center">
                                                    <?php if (empty($value_debit->user_id)) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_debit->user_id]);
                                                        if ($return) {
                                                            $return1 = $return->username;
                                                            if ($return1) {
                                                                echo ucfirst($return1);
                                                            } else {
                                                                echo "N.A.";
                                                            }
                                                        } else {
                                                            echo "N.A.";
                                                        }
                                                    } ?>


                                                </td>

                                                <td class="text-center">
                                                    -
                                                    <?php echo ($value_debit->points); ?>

                                                </td>

                                                <td class="text-center">
                                                    <?php echo $value_debit->created_at ? date("d-m-Y H:i:s", strtotime($value_debit->created_at)) : "N.A."; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_debit->rem); ?>
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
        <br>
        <br>
        <h4>Fund Request Details</h4>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="fundreq" class="style-3 table table-hover" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 2%">#</th>
                                        <th>Username</th>
                                        <th>Points</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    if (!empty($req)):
                                        foreach ($req as $keyreq => $value_req):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>.
                                                </td>

                                                <td class="text-center">

                                                    <?php if (empty($value_req->user_id)) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_req->user_id]);
                                                        if ($return) {
                                                            $return1 = $return->username;
                                                            if ($return1) {
                                                                echo ucfirst($return1);
                                                            } else {
                                                                echo "N.A.";
                                                            }
                                                        } else {
                                                            echo "N.A.";
                                                        }
                                                    } ?>

                                                </td>


                                                <td class="text-center">
                                                    <?php echo $value_req->points; ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php
                                                    if ($value_req->created_at !== "0000-00-00 00:00:00") {

                                                        $date = $value_req->created_at;

                                                        $time = date("d-m-Y H:i:s", strtotime($date));

                                                    } else {
                                                        $time = "00-00-0000";
                                                    }
                                                    ?>
                                                    <p>
                                                        <?php echo ($time); ?>
                                                    </p>

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
        <br>
        <br>
        <h4>Bid History Details</h4>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="bidhis" class="style-3 table table-hover" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 2%">#</th>
                                        <th>Date</th>
                                        <th>Username</th>
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
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    if (!empty($BidData)):
                                        foreach ($BidData as $key_Bid => $value_Bid):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>.
                                                </td>

                                                <td class="text-center">
                                                    <?= date("d-m-Y H:i:s", strtotime($value_Bid['bidded_at'])); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php if (empty($value_Bid['user_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_Bid['user_id']]);
                                                        if ($return) {
                                                            $return1 = $return->username;
                                                            if ($return1) {
                                                                echo ucfirst($return1);
                                                            } else {
                                                                echo "N.A.";
                                                            }
                                                        } else {
                                                            echo "N.A.";
                                                        }
                                                    } ?>

                                                </td>


                                                <td class="text-center">

                                                    <?php if (empty($value_Bid['game_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('games', ['id' => $value_Bid['game_id']]);
                                                        if ($return) {
                                                            $return1 = $return->name;
                                                            if ($return1) {
                                                                echo ucfirst($return1);
                                                            } else {
                                                                echo "N.A.";
                                                            }
                                                        } else {
                                                            echo "N.A.";
                                                        }
                                                    } ?>

                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_Bid['game_type']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_Bid['session']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_Bid['open_panna']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_Bid['open_digit']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_Bid['close_panna']); ?>
                                                </td>
                                                <td class="text-center">

                                                    <?php echo ($value_Bid['close_digit']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_Bid['bid_points']); ?>
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
        <br>
        <br>
        <h4>Win History Details</h4>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="winhis" class="style-3 table table-hover" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 2%">#</th>
                                        <th>Date</th>
                                        <th>Username</th>
                                        <th>Game Name</th>
                                        <th>Game Type</th>
                                        <th>Session</th>
                                        <th>Open Pana</th>
                                        <th>Open Result</th>
                                        <th>Close Pana</th>
                                        <th>Close Result</th>
                                        <th>Bid Points</th>
                                        <th>Win Points</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    if (!empty($winData)):
                                        foreach ($winData as $key_winDatad => $value_winData):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>.
                                                </td>

                                                <td class="text-center">
                                                    <?= date("d-m-Y H:i:s", strtotime($value_winData['bidded_at'])); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php if (empty($value_winData['user_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_winData['user_id']]);
                                                        if ($return) {
                                                            $return1 = $return->username;
                                                            if ($return1) {
                                                                echo ucfirst($return1);
                                                            } else {
                                                                echo "N.A.";
                                                            }
                                                        } else {
                                                            echo "N.A.";
                                                        }
                                                    } ?>

                                                </td>


                                                <td class="text-center">

                                                    <?php if (empty($value_winData['game_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('games', ['id' => $value_winData['game_id']]);
                                                        if ($return) {
                                                            $return1 = $return->name;
                                                            if ($return1) {
                                                                echo ucfirst($return1);
                                                            } else {
                                                                echo "N.A.";
                                                            }
                                                        } else {
                                                            echo "N.A.";
                                                        }
                                                    } ?>

                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_winData['game_type']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_winData['session']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_winData['open_panna']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_winData['open_digit']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_winData['close_panna']); ?>
                                                </td>
                                                <td class="text-center">

                                                    <?php echo ($value_winData['close_digit']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_winData['bid_points']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php echo ($value_winData['win_points']); ?>
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
        <br>
        <br>
        <h4>Gali Disawar Bid History Details</h4>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="gdbidhis" class="style-3 table table-hover" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 2%">#</th>
                                        <th>Date</th>
                                        <th>Username</th>
                                        <th>Game Name</th>
                                        <th>Game Type</th>
                                        <th>Left Digit</th>
                                        <th>Right Digit</th>
                                        <th>Points</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    if (!empty($GD_BidData)):
                                        foreach ($GD_BidData as $value_GD_Bid):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>.
                                                </td>
                                                <td class="text-center">
                                                    <?= date("d-m-Y H:i:s", strtotime($value_GD_Bid['bidded_at'])); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (empty($value_GD_Bid['user_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_GD_Bid['user_id']]);
                                                        echo $return ? ucfirst($return->username) : "N.A.";
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (empty($value_GD_Bid['game_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('gali_disawar_game', ['id' => $value_GD_Bid['game_id']]);
                                                        echo $return ? ucfirst($return->name) : "N.A.";
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_GD_Bid['game_type']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_GD_Bid['left_digit']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_GD_Bid['right_digit']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_GD_Bid['bid_points']); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No Records Found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <br>
        <h4>Gali Disawar Win History Details</h4>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="gdwinhis" class="style-3 table table-hover" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 2%">#</th>
                                        <th>Date</th>
                                        <th>Username</th>
                                        <th>Game Name</th>
                                        <th>Game Type</th>
                                        <th>Left Digit</th>
                                        <th>Right Digit</th>
                                        <th>Bid Points</th>
                                        <th>Win Points</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    if (!empty($GD_winData)):
                                        foreach ($GD_winData as $value_GD_win):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>.
                                                </td>
                                                <td class="text-center">
                                                    <?= date("d-m-Y H:i:s", strtotime($value_GD_win['bidded_at'])); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (empty($value_GD_win['user_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_GD_win['user_id']]);
                                                        echo $return ? ucfirst($return->username) : "N.A.";
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (empty($value_GD_win['game_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('gali_disawar_game', ['id' => $value_GD_win['game_id']]);
                                                        echo $return ? ucfirst($return->name) : "N.A.";
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_GD_win['game_type']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_GD_win['left_digit']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_GD_win['right_digit']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_GD_win['bid_points']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_GD_win['win_points']); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No Records Found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <br>
        <h4>Starline Bid History Details</h4>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="slbidhis" class="style-3 table table-hover" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 2%">#</th>
                                        <th>Date</th>
                                        <th>Username</th>
                                        <th>Game Name</th>
                                        <th>Game Type</th>
                                        <th>Digit</th>
                                        <th>Panna</th>
                                        <th>Points</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    if (!empty($SL_BidData)):
                                        foreach ($SL_BidData as $value_SL_Bid):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>.
                                                </td>
                                                <td class="text-center">
                                                    <?= date("d-m-Y H:i:s", strtotime($value_SL_Bid['bidded_at'])); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (empty($value_SL_Bid['user_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_SL_Bid['user_id']]);
                                                        echo $return ? ucfirst($return->username) : "N.A.";
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (empty($value_SL_Bid['game_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('starline_game', ['id' => $value_SL_Bid['game_id']]);
                                                        echo $return ? ucfirst($return->name) : "N.A.";
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_SL_Bid['game_type']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_SL_Bid['digit']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_SL_Bid['panna']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_SL_Bid['bid_points']); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No Records Found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <br>
        <h4>Starline Win History Details</h4>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="slwinhis" class="style-3 table table-hover" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 2%">#</th>
                                        <th>Date</th>
                                        <th>Username</th>
                                        <th>Game Name</th>
                                        <th>Game Type</th>
                                        <th>Digit</th>
                                        <th>Panna</th>
                                        <th>Bid Points</th>
                                        <th>Win Points</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    if (!empty($SL_winData)):
                                        foreach ($SL_winData as $value_SL_win):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>.
                                                </td>
                                                <td class="text-center">
                                                    <?= date("d-m-Y H:i:s", strtotime($value_SL_win['bidded_at'])); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (empty($value_SL_win['user_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_SL_win['user_id']]);
                                                        echo $return ? ucfirst($return->username) : "N.A.";
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (empty($value_SL_win['game_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('starline_game', ['id' => $value_SL_win['game_id']]);
                                                        echo $return ? ucfirst($return->name) : "N.A.";
                                                    } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_SL_win['game_type']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_SL_win['digit']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_SL_win['panna']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_SL_win['bid_points']); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo ($value_SL_win['win_points']); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No Records Found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <br>
        <h4>Withdraw Request Details</h4>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form method="post">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="winreq" class="style-3 table table-hover" style="width:100%">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 2%">#</th>
                                        <th>Username</th>
                                        <th>Points</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $i = 1;
                                    if (!empty($withdraw_data)):
                                        foreach ($withdraw_data as $keywithdraw => $value_withdraw):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>.
                                                </td>

                                                <td class="text-center">

                                                    <?php if (empty($value_withdraw['user_id'])) {
                                                        echo "N.A.";
                                                    } else {
                                                        $return = get_signle_data_from('users', ['id' => $value_withdraw['user_id']]);
                                                        if ($return) {
                                                            $return1 = $return->username;
                                                            if ($return1) {
                                                                echo ucfirst($return1);
                                                            } else {
                                                                echo "N.A.";
                                                            }
                                                        } else {
                                                            echo "N.A.";
                                                        }
                                                    } ?>

                                                </td>


                                                <td class="text-center">
                                                    <?php echo $value_withdraw['points']; ?>
                                                </td>

                                                <td class="text-center">

                                                    <?php
                                                    if ($value_withdraw['created_at'] !== "0000-00-00 00:00:00") {

                                                        $date = $value_withdraw['created_at'];

                                                        $time = date("d-m-Y H:i:s", strtotime($date));

                                                    } else {
                                                        $time = "00-00-0000";
                                                    }
                                                    ?>
                                                    <p>
                                                        <?php echo ($time); ?>
                                                    </p>

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
    </div>
</div>