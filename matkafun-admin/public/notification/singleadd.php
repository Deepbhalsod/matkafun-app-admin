<?php breadcrumb_start('notifications', 'list/notification', 'notification_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-6 col-lg-6 col-sm-6 offset-3 layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">

			<form class="p-3" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group mb-4">
							<label for="">Title</label>
							<textarea class="form-control" rows="0" name="title" placeholder="Title" required></textarea>
							<small class="form-text text-muted">
								<span class="text-danger mr-1">*</span>Required Fields
							</small>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group mb-4">
							<label for="">Content</label>
							<textarea class="form-control" rows="0" name="message" placeholder="Content" required></textarea>
							<small class="form-text text-muted">
								<span class="text-danger mr-1">*</span>Required Fields
							</small>
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-md-12">
						<div class="form-group mb-4">
							<label for="">Select User</label>
							<select class="selectpicker form-control" name="user_id" data-live-search="true" title="Select User ">
								<option value="All">All</option>
								<?php if (!empty($employee)) foreach ($employee as $value) : ?>
									<option value="<?php echo $value->id; ?>">
										<?php echo ucwords($value->username)."( ".$value->mobile." )"; ?>
									</option>
								<?php endforeach; ?>
							</select>
							<small class="form-text text-muted"><span class="text-danger mr-1">*</span>Required Fields</small>
						</div>
					</div>

				</div>


		</div>

		<button type="submit" name="addNotificationsingle" value="addNotificationsingle" class="btn btn-primary mt-4">Send Notification</button>
		</form>
	</div>
</div>
</div>