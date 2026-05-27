<?php breadcrumb_start('ratings', 'list/ratings', 'ratings_list'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Rating</lable>
                            <input type="number" class="form-control" id="rate" name="rate" placeholder="Ratings* " required>
                            <small class="form-text text-muted">
                                <span class="text-danger mr-1">*</span>Required Fields
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Comment</lable>
                            <textarea type="text" class="form-control" id="comment" name="comment" placeholder="Comment* " required></textarea>
                            <small class="form-text text-muted">
                                <span class="text-danger mr-1">*</span>Required Fields
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Employee</lable>
                            <select class="selectpicker form-control" name="employee_id" data-live-search="true" title="Select Employee* ">
                                <?php foreach ($ratee as $key => $value) : ?>
                                    <option value="<?php is($value['id'], 'show'); ?>">
                                        <?php is($value['name'], 'showCapital'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">
                                <span class="text-danger mr-1">*</span>Required Fields
                            </small>
                        </div>
                    </div>
                </div>

                <div class="ml-xl-5">
                    <button type="submit" name="addRatings" value="sfddsfs" class="ml-xl-4 btn btn-primary mt-4">Add Ratings</button>
                </div>
            </form>
        </div>
    </div>
</div>