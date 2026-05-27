<link rel="stylesheet" href="/form.css">
<div class="form_content">

	<div class="Login_box">
		<h1 class="text_center">
			<span class="brand_name"><?php echo SITE_NAME; ?> Dashboard</span>
		</h1>

		<form method="POST">
			<input id="username" name="username" type="text" class="form_control" placeholder="Username" minlength="3" required>
			<input id="password" name="password" type="password" class="form_control" placeholder="Password *" minlength="3" required>
			<div class="field-wrapper toggle-pass">
				<p>Show Password</p>
				<label class="switch s-primary">
					<input type="checkbox" id="toggle-password" class="d-none">
					<span class="slider round"></span>
				</label>
			</div>


			<div class="field-wrapper"></div>

			<div class="field-wrapper">
				<button type="submit" name="LoginAdmin" value="sdsdsfe" value="">Log In</button>
			</div>


		</form>

	</div>

</div>