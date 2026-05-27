<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 shadow">
            <form class="p-3 py-5" method="POST" enctype="multipart/form-data">

                <input type="hidden" value="3" name="payment_status">

                <div class="row">
                    <div class="col-md-12 ">
                        <label> Comment</label>
                        <input type="text" class="form-control" name="comment" placeholder="Comment">

                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <?php file_input('declineImg'); ?>

                </div>

                <div class="ml-xl-5">
                    <button type="submit" name="decline" value="sfddsfs" class="ml-xl-4 btn btn-primary mt-4">Decline</button>
                </div>
            </form>
        </div>



    </div>

</div>
</div>
</div>