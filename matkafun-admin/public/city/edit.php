<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('city', 'list/city', 'city_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3" method="POST" enctype="multipart/form-data">
				<div class="row">

					<div class="col-md-12">
						<label>City Name</label>
						<input type="text" class="form-control" id="city" name="city" placeholder="City Name " value="<?php is($categoryData->city, 'showCapital'); ?>">

					</div>

				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<label>City Name In Hindi</label>
						<input type="text" class="form-control" id="city_hindi" name="city_hindi" placeholder="City Name In Hindi" value="<?php is($categoryData->city_hindi, 'show'); ?>">

					</div>


				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<label>City Name In Tamil</label>
						<input type="text" class="form-control" id="city_tamil" name="city_tamil" placeholder="City Name In Tamil" value="<?php is($categoryData->city_tamil, 'show'); ?>">

					</div>


				</div>
				<br>

				<div class="row">
					<div class="col-md-12">
						<label>Icon</label>
						<?php strpos($categoryData->icon, '@') and $images = explode('@', $categoryData->icon) or $images = $categoryData->icon;
						file_input('cityImg[]', true, $images, '60', true) ?>
					</div>
				</div>

				<button type="submit" name="editCity" value="sfddsfs" class="btn btn-primary mt-4">Update City</button>
			</form>
		</div>
	</div>
</div>