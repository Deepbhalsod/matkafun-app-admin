<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('fund', 'add/fund', 'fund_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3" method="POST" enctype="multipart/form-data">
               
				<!-- First Name & Last Name -->
				<div class="row">
					<div class="col-md-6">
						<lable>User</lable>
						<div class="form-group mb-4">
    						<select class="selectpicker" name="user_id" data-live-search="true" title="Select User* ">
    							<?php foreach ($users as $key => $value) : ?>
    								<option value="<?php is($value['id'], 'show'); ?>">
    									<?php is($value['username'], 'showCapital'); ?> - <?php is($value['mobile'], 'showCapital'); ?>
    								</option>
    							<?php endforeach; ?>
    						</select>
    						<small class="form-text text-muted">
    							<span class="text-danger mr-1">*</span>Required Fields
    						</small>
						</div>
					</div>
					
					<div class="col-md-6">
						<lable>Amount</lable>
						<div class="form-group mb-4">
							<input type="number" class="form-control" id="amount" name="amount" placeholder="Amount *">
							<small class="form-text text-muted"><span class="text-danger mr-1">*</span>Required Fields</small>
						</div>
					</div>


				</div>



				<button type="submit" class="btn btn-primary mt-4" name="Addfund" value="Addfund">Add Fund</button>
			</form>
		</div>
	</div>
</div>