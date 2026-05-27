<!doctype html>

<html lang="en">

<head>

  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= SITE_NAME ?> | Home</title>

  <link rel="stylesheet" href="<?= SITE_URL ?>assets/web/css/style.css">

  <link rel="stylesheet" href="<?= SITE_URL ?>assets/web/css/bootstrap.min.css">

  <link rel="stylesheet" href="<?= SITE_URL ?>assets/web/css/bootstrap.css">

  <link rel="stylesheet" href="<?= SITE_URL ?>assets/web/css/aos.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>

  <!-- Global site tag (gtag.js) - Google Ads: 328806285 -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-328806285"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'AW-328806285');
  </script>

  <!-- Event snippet for Website traffic conversion page -->
  <script>
    gtag('event', 'conversion', {
      'send_to': 'AW-328806285/_XMDCOTr6N0CEI3f5JwB'
    });
  </script>


</head>

<body>

  <header>

    <nav class="navbar navbar-expand-lg header navbar-default fixed-top" id="nav">

      <div class="container">

        <a class="navbar-brand" href="#home">
                   <img src="<?= SITE_URL ?>assets/img/logo.png" alt="logo">

        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">

          <span class="navbar-toggler-icon">

            <i class="fa fa-bars"></i>

          </span>

        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

          <ul class="navbar-nav snip1168 ml-auto mt-2 mt-lg-0">

            <li class="nav-item active">

              <a class="nav-link" href="#home" data-toggle="collapse" data-target=".navbar-collapse.show">Home <span class="sr-only">(current)</span></a>

            </li>

            <li class="nav-item">

              <a class="nav-link" href="#result" rel='m_PageScroll2id' data-toggle="collapse" data-target=".navbar-collapse.show">Results</a>

            </li>

            <li class="nav-item">

              <a class="nav-link" href="#about" rel='m_PageScroll2id' data-toggle="collapse" data-target=".navbar-collapse.show">About Us </a>

            </li>

            <li class="nav-item">

              <a class="nav-link" href="#time-table" rel='m_PageScroll2id' data-toggle="collapse" data-target=".navbar-collapse.show">Time Table</a>

            </li>

            <li class="nav-item">

              <a class="nav-link" href="#rate-chart" rel='m_PageScroll2id' data-toggle="collapse" data-target=".navbar-collapse.show">Rate Chart</a>

            </li>

            <li class="nav-item">

              <a class="nav-link" href="#how-to-play" rel='m_PageScroll2id' data-toggle="collapse" data-target=".navbar-collapse.show">How to Play</a>

            </li>

            <li class="nav-item">

              <a class="nav-link" href="#faq" rel='m_PageScroll2id' data-toggle="collapse" data-target=".navbar-collapse.show">FAQ</a>

            </li>

          </ul>

        </div>

      </div>

    </nav>

  </header>

  <div class="top-sect" id="home">

    <div class="container">

      <div class="row flexbox-center">

        <div class="col-md-5">

          <div class="single-banner text-lg-left text-center">

            <img src="<?php echo (strpos($bnr_img['image'], '<p>') !== false) ? SITE_URL . 'assets/img/logo.png' : $bnr_img['image']; ?>" alt="banner" width="250">

          </div>

        </div>

        <div class="col-md-7">

          <div class="single-banner-content">

            <h1>Download Best Online</h1>
            <h1><?= SITE_NAME ?> App!</h1>

            <p class="my-4">Play upto Lacs Daily with <?= SITE_NAME ?> Game.</p>

            <div class="banner-buttons-wrapper">
                <div class="banner-btn-row first-row">
                    <a href="<?php echo ($settingDataapk['url']) ?? ''; ?>" class="appbox-btn download-apk-btn">
                      <i class="fa fa-download"></i> Download APK
                    </a>
                </div>
                
                <div class="banner-btn-row second-row">
                    <a href="tel:+91<? echo $support_mobile['option_value']; ?>" class="appbox-btn contact-btn">
                      <i class="fa fa-phone"></i><?php echo $support_mobile['option_value']?>
                    </a>
        
                    <a href="https://wa.me/91<? echo $whtsp_mobile['option_value']; ?>" class="appbox-btn contact-btn" target="blank">
                        <i class="fa fa-whatsapp"></i> <?php echo $whtsp_mobile['option_value']?>
                    </a>
                 </div>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <section class="play_result mt-3" id="result">

    <div class="container">

      <div class="sec-title">

        <h3>Matka Online Play Result</h3>

        <p>(<?php echo $datein; ?>)</p>

      </div>

      
    <div class="row align-items-center">

        <?php if (!empty($lautries)) { 
            foreach ($lautries as $key => $value) :
        ?>
          <div class="col-lg-4 col-md-6">

            <div class="single_result">

              <h4><?php echo $value['name']; ?></h4>
              
           <?php if (!empty($value['result'])) {?>
              <ul>
                    <li>
                      <?php if (!empty($value['result']['open_panna'])) {
                        $open =  $value['result']['open_panna'];
                      } else {
                        $open = '***';
                      } ?>
                      <p><?php echo $open; ?> </p>

                    </li>

                    <li>

                      <p class="bold-sec"><?php echo ($value['result']['open_digit']);
                                          echo ($value['result']['close_digit']); ?> </p>


                    </li>

                    <li>
                      <?php if (!empty($value['result']['close_panna'])) {
                        $closed =  $value['result']['close_panna'];
                      } else {
                        $closed = '***';
                      } ?>
                      <p><?php echo $closed; ?> </p>


                    </li>

                  </ul>
                <?php  } else { ?>
                    <ul>
                        <li>
                          <p>***</p>
                        </li>
        
                        <li>
                          <p class="bold-sec">**</p>
                        </li>
        
                        <li>
                          <p>***</p>
        
                        </li>

                    </ul>
              <?php } ?>
              <div class="g_rtime">
                <p><?php echo $value['open_time']; ?><span><?php echo $value['close_time']; ?></span></p>
              </div>

              <div class="clearfix"></div>

            </div>

          </div>
       
        	<?php endforeach; ?>
        	 <?php  }; ?>
        

    </div>

  </section>

  <section class="about" id="about">

    <div class="container">

      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">

        <h3 style="color:#fff;">About us</h3>

      </div>

      <div class="row">
        <?php if (!empty($settingData)) :

        ?>
          <div class="col-md-12 col-lg-6">

            <p class="about-desc"><?php echo $settingData['about']; ?></p>
            <!-- 
            <p class="about-desc about-desc-1">We provide you with fastest online results of every bazar in the matka industry. We provide fastest results of SRIDEVI DAY, TIME BAZAR, MADUR DAY, RUDRAKSH DAY, MILAN DAY, RAJDHANI DAY, SUPREME DAY, KALYAN DAY, SRIDEVI NIGHT, SUPREME NIGHT, MILAN NIGHT, RAJDHANI NIGHT And MAIN RATAN.</p> -->

          </div>
        <?php endif; ?>
        <div class="col-md-12 col-lg-6 text-center">

          <img data-aos="fade-left" src="<?= SITE_URL ?>assets/web/images/about.png" alt="banner" style=" width: 400px;-webkit-filter: drop-shadow(5px 5px 5px #fff); filter: drop-shadow(5px 5px 5px #fff); transition: 2s;">

        </div>

      </div>

    </div>

  </section>

