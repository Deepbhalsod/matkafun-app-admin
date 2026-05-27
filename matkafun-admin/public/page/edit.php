<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('Pages', 'edit/page', 'user_list');

?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6 shadow">
            <form class="p-3" method="POST" enctype="multipart/form-data">

                <!-- First Name & Last Name -->
                <div class="row">

                    <div class="col-md-12">
                        <label>About</label></label>
                        <div class="form-group">
                            <textarea name="about" id="editor3" rows="10" cols="80" class="form-control" placeholder="About"><?php is($settingData->about, 'show'); ?></textarea>
                            <small class="form-text text-muted">
                                <span class="text-danger mr-1">*</span>Required Fields
                            </small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4" name="editPages" value="editUser">Edit Page</button>
            </form>
        </div>
    </div>
</div>