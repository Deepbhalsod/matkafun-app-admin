<?php defined('BASEPATH')  or exit('No direct script access allowed');?>
<?php breadcrumb_start('Admin', 'list/admin', 'admin_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 offset-lg-3 layout-spacing">
	   		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3" method="POST" enctype="multipart/form-data">

				<!-- First Name & Last Name -->
				<div class="row">
					<div class="col-md-12">
						<?= text_input('username', true, set_value('username'), 'User Name') ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<?= text_input('email', true, set_value('email'), 'email', 'email') ?>
					</div>
					<div class="col-md-6">
						<?= text_input('mobile', true, set_value('mobile'), 'mobile') ?>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<?php if (is($roles) and is_array($roles)) : ?>
								<select class="selectpicker form-control" name="userRole" data-live-search="true" title=" Select User Role " required>
									<?php foreach ($roles as $key => $value) : ?>
										<?php if ($value->created_by === $_SESSION['USER_ID'] or $value->id === $_SESSION['USER_ROLE']) : ?>
											<option value="<?php is($value->id, 'show'); ?>">
												<?php is($value->group_title, 'showCapital') ?>
											</option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
								<small class="form-text text-muted">
									<span class="text-danger mr-1">*</span>Required Fields
								</small>
							<?php else : ?>
								<span class="border-0 text-center bg-light form-control">
									User Group Role Not Exists Yet.
								</span>
							<?php endif; ?>

						</div>
					</div>
				</div>

				<!-- Upload Images -->
				<?php file_input('myImg'); ?>
				<div class="row">
					<div class="col-md-12 mt-3">
						<?= text_input('password', true, set_value('password'), 'password', 'password') ?>
					</div>

					<button type="submit" class="btn btn-primary mt-4" name="addADMIN" value="AddUSers">Add Admin</button>
			</form>
		</div>
	</div>
</div>