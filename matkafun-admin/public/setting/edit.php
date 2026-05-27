<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3" method="POST" enctype="multipart/form-data">
				<?php if (search_in($settingData->option_value, ['.jpg', '.png', '.jpeg'])) : ?>
					<?php file_input('option_value', true, $settingData->option_value); ?>
				<?php else : ?>
					<?php if (search_in($settingData->option_value, ['Auto', 'Manual'])) : ?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-4">
									<select class="form-control" name="option_value" id="is_featured" title="Select status">
										<option value="Auto Activation" <?php if ($settingData->option_value == "Auto Activation") { ?> selected <?php } ?>>Auto Activation</option>
										<option value="Manual" <?php if ($settingData->option_value == "Manual") { ?> selected <?php } ?>>Manual</option>
									</select>
								</div>
							</div>
						</div>
					<?php else : ?>
    					<?php if (search_in($settingData->option_key, ['web_logo','admin_favicon','web_favicon','banner_img_1','banner_img_2','banner_img_3','admin_logo','
    					web_favicon'])) :
    					    $img_bnr = ($settingData->option_value);
                //                                     $decoded = decodeBase64Image($img_bnr, 'setting/');
												    // $logo =SITE_URL."uploads/setting/".$decoded;
    					
    					 ?>
    						<div class="row">
    							<div class="col-md-6">
    								<div class="form-group mb-4">
    									<img src="<?php echo($img_bnr); ?>" class="img-fluid shadow rounded-lg" alt="<?php is($settingData->option_key, 'show'); ?>">
    								</div>
    							</div>
    							<div class="col-md-6">
    								<div class="form-group mb-4">
    									<input name="option_value" type="file" id="productproBnr">
    								</div>
    							</div>
    						</div>
    						<!--<?php file_input('option_value', true, $settingData->option_value); ?>-->
    					<?php else : ?>
    						<div class="row">
    							<div class="col-md-12">
    								<div class="form-group mb-4">
    									<input type="text" class="form-control" id="option_value" name="option_value" placeholder="Setting Value *" minlength="1" value="<?php is($settingData->option_value, 'show'); ?>">
    									<small class="form-text text-muted">
    										<span class="text-danger mr-1">*</span>Required Fields
    									</small>
    								</div>
    							</div>
    						</div>
    					<?php endif; ?>
						<!--<div class="row">-->
						<!--	<div class="col-md-12">-->
						<!--		<div class="form-group mb-4">-->
						<!--			<input type="text" class="form-control" id="option_value" name="option_value" placeholder="Setting Value *" minlength="1" value="<?php is($settingData->option_value, 'show'); ?>">-->
						<!--			<small class="form-text text-muted">-->
						<!--				<span class="text-danger mr-1">*</span>Required Fields-->
						<!--			</small>-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->
					<?php endif; ?>
				<?php endif; ?>

				<button type="submit" name="editSetting" value="sfddsfs" class="btn btn-primary mt-4">Update <?php is($settingData->option_key) and print(ucwords(str_replace('_', ' ', str_replace('social_', '', str_replace('site_', '', $settingData->option_key))))); ?></button>
			</form>
		</div>
	</div>
</div>
