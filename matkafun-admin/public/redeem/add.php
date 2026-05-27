<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 shadow">
            <form class="p-3 py-5" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <input type="text" class="form-control" name="request_amount" placeholder="Request Amount * " required>
                            <small class="form-text text-muted">
                                <span class="text-danger mr-1">*</span>Required Fields
                            </small>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <select class="selectpicker form-control tagging" name="user_id" data-live-search="true" title=" Select Category ">
                            <?php foreach ($users as $value) : ?>
                                <option value="<?php echo $value->id;
                                                ?>">
                                    <?php echo ucwords($value->username); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
               

                <div class="ml-xl-5">
                    <button type="submit" name="addRedeem" value="sfddsfs" class="ml-xl-4 btn btn-primary mt-4">Add Slider</button>
                </div>
            </form>
        </div>
    </div>
</div>