<!--  <section id="app_SS">-->

<!--    <div class="container">-->

<!--      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">-->

<!--        <h3>App Screenshots</h3>-->

<!--      </div>-->

<!--    <?php if($app_ss) : ?>-->
<!--      <div class="row">-->

<!--        <div class="col-md-10 mx-auto">-->

<!--          <div class="app-carousel owl-carousel owl-theme">-->
              
<!--            <?php foreach($app_ss as $ss_key =>$ss_val) : ?>-->
<!--            <div class="item">-->

<!--              <img src="<?php echo $ss_val['image']; ?>" alt="">-->

<!--            </div>-->
<!--            <?php endforeach; ?>-->

<!--          </div>-->

<!--        </div>-->

<!--      </div>-->
<!--<?php endif; ?>-->
<!--    </div>-->

<!--  </section>-->

  <section class="testimonial-area" id="time-table">

    <div class="container">

      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">

        <h3>Game Time Table</h3>

      </div>
 <?php if (!empty($lautries)) : ?>
      <div class="row">

        <div class="col-md-8 offset-md-2">

          <div class="time-table">

            <table class="table table-striped">

              <tbody>

                <tr>

                  <th>Market</th>

                  <th>open</th>

                  <th>close</th>

                  <th>Results</th>

                </tr>
                 <?php 
                        foreach ($lautries as $key => $value) :
                    ?>
                    <tr>
    
                      <td><?php echo $value['name']; ?></td>
    
                      <td><?php echo $value['open_time']; ?></td>
    
                      <td><?php echo $value['close_time']; ?></td>
    
                      <td><a href="<?= SITE_URL ?>pages/game_chart/<?php echo $value['name']; ?>">View Chart</a></td>
    
                    </tr>
                 <?php endforeach; ?>

              </tbody>

            </table>

          </div>



        </div>

      </div>
