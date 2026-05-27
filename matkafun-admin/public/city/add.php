<?php breadcrumb_start('city', 'list/city', 'city_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 offset-lg-3 layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3" method="POST" enctype="multipart/form-data">
				<div class="row">

					<div class="col-md-12">
						<label>City Name</label>
						<input type="text" class="form-control" id="city" name="city" placeholder="City Name* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>

				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<label>City Name In Hindi</label>
						<input type="text" class="form-control" id="city_hindi" name="city_hindi" placeholder="City Name In Hindi* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>


				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<label>City Name In Tamil</label>
						<input type="text" class="form-control" id="city_tamil" name="city_tamil" placeholder="City Name In Tamil* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>


				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<label>City Icon</label>
						<?php file_input('cityImg'); ?>
					</div>


				</div>
				<br>

				<button type="submit" name="addcity" value="sfddsfs" class="btn btn-primary mt-4">Add City</button>
			</form>
		</div>
	</div>
</div>