<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>
		<?php echo SITE_NAME; ?> Dashboard
	</title>
	<link rel="icon" type="image/png/jpeg" href="<?php echo SITE_URL; ?>assets/img/logo.png" />
	<?php $_SERVER['HTTP_HOST'] === 'base.dev' and print('<link rel="manifest" href="' . SITE_URL . 'manifest.json">'); ?>
	<?php $_SERVER['HTTP_HOST'] === 'basedev.twstechnology.com' and print('<link rel="manifest" href="' . SITE_URL . 'web_manifest.json">'); ?>
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
		rel="stylesheet">

	<link href="<?php echo SITE_URL; ?>assets/css/loader.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo SITE_URL; ?>assets/js/loader.js"></script>

	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.b\.\\apcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
	<link href="<?php echo SITE_URL; ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo SITE_URL; ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
	<!--<link href="<?php echo SITE_URL; ?>assets/css/styleeee.css" rel="stylesheet" type="text/css" />-->
	<!--<link href="<?php echo SITE_URL; ?>assets/css/styleii.css" rel="stylesheet" type="text/css" />-->
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>assets/css/forms/theme-checkbox-radio.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>assets/css/forms/switches.css">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!--<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />-->
	<!--<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>-->


	<!-- END GLOBAL MANDATORY STYLES -->

	<!-- Other Elements Styles -->
	<link href="<?php echo SITE_URL; ?>assets/css/elements/miscellaneous.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo SITE_URL; ?>assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />

	<?php // Add Style For Login Page
	if (check_current_page('admin/login')): ?>
		<link href="<?php echo SITE_URL; ?>assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
	<?php // Add Style For Main Dashboard
	elseif (check_current_page('admin/home')): ?>
		<link href="<?php echo SITE_URL; ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
		<link href="<?php echo SITE_URL; ?>assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
	<?php // Add Style For Datatable Lists
	elseif (check_current_method_similar('list')): ?>
		<!--<link href="<?php echo SITE_URL; ?>plugins/table/datatable/datatables.css" rel="stylesheet" type="text/css">-->

		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">

		<link href="<?php echo SITE_URL; ?>plugins/table/datatable/dt-global_style.css" rel="stylesheet" type="text/css">
		<link href="<?php echo SITE_URL; ?>plugins/table/datatable/custom_dt_custom.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet"
			href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
	<?php // Add Style For Form Pages
	elseif (check_current_method_similar('add') or check_current_method_similar('edit')): ?>
		<link href="<?php echo SITE_URL; ?>plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet"
			type="text/css">
		<link href="<?php echo SITE_URL; ?>assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo SITE_URL; ?>plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
		<link href="<?php echo SITE_URL; ?>plugins/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">
		<link href="<?php echo SITE_URL; ?>assets/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet"
			type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>plugins/select2/select2.min.css">
	<?php endif; ?>
	<style>
		.div1 {
			width: 400px;
			height: 180px;
			border: 3px solid blue;
		}

		.divrow {
			width: 900px;
			height: 50px;
			border: 3px solid blue;
		}

		.btn-success-cds {
			background-color: #65B688;
			border-color: #65B688;
		}

		.btn-danger-cds {
			color: #fff;
			background-color: #d9534f;
			border-color: #d43f3a;
		}

		.btn-cds {
			color: white;
			display: inline-block;
			margin-bottom: 0;
			font-weight: 400;
			text-align: center;
			vertical-align: middle;
			cursor: pointer;
			background-image: none;
			border: 1px solid transparent;
			white-space: nowrap;
			padding: 6px 12px;
			font-size: 14px;
			line-height: 1.42857143;
			border-radius: 4px;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
	</style>

	<!-- Meta Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '883240727577639');
	fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=883240727577639&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Meta Pixel Code -->
</head>

<style>
	.dropdown-item {
		padding: 0;
		padding-top: 0.5pc;
		padding-bottom: 0.5pc;
	}
	.dropdown-item:hover{
		background-color: var(--main-col-);
	}
</style>

<body class="<?php check_current_page('admin/login') and print('form') or print('alt-menu sidebar-noneoverflow') ?>">
	<!-- BEGIN LOADER -->
	<div id="load_screen">
		<div class="loader">
			<div class="loader-content">

				<script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
				<lord-icon src="https://cdn.lordicon.com/xjovhxra.json" trigger="loop"
					colors="primary:#121331,secondary:#08a88a" style="width:250px;height:250px">
				</lord-icon>

			</div>
		</div>
	</div>
	<!--  END LOADER -->

	<?php if (!check_current_page('admin/login') and is_login()): ?>
		<!--  BEGIN NAVBAR  -->
		<div class="header-container fixed-top">
		<header>
				<a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M3 12H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M3 6H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M3 18H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</a>

				<h3 class="ab">Dashboard - <?php echo SITE_NAME; ?></h3>

				<li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
					<a class="dropdown-item" href="<?php echo SITE_URL; ?>dashboard/logout">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path
								d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
								stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M16 17L21 12L16 7" stroke="white" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round" />
							<path d="M21 12H9" stroke="white" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round" />
						</svg>
					</a>
					</a>
				</li>

			</header>
		</div>
		<!--  END NAVBAR  -->
	<?php endif; ?>

	<?php show_message(); ?>