<?php endif; ?>
    </div>



  </section>

  <section class="rate-area" id="rate-chart">
    <?php if (!empty($plays)) { ?>
    <div class="container">

      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">

        <h3>Game Play Rates</h3>

      </div>

      <div class="row flexbox-center">
         <?php foreach ($plays as $key => $value) :?>
            <div class="col-md-6">

          <ul class="rate_list_ul">

            <li data-aos="fade-up" data-aos-duration="1000"><?php echo ucwords(str_replace('_',' ',$value['name'])); ?> : <?php echo $value['cost_amount']; ?>-<?php echo $value['earning_amount']; ?></li>

          </ul>

        </div>
            <?php endforeach; ?>
      </div>

    </div>
   <?php  };?> 
  </section>
  
  <section class="testimonial-area" id="time-table">

    <div class="container">

      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">

        <h3>Starline Game Time Table</h3>
        <a href="<?php echo SITE_URL ?>starline_game_rate"><h4>View Chart</h4></a>

      </div>
   <?php if (!empty($starline_game)) : ?>
      <div class="row">

        <div class="col-md-8 offset-md-2">

          <div class="time-table">

            <table class="table table-striped">

              <tbody>

                <tr>

                  <th>Name</th>

                  <th>Time</th>

                  <th>Results</th>

                </tr>
                 <?php 
                        foreach ($starline_game as $key_starline => $value_starline) :
                    ?>
                    <tr>
    
                      <td><?php echo $value_starline['name']; ?></td>
    
                      <td><?php echo $value_starline['time']; ?></td>
                      
                      <td><?php echo $value_starline['result']; ?></td>
    
    
                    </tr>
                 <?php endforeach; ?>


              </tbody>

            </table>

          </div>



        </div>

      </div>
<?php endif; ?>
    </div>



  </section>
  
  <section class="rate-area" id="rate-chart">
    <?php if (!empty($plays)) { ?>
    <div class="container">

      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">

        <h3>Starline Game Play Rates</h3>

      </div>

      <div class="row flexbox-center">
         <?php foreach ($rate as $key_rate => $value_rate) :?>
            <div class="col-md-6">

          <ul class="rate_list_ul">

            <li data-aos="fade-up" data-aos-duration="1000"><?php echo ucwords(str_replace('_',' ',$value_rate['name'])); ?> : <?php echo $value_rate['cost_amount']; ?>-<?php echo $value_rate['earning_amount']; ?></li>

          </ul>

        </div>
            <?php endforeach; ?>
      </div>

    </div>
   <?php  };?> 
  </section>
  <section class="testimonial-area" id="time-table">

    <div class="container">

      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">

        <h3>Gali Disawar Game Time Table</h3>
        <a href="<?php echo SITE_URL ?>gali_disawar_game_rate"><h4>View Chart</h4></a>

      </div>
   <?php if (!empty($galidisawar_game)) : ?>
      <div class="row">

        <div class="col-md-8 offset-md-2">

          <div class="time-table">

            <table class="table table-striped">

              <tbody>

                <tr>

                  <th>Name</th>

                  <th>Time</th>

                  <th>Results</th>

                </tr>
                 <?php 
                        foreach ($galidisawar_game as $key_galidisawar => $value_galidisawar) :
                    ?>
                    <tr>
    
                      <td><?php echo $value_galidisawar['name']; ?></td>
    
                      <td><?php echo $value_galidisawar['time']; ?></td>
                      
                      <td><?php echo $value_galidisawar['result']; ?></td>
    
    
                    </tr>
                 <?php endforeach; ?>


              </tbody>

            </table>

          </div>



        </div>

      </div>
