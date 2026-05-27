<?php breadcrumb_start('slider', 'list/sliders', 'slider_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">
			<form class="p-3" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group mb-6">
							<label>Slider Title</label>
							<input type="text" class="form-control" id="title" name="title" placeholder="Title* " required>
							<small class="form-text text-muted">
								<span class="text-danger mr-1">*</span>Required Fields
							</small>
						</div>
					</div>
				</div>

				<!-- Category Image -->
				<label>Slider Image</label>
				<?php file_input('sliderImg'); ?>

				<div class="ml-xl-5">
					<button type="submit" name="addSlider" value="sfddsfs" class="ml-xl-4 btn btn-primary mt-4">Add Slider</button>
				</div>
			</form>
		</div>
	</div>
</div>