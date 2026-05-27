<?php breadcrumb_start('app_image', 'list/firstaid', 'app_image_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3 py-5" method="POST" enctype="multipart/form-data">
				<div class="row">

					<div class="form-group">
						<label for="productBnr">More App Image</label>
						<div class="input-group">
							<div class="custom-file">
								<input name="stylist_doc[]" multiple accept="image/*" type="file" class="custom-file-input" id="productBnr">
								<label class="custom-file-label" for="productBnr">Choose file</label>
							</div>
						</div>
					</div>
				</div>
				<br>

				<div class="ml-xl-5">
					<button type="submit" name="addfirstaid" value="sfddsfs" class="ml-xl-4 btn btn-primary mt-4">Add Image</button>
				</div>
			</form>
		</div>
	</div>
</div>