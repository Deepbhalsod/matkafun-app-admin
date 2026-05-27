<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 shadow">
            <form class="p-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Monday Status</lable>
                            <select name="mon_status" id="status" class="selectpicker form-control">
                                <option value="2" <?= ($ratingssssData['monday'] == '2') ? 'selected' : ''; ?>>Inactive</option>
                                <option value="1" <?= ($ratingssssData['monday'] == '1') ? 'selected' : ''; ?>>Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Monday Open Time</lable>
                            <input type="time" class="form-control" id="mon_open_time" name="mon_open_time" value="<?php is($ratingssssData['mon_open'], 'show') ?>" placeholder="Monday Open Time " value="">
                          
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Monday Close Time</lable>
                            <input type="time" class="form-control" id="mon_close_time" name="mon_close_time" value="<?php is($ratingssssData['mon_close'], 'show') ?>" placeholder="Monday Close Time ">
                          
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Tuesday Status</lable>
                            <select name="tue_status" id="status" class="selectpicker form-control">
                                <option value="2" <?= ($ratingssssData['tuesday'] == '2') ? 'selected' : ''; ?>>Inactive</option>
                                <option value="1" <?= ($ratingssssData['tuesday'] == '1') ? 'selected' : ''; ?>>Active</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Tuesday Open Time</lable>
                            <input type="time" class="form-control" id="tue_open_time" name="tue_open_time" value="<?php is($ratingssssData['tue_open'], 'show') ?>" placeholder="Tuesday Open Time ">
                           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Tuesday Close Time</lable>
                            <input type="time" class="form-control" id="tue_close_time" name="tue_close_time" value="<?php is($ratingssssData['tue_close'], 'show') ?>" placeholder="Tuesday Close Time">
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Wednesday Status</lable>
                            <select name="wed_status" id="status" class="selectpicker form-control">
                                <option value="2" <?= ($ratingssssData['wednesday'] == '2') ? 'selected' : ''; ?>>Inactive</option>
                                <option value="1" <?= ($ratingssssData['wednesday'] == '1') ? 'selected' : ''; ?>>Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Wednesday Open Time</lable>
                            <input type="time" class="form-control" id="wed_open_time" name="wed_open_time" value="<?php is($ratingssssData['wed_open'], 'show') ?>" placeholder="Wednesday Open Time">
                           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Wednesday Close Time</lable>
                            <input type="time" class="form-control" id="wed_close_time" name="wed_close_time" value="<?php is($ratingssssData['wed_close'], 'show') ?>" placeholder="Wednesday Close Time ">
                            
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Thursday Status</lable>
                            <select name="thu_status" id="status" class="selectpicker form-control">
                                <option value="2" <?= ($ratingssssData['thursday'] == '2') ? 'selected' : ''; ?>>Inactive</option>
                                <option value="1" <?= ($ratingssssData['thursday'] == '1') ? 'selected' : ''; ?>>Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Thursday Open Time</lable>
                            <input type="time" class="form-control" id="thu_open_time" name="thu_open_time" value="<?php is($ratingssssData['thu_open'], 'show') ?>" placeholder="Thursday Open Time ">
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Thursday Close Time</lable>
                            <input type="time" class="form-control" id="thu_close_time" name="thu_close_time" value="<?php is($ratingssssData['thu_close'], 'show') ?>" placeholder="Thursday Close Time ">
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Friday Status</lable>
                            <select name="fri_status" id="status" class="selectpicker form-control">
                                <option value="2" <?= ($ratingssssData['friday'] == '2') ? 'selected' : ''; ?>>Inactive</option>
                                <option value="1" <?= ($ratingssssData['friday'] == '1') ? 'selected' : ''; ?>>Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Friday Open Time</lable>
                            <input type="time" class="form-control" id="fri_open_time" name="fri_open_time" value="<?php is($ratingssssData['fri_open'], 'show') ?>" placeholder="Friday Open Time ">
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Friday Close Time</lable>
                            <input type="time" class="form-control" id="fri_close_time" name="fri_close_time" value="<?php is($ratingssssData['fri_close'], 'show') ?>" placeholder="Friday Close Time ">
                            
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Saturday Status</lable>
                            <select name="sat_status" id="status" class="selectpicker form-control">
                                <option value="2" <?= ($ratingssssData['saturday'] == '2') ? 'selected' : ''; ?>>Inactive</option>
                                <option value="1" <?= ($ratingssssData['saturday'] == '1') ? 'selected' : ''; ?>>Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Saturday Open Time</lable>
                            <input type="time" class="form-control" id="sate_open_time" name="sate_open_time" value="<?php is($ratingssssData['sat_open'], 'show') ?>" placeholder="Saturday Open Time ">
                          
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Saturday Close Time</lable>
                            <input type="time" class="form-control" id="sate_close_time" name="sate_close_time" value="<?php is($ratingssssData['sat_close'], 'show') ?>" placeholder="Saturday Close Time ">
                            
                        </div>
                    </div>
                </div>
                
                 <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Sunday Status</lable>
                            <select name="sun_status" id="status" class="selectpicker form-control">
                                <option value="2" <?= ($ratingssssData['sunday'] == '2') ? 'selected' : ''; ?>>Inactive</option>
                                <option value="1" <?= ($ratingssssData['sunday'] == '1') ? 'selected' : ''; ?>>Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Sunday Open Time</lable>
                            <input type="time" class="form-control" id="sun_open_time" name="sun_open_time" value="<?php is($ratingssssData['sun_open'], 'show') ?>" placeholder="Sunday Open Time ">
                          
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-6">
                            <lable>Sunday Close Time</lable>
                            <input type="time" class="form-control" id="sun_close_time" name="sun_close_time" placeholder="Sunday Close Time " value="<?php is($ratingssssData['sun_close'], 'show') ?>">
                            
                        </div>
                    </div>
                </div>


                <button type="submit" name="editgame" value="sfddsfs" class="btn btn-primary mt-4">Update Game</button>
            </form>
        </div>
    </div>
</div>