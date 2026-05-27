<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('ratings', 'list/ratings', 'ratings_list'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 shadow">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <input type="number" class="form-control" id="rate" name="rate" value="<?php is($ratingssssData->rate, 'show') ?>" placeholder="Ratings* " required>
                            <small class="form-text text-muted">
                                <span class="text-danger mr-1">*</span>Required Fields
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <textarea type="text" class="form-control" id="comment" name="comment" placeholder="Comment* " required><?php is($ratingssssData->extra, 'show') ?></textarea>
                            <small class="form-text text-muted">
                                <span class="text-danger mr-1">*</span>Required Fields
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <select class="selectpicker form-control" name="employee_id" data-live-search="true" title="Select Employee* ">
                                <?php foreach ($ratinggg as $key => $value) : ?>
                                    <option value="<?php is($value['id'], 'show'); ?>" <?= ($value['id'] == $ratingssssData->employee_id) ? 'selected' : ''; ?>>
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
                <br><br>

                <button type="submit" name="editRatings" value="sfddsfs" class="btn btn-primary mt-4">Update Ratings</button>
            </form>
        </div>
    </div>
</div>