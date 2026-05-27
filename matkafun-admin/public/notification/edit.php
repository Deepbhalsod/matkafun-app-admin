<?php breadcrumb_start('Notification', 'list/notifications', 'notification_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-6 col-lg-6 col-sm-6 offset-3 layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">

			<form class="p-3" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group mb-4">
							<label for="">Title</label>
							<input type="text" class="form-control" id="title" name="title" placeholder="title *" value="<?php is($notificationData->title, 'showCapital'); ?>" required>
							<small class="form-text text-muted">
								<span class="text-danger mr-1">*</span>Required Fields
							</small>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group mb-4">
							<label for="">Select Type</label>
							<select class="form-control" id="cboCountry" name="type" required>
								<option value="PUSH" <?= ($notificationData->type == 'PUSH') ? 'selected' : ''; ?>>PUSH</option>
								<option value="SMS" <?= ($notificationData->type == 'SMS') ? 'selected' : ''; ?>>SMS</option>
							</select>
							<small class="form-text text-muted">
								<span class="text-danger mr-1">*</span>Required Fields
							</small>
						</div>
					</div>
					<!-- <div class="col-md-6">
						<div class="form-group mb-4">
							<input type="number" class="form-control" id="title" name="s_price" placeholder="Sale Price *" required>
							<small class="form-text text-muted">
								<span class="text-danger mr-1">*</span>Required Fields
							</small>
						</div>
					</div> -->
				</div>
				<!-- <div class="row">
					<div class="col-md-12">
						<div class="form-group mb-4">
							<input type="number" class="form-control" id="title" name="days" placeholder="Days *" required>
							<small class="form-text text-muted">
								<span class="text-danger mr-1">*</span>Required Fields
							</small>
						</div>
					</div>
				</div> -->
				<!-- <div class="row">
					<div class="col-md-12">
						<div class="form-group mb-4">
						<textarea class="form-control" rows="0"  name="short_description" placeholder="Description"></textarea>
								<small class="form-text text-muted">
									<span class="text-danger mr-1">*</span>Required Fields
								</small>
						</div>
					</div>
				</div> -->

				<!-- Category Image -->
				<?php //file_input('catImg'); 
				?>

				<div class="row">
					<div class="col-md-12">
						<!-- <div class="form-group mb-4">
							<select class="selectpicker form-control" name="post_type" title=" Select Category Type ">
								<option value="BLOG">Blogs</option>
								<option value="FAQ">FAQs</option>
								<option value="DOCUMENT">Documents</option>
							</select>
						</div> -->
					</div>
				</div>

				<button type="submit" name="editNotification" value="sfddsfs" class="btn btn-primary mt-4">Add Notification</button>
			</form>
		</div>
	</div>
</div>