<div class="row">
    <div class="col-lg-3 layout-spacing col-md-3"></div>
    <div id="browser_default" class="col-lg-6 layout-spacing col-md-6">
        <div class="statbox widget box box-shadow mt-5">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Change Status User</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="post" enctype="multipart/form-data" id="class_form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="status">Select Status</label>
                            <select name="status" id="status" class="selectpicker form-control">
                                <option value="2" <?= ($User->status == '2') ? 'selected' : ''; ?>>Inactive</option>
                                <option value="1" <?= ($User->status == '1') ? 'selected' : ''; ?>>Active</option>
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-success mt-3" name="changeStatusUser" value="sdf" type="submit">Update Status</button>
                </form>

                <div class="code-section-container">
                    <div class="code-section text-left">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>