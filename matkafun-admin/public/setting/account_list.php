<?php breadcrumb_start('game', 'list/game', 'game_list'); ?>


<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-black">App Status</h4>
                    <form class="p-3" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <select class="form-control" name="app_live_status" id="is_featured"
                                        title="Select status">
                                        <option value="">Select</option>
                                        <option value="Live" <?php if ($full_sangam_Data['app_live_status'] == "Live") { ?> selected <?php } ?>>Live</option>
                                        <option value="Development" <?php if ($full_sangam_Data['app_live_status'] == "Development") { ?> selected <?php } ?>>Development</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-6">
                                    <button type="submit" name="addappstatus" value="addappstatus"
                                        class="ml-xl-4 btn btn-primary mt-4">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <h4 class="text-black">Automatic Result Update</h4>
                    <form class="p-3" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <select class="form-control" name="auto_result_status" id="is_featured"
                                        title="Select status">
                                        <option value="">Select</option>
                                        <option value="Yes" <?php if ($full_sangam_Data['auto_result'] == "Yes") { ?>
                                                selected <?php } ?>>Yes</option>
                                        <option value="No" <?php if ($full_sangam_Data['auto_result'] == "No") { ?>
                                                selected <?php } ?>>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-6">
                                    <button type="submit" name="addautoresult" value="addautoresult"
                                        class="ml-xl-4 btn btn-primary mt-4">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <h4 class="text-black">Set visibility of section</h4>
                    <form class="p-3" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <select class="form-control" name="visibilityOfSection_result" id="is_featured"
                                        title="Select status">
                                        <option value="">Select</option>
                                        <option value="true" <?php if ($full_sangam_Data['visibilityOfSection'] == "true") { ?> selected <?php } ?>>Yes</option>
                                        <option value="false" <?php if ($full_sangam_Data['visibilityOfSection'] == "false") { ?> selected <?php } ?>>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-6">
                                    <button type="submit" name="addvisibility" value="addvisibility"
                                        class="ml-xl-4 btn btn-primary mt-4">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <h4 class="text-black">Telegram Link</h4>
                    <form class="p-3" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control" name="telegram_link"
                                        placeholder="Enter Telegram Channel Link"
                                        value="<?php echo $telegram_Data['option_value'] ?? ''; ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-6">
                                    <button type="submit" name="addtelegramLink" value="addtelegramLink"
                                        class="ml-xl-4 btn btn-primary mt-4">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>



            </div>
        </div>
    </div>
</div>


<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-black">UPI Details</h4>
                    <form class="p-3" method="POST" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group mb-6">
                                    <lable>UPI Name</lable>
                                    <input type="text" class="form-control" id="upi_name" name="upi_name"
                                        placeholder="UPI Name" value="<?php echo $full_sangam_Data['upi_name']; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-6">
                                    <lable>Enter Merchant or Business UPI ID</lable>
                                    <input type="text" class="form-control" id="upi_payment_id" name="upi_payment_id"
                                        placeholder="phonepe_UPI@ybl"
                                        value="<?php echo $full_sangam_Data['upi_payment_id']; ?>">
                                </div>
                            </div>


                            <div class="col-md-6" style="display:none">
                                <div class="form-group mb-6">
                                    <lable>G-PAY UPI Id</lable>
                                    <input type="text" class="form-control" id="g_pay_upi" name="g_pay_upi"
                                        placeholder="G-PAY UPI Id" value="gpay@okbizaxis">
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <div class="form-group mb-6">
                                    <lable>Phonepe UPI Id</lable>
                                    <input type="text" class="form-control" id="phonepe_upi" name="phonepe_upi"
                                        placeholder="Phonepe UPI Id" value="phonepe@ybl">
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <div class="form-group mb-6">
                                    <lable>Paytm UPI Id</lable>
                                    <input type="text" class="form-control" id="paytm_upi" name="paytm_upi"
                                        placeholder="Paytm UPI Id" value="paytm@paytm">
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <div class="form-group mb-6">
                                    <lable>Others UPI Id</lable>
                                    <input type="text" class="form-control" id="others_upi" name="others_upi"
                                        placeholder="Others UPI Id" value="other@upi">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group mb-6">
                                    <button type="submit" name="addupiAccount" value="addupiAccount"
                                        class="ml-xl-4 btn btn-primary mt-4">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>

                <!--
                <div class="col-md-6">
                    <h4>Others Settings</h4>
                    <form class="p-3" method="POST" enctype="multipart/form-data">
                            <div class="row">
                              
                                <div class="col-md-6">
                                    <div class="form-group mb-6">
                                        <lable>Market Open Time</lable>
                                        <input type="time" class="form-control" id="market_open_time" name="market_open_time" placeholder="Market Open Time" value="<?php echo $full_sangam_Data['market_open_time']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-6">
                                        <lable>Alert Message</lable>
                                        <input type="text" class="form-control" id="alert_message" name="alert_message" placeholder="Triple Pana Value 1 " value="<?php echo $full_sangam_Data['alert_message']; ?>">
                                    </div>
                                </div>
                           
                                <div class="col-md-12">
                                    <div class="form-group mb-6">
                                        <button type="submit" name="addotherAccount" value="addotherAccount" class="ml-xl-4 btn btn-primary mt-4">Submit</button>
                                    </div>
                                </div>
                                
                            </div>
                    </form>
                </div>
                -->

            </div>
        </div>
    </div>
