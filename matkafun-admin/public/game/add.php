<?php breadcrumb_start('game', 'list/game', 'game_list'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Name</lable>
                            <input type="text" class="form-control" id="rate" name="name" placeholder="Name* " required>
                            <small class="form-text text-muted">
                                <span class="text-danger mr-1">*</span>Required Fields
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Open Time</lable>
                            <input type="time" class="form-control" id="open_time" name="open_time" placeholder="Open Time* " required>
                            <small class="form-text text-muted">
                                <span class="text-danger mr-1">*</span>Required Fields
                            </small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Close Time</lable>
                            <input type="time" class="form-control" id="close_time" name="close_time" placeholder="Close Time* " required>
                            <small class="form-text text-muted">
                                <span class="text-danger mr-1">*</span>Required Fields
                            </small>
                        </div>
                    </div>
                </div>


                <div class="ml-xl-5">
                    <button type="submit" name="addGames" value="sfddsfs" class="ml-xl-4 btn btn-primary mt-4">Add Game</button>
                </div>
            </form>
        </div>
    </div>
</div>