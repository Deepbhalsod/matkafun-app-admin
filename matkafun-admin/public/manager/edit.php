<?php breadcrumb_start('Firstaid', 'list/firstaid', 'firstaid_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3 py-5" method="POST" enctype="multipart/form-data">
				<div class="row">

					<div class="col-md-12">
						<label>Icon</label>

						<?php strpos($banner->icon, '@') and $iconimage = explode('@', $banner->icon) or $iconimage = $banner->icon;
						file_input('iconImg[]', true, $iconimage, '60', true) ?>
					</div>



				</div>
				<br>
				<div class="row">

					<div class="col-md-6">
						<label>Title</label>
						<input type="text" class="form-control" name="title" placeholder="Title" value="<?php is($banner->title, 'showCapital'); ?>">

					</div>

					<div class="col-md-6">
						<label>Title (Hindi)</label>
						<input type="text" class="form-control" name="title_hindi" placeholder="Title" value="<?php is($banner->title_hindi, 'show'); ?>">

					</div>



				</div>
				<br>
				<div class="row">

					<div class="col-md-12">
						<label>Short Description</label>
						<input type="text" class="form-control" name="short_desc" placeholder="Short Description " value="<?php is($banner->short_desc, 'showCapital'); ?>">


					</div>

				</div>
				<br>
				<div class="row">

					<div class="col-md-12">
						<label>Short Description (Hindi)</label>
						<input type="text" class="form-control" name="short_desc_hindi" placeholder="Short Description " value="<?php is($banner->short_desc_hindi, 'show'); ?>">


					</div>

				</div>
				<br>

				<div class="row">

					<div class="col-md-12">
						<label>Long Description</label>
						<textarea name="long_des" id="editor" rows="10" cols="50" class="form-control" placeholder="Long Description"><?php is($banner->long_desc, 'showCapital'); ?></textarea>

					</div>

				</div>
				<br>
				<div class="row">

					<div class="col-md-12">
						<label>Long Description (Hindi)</label>
						<textarea name="long_des_hindi" id="editor1" rows="10" cols="50" class="form-control" placeholder="Long Description"><?php is($banner->long_desc_hindi, 'show'); ?></textarea>

					</div>

				</div>

				<div class="ml-xl-5">
					<button type="submit" name="editfirstaid" value="sfddsfs" class="ml-xl-4 btn btn-primary mt-4">Edit Firstaid</button>
				</div>
			</form>
		</div>
	</div>
</div>