</div>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">

            <form class="p-3" method="POST" enctype="multipart/form-data">
                <h4 class="text-black">Add Values</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Minimum Deposit Amount</lable>
                            <input type="text" class="form-control" id="minimum_deposite" name="minimum_deposite"
                                placeholder="Minimum Deposite"
                                value="<?php echo $full_sangam_Data['minimum_deposit']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Maximum Deposit Amount</lable>
                            <input type="text" class="form-control" id="maximum_deposite" name="maximum_deposite"
                                placeholder="Maximum Deposite"
                                value="<?php echo $full_sangam_Data['maximum_deposit']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Minimum Withdrawal Amount</lable>
                            <input type="text" class="form-control" id="minimum_withdraw" name="minimum_withdraw" placeholder="Minimum Withdraw" value="<?php echo $full_sangam_Data['minimum_withdraw']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Maximum Withdrawal Amount</lable>
                            <input type="text" class="form-control" id="maximum_withdraw" name="maximum_withdraw" placeholder="Maximum Withdraw" value="<?php echo $full_sangam_Data['maximum_withdraw']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Minimum Bid Amount</lable>
                            <input type="text" class="form-control" id="minimum_bid_amount" name="minimum_bid_amount" placeholder="Minimum Bid Amount" value="<?php echo $full_sangam_Data['minimum_bid_amount']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Maximum Bid Amount</lable>
                            <input type="text" class="form-control" id="maximum_bid_amount" name="maximum_bid_amount" placeholder="Full Sangam Value 2 " value="<?php echo $full_sangam_Data['maximum_bid_amount']; ?>">
                        </div>
                    </div>

                </div>

                <div class="row" style="display:none;">

                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Withdrawal Open Time</lable>
                            <input type="time" class="form-control" id="withdraw_open_time" name="withdraw_open_time" placeholder="Withdraw Open Time" value="<?php echo $full_sangam_Data['withdraw_open_time']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Withdrawal Close Time</lable>
                            <input type="time" class="form-control" id="withdraw_close_time" name="withdraw_close_time"
                                placeholder="Withdraw Close Time"
                                value="<?php echo $full_sangam_Data['withdraw_close_time']; ?>">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Minimum Transfer Allowed</lable>
                            <input type="test" class="form-control" id="minimum_transfer" name="minimum_transfer"
                                placeholder="Minimum Transfer"
                                value="<?php echo $full_sangam_Data['minimum_transfer']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Maximum Transfer Allowed</lable>
                            <input type="text" class="form-control" id="maximum_transfer" name="maximum_transfer"
                                placeholder="Maximum Transfer"
                                value="<?php echo $full_sangam_Data['maximum_transfer']; ?>">
                        </div>
                    </div>

                </div>

                <div class="ml-xl-5">
                    <button type="submit" name="addvalueAccount" value="addvalueAccount"
                        class="ml-xl-4 btn btn-primary mt-4">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>