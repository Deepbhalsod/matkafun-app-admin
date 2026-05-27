<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php breadcrumb_start('Admin', 'list/admin', 'admin_list'); ?>
<div class="row" id="cancel-row">
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 offset-lg-3 layout-spacing">
		<div class="widget-content widget-content-area br-6 shadow">
			<form class="p-3" method="POST" enctype="multipart/form-data">

				<div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Username</lable>
                            <input type="text" class="form-control" id="username" name="username" value="<?php is($ratingssssData['username'], 'show') ?>" placeholder="Username">
                          
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Email</lable>
                            <input type="email" class="form-control" id="email" name="email" value="<?php is($ratingssssData['email'], 'show') ?>" placeholder="Email">
                          
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-6">
                            <lable>Password</lable>
                             <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo base64_decode($ratingssssData['password']); ?>">
                          
                        </div>
                    </div>
                </div>

					<button type="submit" class="btn btn-primary mt-4" name="editADMIN" value="AddUSers">Update Admin</button>
			</form>
		
	</div>
</div>