<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php empty($sliderData) and show_404() or breadcrumb_start('slider', 'list/sliders', 'slider_list');

?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3" method="POST" enctype="multipart/form-data">

				<div class="row">
					<div class="col-md-12">
						<label>Banner Image</label>
						<?php file_input('bannerImg', true, $sliderData->image); ?>


					</div>


				</div>

				<!-- Category Image -->


				<button type="submit" name="editbanner" value="sfddsfs" class="btn btn-primary mt-4">Update Banner</button>
			</form>
		</div>
	</div>
</div>