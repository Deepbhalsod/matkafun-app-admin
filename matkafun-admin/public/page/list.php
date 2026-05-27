<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6 shadow">
            <form class="p-3" method="POST" enctype="multipart/form-data">

                <!-- First Name & Last Name -->
                <div class="row">

                    <div class="col-md-12">
                        <label>How to Play</label></label>
                        <div class="form-group">
                            <textarea name="how_to_play" id="editor6" rows="10" cols="80" class="form-control" placeholder="How to Play"><?php is($settingData->how_to_play, 'show'); ?></textarea>

                        </div>
                    </div>
                    <!--MeenaRaj
                    <div class="col-md-12">
                        <label>Video Link</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="video_link" placeholder="Video Link" value="<?php is($settingData->video_link, 'show'); ?>">

                        </div>
                    </div>
                    -->
                </div>

                <button type="submit" class="btn btn-primary mt-4" name="editDriverPages" value="editUser">Edit Page</button>
            </form>
        </div>
    </div>
</div>