<?php endif; ?>
    </div>



  </section>
  
  <section class="rate-area" id="rate-chart">
    <?php if (!empty($galidisawar_rate_new)) { ?>
    <div class="container">

      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">

        <h3>Gali Disawar Game Play Rates</h3>

      </div>

      <div class="row flexbox-center">
         <?php foreach ($galidisawar_rate_new as $key_rate_new => $value_rate_new) :?>
            <div class="col-md-6">

          <ul class="rate_list_ul">

            <li data-aos="fade-up" data-aos-duration="1000"><?php echo ucwords(str_replace('_',' ',$value_rate_new['name'])); ?>-<?php echo $value_rate_new['cost_amount']; ?>-<?php echo $value_rate_new['earning_amount']; ?></li>

          </ul>

        </div>
            <?php endforeach; ?>
      </div>

    </div>
   <?php  };?> 
  </section>
  
  <?php $style="";
        $videourl='';
    if(!$SVideo['url']){
        $style = 'style="display:none;"';
    }
    else{
        $url = $SVideo['url'];
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
    
        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        
        $videourl='https://www.youtube.com/embed/' . $youtube_id ;
    }
    ?>

  <section class="app_preview" id="app_preview" <?=$style?>>

    <div class="container">

      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">

        <h3>Youtube Link <??></h3>

      </div>

      <div class="row">

        <div class="col-md-2"></div>

        <div class="col-md-8">

          <div class="embed-responsive embed-responsive-16by9">

            <iframe width="100%" height="315" src="<?=$videourl?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

          </div>

        </div>

        <div class="col-md-2"></div>

      </div>

    </div>

  </section>

  <section class="pricing-area" id="how-to-play">

    <div class="container">

      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">

        <h3>How To Play</h3><br><br>

      </div>

      <div class="row ">

        <div class="col-md-6">

          <div class="single-feature-box text-center">

            <!-- <img data-aos="zoom-in-right" data-aos-duration="2000" src="assets/images/how-to-play.png" alt=""> -->
            <img src="<?php echo $bnr_img['image']?>" alt="">

          </div>

        </div>

        <div class="col-md-6">

          <div class="single-feature-box text-lg-left text-center">

            <ul>

              <li>

                <div class="feature-box-info">

                  <h4>1. Download App <a href="<?php echo ($settingDataapk['url']) ?? ''; ?>"> <i class="fa fa-download"></i></a></h4>

                </div>

              </li>

              <li>

                <div class="feature-box-info">

                  <h4>2. Click On Sign In <i class="fa fa-sign-in"></i></h4>

                </div>

              </li>

              <li>

                <div class="feature-box-info">

                  <h4>3. Enter User Id &amp; Password <i class="fa fa-unlock-alt"></i></h4>

                </div>

              </li>

              <li>

                <div class="feature-box-info">

                  <h4>4. Select Game &amp; Play The Game <i class="fa fa-gamepad"></i>

                  </h4>

                </div>

              </li>

            </ul>

          </div>

        </div>

      </div>

      <br><br><br><br><br>

    </div>

  </section>

  <section class="faq-section" id="faq">

    <div class="container">

      <div class="sec-title" data-aos="zoom-in-up" data-aos-duration="1500">

        <h3>FAQ</h3>

      </div>

      <div class="row">

        <div class="faq_col">

          <div class="faq" id="accordion">

            <div class="card">

              <div class="card-header" id="faqHeading-1">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-1" data-aria-expanded="true" data-aria-controls="faqCollapse-1">

                    <span class="badge">1</span>
                    <span>How to add points?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-1" class="collapse" aria-labelledby="faqHeading-1" data-parent="#accordion">

                <div class="card-body">

                  <p>Answer: We are working with Automatic Point Add System. You can add points by clicking "Add Points" button available in wallet section. Once you fill the required amount and process it, we will show you all UPI systems installed in your mobile. You can pick any payment UPI and pay with UPI. Once your payment is received in our wallet, we will add points your wallet automatically and all this process is automatic. </p>

                  <p>Note- In some cases when online UPI system is not working, you can drop a message to us on WhatsApp number to add points manually. </p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-2">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-2" data-aria-expanded="false" data-aria-controls="faqCollapse-2">

                    <span class="badge">2</span>
                    <span>How to withdraw points?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-2" class="collapse" aria-labelledby="faqHeading-2" data-parent="#accordion">

                <div class="card-body">

                  <p>Garena Matka Game introduce a very fast and trusty withdrawal system. You can add your Bank Accounts(PhonePe, Google Pay, PayTM) from your profile section). Once you added minimum one payment method, you can create withdraw request for available points in your wallet.

                    Please note that we are allowing timely withdraw i.e. you can withdraw your points in a specified time slot which can see in Withdraw screen and we need maximum 24 working to complete your withdraw request. </p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-3">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-3" data-aria-expanded="false" data-aria-controls="faqCollapse-3">

                    <span class="badge">3</span>
                    <span>How to transfer points?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-3" class="collapse" aria-labelledby="faqHeading-3" data-parent="#accordion">

                <div class="card-body">

                  <p>We have enabled few accounts to transfer points. If your account is enabled for Transfer Points, you can transfer points from your wallet to other person?s wallet anytime.</p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-4">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-4" data-aria-expanded="false" data-aria-controls="faqCollapse-4">

                    <span class="badge">4</span>
                    <span>How to add withdraw methods?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-4" class="collapse" aria-labelledby="faqHeading-4" data-parent="#accordion">

                <div class="card-body">

                  <p>In wallet section, we have given option to add your withdraw methods. You can add PhonePe, Google Pay or PayTM and withdraw points from your wallet to any specified withdraw method.</p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-5">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-5" data-aria-expanded="false" data-aria-controls="faqCollapse-5">

                    <span class="badge">5</span>
                    <span> How to manage my wallet?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-5" class="collapse" aria-labelledby="faqHeading-5" data-parent="#accordion">

                <div class="card-body">

                  <p> You can check complete wallet transactions from Wallet History section. We have given filter option to check transactions between a date range.</p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-6">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-6" data-aria-expanded="false" data-aria-controls="faqCollapse-6">

                    <span class="badge">6</span>
                    <span> How to play games?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-6" class="collapse" aria-labelledby="faqHeading-6" data-parent="#accordion">

                <div class="card-body">

                  <p>We have designed very simple and best gaming experience. You can pick any Game which is currently running and choose any Game type(Single Paana, Double Paana etc.). In bid form you can choose session, digit/panna and number of points you want to play. Once you are confirmed about your bid you can place a final submission and your bid is successfully processed.</p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-7">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-7" data-aria-expanded="false" data-aria-controls="faqCollapse-7">

                    <span class="badge">7</span>
                    <span>How to check my bid history?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-7" class="collapse" aria-labelledby="faqHeading-7" data-parent="#accordion">

                <div class="card-body">

                  <p>You can check complete wallet bidding transactions from Bid History section. We have given filter option to check transactions between a date range.</p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-8">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-8" data-aria-expanded="false" data-aria-controls="faqCollapse-8">

                    <span class="badge">8</span>
                    <span>How to check my win history?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-8" class="collapse" aria-labelledby="faqHeading-8" data-parent="#accordion">

                <div class="card-body">

                  <p>You can check complete wallet winning transactions from Win History section. We have given filter option to check transactions between a date range.</p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-9">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-9" data-aria-expanded="false" data-aria-controls="faqCollapse-9">

                    <span class="badge">9</span>
                    <span>How to change my login password?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-9" class="collapse" aria-labelledby="faqHeading-9" data-parent="#accordion">

                <div class="card-body">

                  <p>We suggest you to change your login password on regular time interval. If you want to change your login password, you can choose from settings section. In that screen, you need to enter your current password and new password. If your details a correctly verified, your password will be updated immediately.</p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-10">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-10" data-aria-expanded="false" data-aria-controls="faqCollapse-7">

                    <span class="badge">10</span>
                    <span>How to change my M-Pin?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-10" class="collapse" aria-labelledby="faqHeading-10" data-parent="#accordion">

                <div class="card-body">

                  <p>We suggest you to change your M-Pin on regular time interval. If you want to change your login M-Pin, you can choose from settings section. In that screen, you need to enter your current M-Pin and new M-Pin. If your details a correctly verified, your M-Pin will be updated immediately.</p>

                </div>

              </div>

            </div>



            <div class="card">

              <div class="card-header" id="faqHeading-11">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-11" data-aria-expanded="false" data-aria-controls="faqCollapse-11">

                    <span class="badge">11</span>
                    <span> What are main game rates?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-11" class="collapse" aria-labelledby="faqHeading-11" data-parent="#accordion">

                <div class="card-body">

                  <p>We are giving the best winning rate in current market rate. You can check game rates from "Game Rates" button available in home screen.</p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-12">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-12" data-aria-expanded="false" data-aria-controls="faqCollapse-12">

                    <span class="badge">12</span>
                    <span>What are <?= SITE_NAME ?> Game game rates?</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-12" class="collapse" aria-labelledby="faqHeading-12" data-parent="#accordion">

                <div class="card-body">

                  <p>We are giving the best winning rate in current market rate. You can check  Game game rates from "Game Rates" button available in <?= SITE_NAME ?> Game section.</p>

                </div>

              </div>

            </div>

            <div class="card">

              <div class="card-header" id="faqHeading-13">

                <div class="mb-0">

                  <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-13" data-aria-expanded="false" data-aria-controls="faqCollapse-13">

                    <span class="badge">13</span>
                    <span>I want to submit call back request.</span>

                  </h5>

                </div>

              </div>

              <div id="faqCollapse-13" class="collapse" aria-labelledby="faqHeading-13" data-parent="#accordion">

                <div class="card-body">

                  <p>We are available on live chat 24X7 but if you want discuss about any issues on a voice call, you can submit your Call Back request and our executive will call you to discuss. Don't worry, we are trying to give instant support to our valuable customers and we will try to call you ASAP.</p>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </section>



  <section id="contact-us" class="contact-us">

    <div class="container">

      <div class="row">

        <div class="col-md-6 col-xs-12 pl-md-5">

          <div class="contact">

            <p> <a href="tel:+91<? echo $support_mobile['option_value']; ?>"> <i class="fa fa-phone"></i><?php echo $support_mobile['option_value']?></a></p>

          </div>

        </div>

        <div class="col-md-6 col-xs-12 pr-md-5">

          <div class="contact">

            <p> <a href="https://wa.me/91 <? echo $whtsp_mobile['option_value']; ?>" target="blank"><i class="fa fa-whatsapp"></i> <?php echo $whtsp_mobile['option_value']?></a></p>

          </div>

        </div>

      </div>

    </div>

  </section>

  <footer class="footer">

    <div class="container">

      <div class="footer-content">

        <p>Copyright 2023 <a href="index.php"><?=$web_name['option_value']?></a> | All Rights Reserved | <a href="<?= SITE_URL ?>privacy_policy">Privacy Policy</a></p>
        <!--<p class="white"><a href="https://www.searchnplays.com/" target="_blank">Website Development Company : Search N Play</a></p>-->
      </div>

    </div>

  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $('.navbar-nav>li>a').on('click', function() {
      $('.navbar-collapse').collapse('hide');
    });
  </script>
  <script>
    /*(function($) {
  $(window).on("load", function() {
    $("a[rel='m_PageScroll2id']").mPageScroll2id();
  });
});*/
    var $root = $('html, body');

    $('a[href^="#"]').click(function() {
      var href = $.attr(this, 'href');

      $root.animate({
        scrollTop: $(href).offset().top
      }, 500, function() {
        window.scrollTo(window.scrollX, window.scrollY - 50);
      });

      return false;
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <!-- Popper JS -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->

  <script src="../cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $('.navbar-collapse a').click(function() {
      $(".navbar-collapse").collapse('hide');
    });
  </script>
  <!-- <script src="../code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<script src="../maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->

  <script src="<?= SITE_URL ?>assets/web/js/aos.js"></script>

  <!-- <script src="assets/js/bootstrap.js"></script>

<script src="assets/js/bootstrap.min.js"></script> -->

  <script src="<?= SITE_URL ?>assets/web/js/custom.js"></script>

  <script>
    $('.app-carousel').owlCarousel({

      loop: true,

      margin: 50,

      nav: false,

      autoplay: true,

      responsive: {

        0: {

          items: 1

        },

        600: {

          items: 2

        },

        1000: {

          items: 3

        }

      }

    })
  </script>

  <script>
    AOS.init();

    $('#multi-slider .carousel-item').each(function() {

      var next = $(this).next();



      for (var i = 0; i < 2; i++) {

        if (!next.length) {

          next = $(this).siblings(':first');

        }

        next.children(':first').children(':first').clone().addClass('d-none d-md-block').appendTo($(this).children(':first'));



        next = next.next();

      }

    });

    $(window).scroll(function() {

      var scroll = $(window).scrollTop();

      if (scroll < 300) {

        $('.fixed-top').css('background', 'transparent');

      } else {

        $('.fixed-top').css('background', '#ffffff');

      }

    });
  </script>

</body>

</html>