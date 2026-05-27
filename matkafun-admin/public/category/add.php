<?php breadcrumb_start('categories', 'list/categories', 'category_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 offset-lg-3 layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<label>Category Title</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="Title* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>

					<div class="col-md-6">
						<label>Short Description</label>
						<input type="text" class="form-control" id="title" name="desc" placeholder="Short Description* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>

				</div>

				<div class="row">
					<div class="col-md-6">
						<label>Title In Tamil</label>
						<input type="text" class="form-control" id="tamil_title" name="tamil_title" placeholder="Title In Tamil* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>

					<div class="col-md-6">
						<label>Description In Hindi</label>
						<input type="text" class="form-control" id="tamil_desc" name="tamil_desc" placeholder="Short Description In Tamil* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>

				</div>

				<div class="row">
					<div class="col-md-6">
						<label>Title In Hindi</label>
						<input type="text" class="form-control" id="hindi_title" name="hindi_title" placeholder="Title In Hindi* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>

					<div class="col-md-6">
						<label>Description In Hindi</label>
						<input type="text" class="form-control" id="hindi_desc" name="hindi_desc" placeholder="Short Description In Hindi* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>

				</div>
				<br><br>

				<!-- Category Image -->
				<label>Category Image</label>
				<?php file_input('catImg'); ?>

				<button type="submit" name="addCategory" value="sfddsfs" class="btn btn-primary mt-4">Add Category</button>
			</form>
		</div>
	</div>
</div>