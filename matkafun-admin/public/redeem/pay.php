<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 shadow">
            <form class="p-3 py-5" method="POST" enctype="multipart/form-data">
                <?php if (!empty($redeemData)) : ?>
                    <input type="hidden" value="1" name="payment_status">
                    <input type="hidden" value="REDEEM" name="reason">
                    <input type="hidden" value="debit" name="credit_debit">
                    <div class="row">

                        <div class="col-md-6">
                            <label>Wallet Amount</label>
                            <input type="text" class="form-control" name="wallet_amount" value=" <?php is($redeemData->wallet_amount, 'showCapital'); ?>" placeholder="Wallet Amount ">

                        </div>
                        <div class="col-md-6" class="form-control">
                            <label>Request Amount </label>
                            <input type="text" class="form-control" name="request_amount" value="<?php is($redeemData->request_amount, 'showCapital'); ?>" placeholder="Request Amount ">

                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-12 ">
                        <label> Comment</label>
                        <input type="text" class="form-control" name="comment" placeholder="Comment">

                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <?php file_input('redeemImg'); ?>

                </div>

                <div class="ml-xl-5">
                    <button type="submit" name="addPay" value="sfddsfs" class="ml-xl-4 btn btn-primary mt-4">Add Pay</button>
                </div>
            </form>
        </div>



    </div>

</div>
</div>
</div>