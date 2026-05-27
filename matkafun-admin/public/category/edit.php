<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php empty($categoryData) and show_404() or breadcrumb_start('categories', 'list/categories', 'category_list');
//_dd($categoryData);
?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="form-control" id="title" name="title" value="<?php is($categoryData->title, 'showCapital'); ?>" placeholder="Title* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" id="title" name="desc" value="<?php is($categoryData->desc, 'showCapital'); ?>" placeholder="Short Description* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<input type="text" class="form-control" id="tamil_title" name="tamil_title" value="<?php is($categoryData->tamil_title, 'showCapital'); ?>" placeholder="Title In Tamil* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" id="tamil_desc" name="tamil_desc" value="<?php is($categoryData->tamil_desc, 'showCapital'); ?>" placeholder="Short Description In Tamil* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<input type="text" class="form-control" id="hindi_title" name="hindi_title" value="<?php is($categoryData->hindi_title, 'showCapital'); ?>" placeholder="Title In Hindi* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" id="hindi_desc" name="hindi_desc" value="<?php is($categoryData->hindi_desc, 'showCapital'); ?>" placeholder="Short Description In Hindi* ">
						<small class="form-text text-muted">
							<span class="text-danger mr-1">*</span>Required Fields
						</small>
					</div>
				</div>
				<br><br>

				<label>Image</label>
				<!-- Category Image -->
				<!-- < strpos($categoryData->image, '@') and $images = explode('@', $categoryData->image) or $images = $categoryData->image;
				file_input('catImg[]', true, $images, '60', true) ?> -->
				<div class="row">
					<div class="col-md-12">
						<input type='file' name="catImg">
					</div>
				</div>

				<button type="submit" name="editCategory" value="sfddsfs" class="btn btn-primary mt-4">Update Category</button>
			</form>
		</div>
	</div>
</div>