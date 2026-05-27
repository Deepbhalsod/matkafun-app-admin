<!doctype html>

<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo $web_name['option_value']; ?> |GALIDISAWAR GAME CHART</title>

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

						<h3 class="m-20px-b mt40 text-align" id ="gameName"><?php echo $web_name['option_value']; ?> Starline Result Chart</h3>

    
                        <div class="container mt-5">
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="table-responsive">
                    				<table class="view_chart">
                    					<thead>
                    						<tr>
                    							<th>Date</th>
                    							<?php 
                    							 foreach($games as $gameKey => $gameData){?>
                    							 <th><?=$gameData['name']?></th> 
                    							<?php } ?>
                    						</tr>
                    					</thead>
                    					<tbody>
                    					    <?php foreach($gameResults as $dateKey => $dateData){ ?>
                    					    <tr>
                    					       <th style="width: 130px;"><?=$dateKey?><br></th>
                    					       <?php foreach($dateData as $gameKey => $gameData){ ?>
                    					        <td><?=$gameData['left_digit']?><?=$gameData['right_digit']?></td>
                    					        <?php } ?>
                    						</tr>
                    						<?php } ?>
                    					</tbody>
                    				</table>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    </div>

				</div>

			</div>

		</div>

	</section>
                    

<style>
	.mt-5{
		margin-top: 5rem;
	}
			
	.table-responsive{
		scroll-behavior: smooth;
		overflow-x: auto;
	}
	.view_chart tr th{
		border:1px solid #48498A;
		color: #863189;
		font-size: 18px;
		padding:10px;
		text-align:center;
	}
	.view_chart tr td{
		color: #f62662;
		padding:10px;
		text-align:center;
		border:1px solid #48498A;
		font-size: 18px;
	}
	.view_chart tr td span{
		font-size:25px;
	}
</style>



	<footer id="footer-section" class="pt30 pb30 bg-black">

		<div class="container">

			<div class="row text-center">
				<div class="col-sm-12 py-4 py-md-2 color-white">
					<p>Copyright 2021 <a href="<?= SITE_URL ?>"><?=$web_name['option_value']?></a> | All Rights Reserved | <a href="<?= SITE_URL ?>privacy_policy">Privacy Policy</a></p>
					<!--<p class="white"><a href="https://www.searchnplay.in/" target="_blank">Website Development Company : Search N Play</a></p>-->
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