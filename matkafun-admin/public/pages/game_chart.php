<!doctype html>

<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo $web_name['option_value']; ?> | Game chart</title>

	<link href="<?= SITE_URL ?>assets/web/inner-files/css/bootstrap.min.css" rel="stylesheet">

	<link href="<?= SITE_URL ?>assets/web/inner-files/css/font-awesome.min.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<link href="<?= SITE_URL ?>assets/web/inner-files/css/pe-icon-7-stroke.css" rel="stylesheet">

	<link href="<?= SITE_URL ?>assets/web/inner-files/css/icofont.min.css" rel="stylesheet">

	<link rel="stylesheet" href="<?= SITE_URL ?>assets/web/inner-files/css/owl.carousel.min.css">

	<link rel="stylesheet" href="<?= SITE_URL ?>assets/web/inner-files/css/immersive-video.css">

	<link rel="stylesheet" href="<?= SITE_URL ?>assets/web/inner-files/css/owl.theme.default.min.css">

	<link href="<?= SITE_URL ?>assets/web/inner-files/css/modal-video.min.css" rel="stylesheet">

	<link href="<?= SITE_URL ?>assets/web/inner-files/css/magnific-popup.css" rel="stylesheet">

	<link rel="stylesheet" href="<?= SITE_URL ?>assets/web/inner-files/css/margins.css">

	<link rel="stylesheet" href="<?= SITE_URL ?>assets/web/inner-files/css/paddings.css">

	<link href="<?= SITE_URL ?>assets/web/inner-files/css/style.css" rel="stylesheet">

	<link href="<?= SITE_URL ?>assets/web/inner-files/css/responsive.css" rel="stylesheet">

	<link rel="stylesheet" href="<?= SITE_URL ?>assets/web/inner-files/css/colors/blue.css">

</head>
<style>
	@media only screen and (max-width: 767px) {

		.single-banner img {

			width: 55%;

		}

		.col-md-2s.col-2s {
			width: 33% !important;
			flex: auto !important;
		}

		.p-100px-t {
			padding-top: 0;
		}

	}
</style>

<body>

	<section id="home" class="text-left hero-section-1">

		<div class="container">

			<div class="align-items-center row">

				<div class="hero-content col-lg-12 p-100px-t p-50px-b md-p-10px-b">

					<div class="aboutIntroText minh500p">

						<h3 class="m-20px-b mt40 text-align" id="gameName"><?php echo $web_name['option_value']; ?> <?php echo ($sluggss) ?? ''; ?> Result Chart</h3>

						<div class="row">
							<?php if (!empty($SRIsdDEVI)) :
								foreach ($SRIsdDEVI as $key => $value) :
									$red_color = false;
									$jodi = $value['open_digit'] . $value['close_digit'];
									$num = array_search($jodi, $red_digit, true);
									if (!empty($num) || (isset($num) && ($num === 0 || $num === '0'))) {
										$red_color = true;
									}
							?>
									<div class="col-md-2s col-2s">
										<div class="dtm_box">
											<p class="dtm_title"><?php echo $value['day']; ?><br />(<?php echo $value['date']; ?> )</p>
											<div class="row row_col">
												<div class="col-md-4 col-4 pr-0">
													<div class="dtm_box_inner d-table">
														<div class="d-table-cell">
															<font class=<? if ($red_color) echo "chart_result"; ?>><?php echo $value['open_panna']; ?></font>
														</div>
													</div>
												</div>
												<div class="col-md-4 col-4 plr-0">
													<div class="dtm_box_inner dtm_box_mid d-table">
														<div class="d-table-cell">
															<h4 class=<? if ($red_color) echo "chart_result"; ?>><?php echo $jodi; ?></h4>
														</div>
													</div>
												</div>
												<div class="col-md-4 col-4 pl-0">
													<div class="dtm_box_inner d-table">
														<div class="d-table-cell">
															<font class=<? if ($red_color) echo "chart_result"; ?>><?php echo $value['close_panna']; ?></font>
														</div>
													</div>
												</div>
											</div>

										</div>

									</div>
								<?php endforeach; ?>
							<?php endif; ?>

						</div>

					</div>

				</div>

			</div>

		</div>

	</section>



	<footer id="footer-section" class="pt30 pb30 bg-black">

		<div class="container">

			<div class="row text-center">
				<div class="col-sm-12 py-4 py-md-2 color-white">
					<p>Copyright 2023 <a href="<?= SITE_URL ?>"><?= $web_name['option_value'] ?></a> | All Rights Reserved | <a href="<?= SITE_URL ?>privacy_policy">Privacy Policy</a></p>

				</div>

			</div>

	</footer>




	<script src="<?= SITE_URL ?>assets/web/inner-files/js/jquery.min.js"></script>

	<script src="<?= SITE_URL ?>assets/web/inner-files/js/customjs.js"></script>

	<script src="<?= SITE_URL ?>assets/web/inner-files/js/bootstrap.min.js"></script>

	<script src="<?= SITE_URL ?>assets/web/inner-files/js/jquery.scrollTo.min.js"></script>

	<script src="<?= SITE_URL ?>assets/web/inner-files/js/jquery.nav.js"></script>

	<script type="text/javascript" src="<?= SITE_URL ?>assets/web/inner-files/js/jquery.stellar.min.js"></script>

	<script type="text/javascript" src="<?= SITE_URL ?>assets/web/inner-files/js/modal-video.min.js"></script>

	<script type="text/javascript" src="<?= SITE_URL ?>assets/web/inner-files/js/jquery.magnific-popup.min.js"></script>

	<script src="<?= SITE_URL ?>assets/web/inner-files/js/immersive-video.js"></script>

	<script type="text/javascript" src="<?= SITE_URL ?>assets/web/inner-files/js/masonry.pkgd.min.js"></script>

	<script src="<?= SITE_URL ?>assets/web/inner-files/js/app.js"></script>



</body>

</html>