<?php breadcrumb_start('notifications', 'list/notification', 'notification_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-6 col-lg-6 col-sm-6 offset-3 layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">

			<form class="p-3" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group mb-4">
							<label for="">Message</label>
							<textarea class="form-control" rows="0" name="message" placeholder="Message" required></textarea>
							<small class="form-text text-muted">
								<span class="text-danger mr-1">*</span>Required Fields
							</small>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group mb-4">
							<label for="">Select Type</label>
							<select class="form-control" id="cboCountry" name="type" required>
								<option hidden>Select Notification Type</option>
								<option value="PUSH">PUSH</option>
							</select>
							<small class="form-text text-muted">
								<span class="text-danger mr-1">*</span>Required Fields
							</small>
						</div>
					</div>


				</div>


		</div>

		<button type="submit" name="addNotification" value="sfddsfs" class="btn btn-primary mt-4">Add</button>
		</form>
	</div>
</div>
</div>