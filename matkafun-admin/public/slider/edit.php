<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('slider', 'list/sliders', 'slider_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
						<input type="text" class="form-control" id="title" name="title" value="<?php is($sliderData->title, 'show') ?>" placeholder="Title *">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>
				</div>
				<br><br>
				<!-- Category Image -->
				<!--<?php file_input('sliderImg', true, $sliderData->image); ?>-->
				<div class="row">
				
					<div class="col-md-12">
					    	<?php file_input('sliderImg', $sliderData->image); ?>
					
					</div>
				</div>

				<button type="submit" name="editSlider" value="sfddsfs" class="btn btn-primary mt-4">Update Slider</button>
			</form>
		</div>
	</div>
</div>