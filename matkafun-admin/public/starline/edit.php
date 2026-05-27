<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 shadow">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Name</lable>
                             <input type="text" class="form-control" id="name" name="name" value="<?php echo $ratingssssData['name']; ?>">
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Time</lable>
                            <input type="time" class="form-control" id="time" name="time" placeholder="Time* " required value="<?php echo $ratingssssData['time']; ?>">
                        </div>
                    </div>
                </div>
                <button type="submit" name="editgamestarline" value="sfddsfs" class="btn btn-primary mt-4">Update Game</button>
            </form>
        </div>
    </div>
</div>