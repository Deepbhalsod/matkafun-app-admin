<?php defined('BASEPATH') or exit('No direct script access allowed');

?>
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container sidebar-closed sbar-open" id="container">

	<!-- <div class="overlay"></div> -->
	<div class="cs-overlay"></div>
	<div class="search-overlay"></div>

	<!--  BEGIN SIDEBAR  -->
	<div class="sidebar-wrapper sidebar-theme">

		<nav id="sidebar">

			<ul class="navbar-nav theme-brand flex-row  text-center">
				<li class="nav-item theme-logo">
					<a href="<?php echo SITE_URL; ?>dashboard">
						<img src="<?php echo SITE_URL; ?>assets/img/logo.png" style="border-radius:100%;" class="navbar-logo" alt="logo">
					</a>
				</li>
				<li class="nav-item theme-text">
					<a href="<?php echo SITE_URL; ?>dashboard" class="nav-link">
						<?php echo SITE_NAME; ?>
					</a>
				</li>
				<li class="nav-item sidebar-dismiss-icon">
					<a href="javascript:void(0);" class="sidebarCollapse">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
							<line x1="18" y1="6" x2="6" y2="18"></line>
							<line x1="6" y1="6" x2="18" y2="18"></line>
						</svg>
					</a>
				</li>
			</ul>

			<ul class="list-unstyled menu-categories" id="mainMenu">
				<li class="menu active mb-4">
					<a href="<?php echo SITE_URL; ?>dashboard" aria-expanded="true" class="dropdown-toggle">
						<div class="">
							<?php echo ICONS['dashboard']; ?>
							<span>Dashboard</span>
						</div>
					</a>
				</li>
				<?php

				$menus = [

					'User Management' => [
						'icon' => 'employees',
						'url' => 'list/user',
						'user_can' => 'user_list'
					],

					'games_management' => [
						'sub_menu' => [
							'game_name_list' => [
								'url' => 'list/game',
								'user_can' => 'game_list'
							],
							'game_rate_list' => [
								'url' => 'add/game_rate',
								'user_can' => 'game_rate_add'
							]
						],
						'icon' => 'game',
						'url' => 'game_list/game',
						'user_can' => 'game_list'
					],

					'declare Result' => [
						'icon' => 'job',
						'url' => 'list/result',
						'user_can' => 'result_list'
					],

					'winning Prediction' => [
						'icon' => 'prediction',
						'url' => 'list/prediction',
						'user_can' => 'prediction_list'
					],

					'report_management' => [
						'sub_menu' => [
							'userbidhistory_list' => [
								'url' => 'report_user_bid_history_list/report',
								'user_can' => 'report_user_bid_history_list'
							],
							'customer_sell_report_list' => [
								'url' => 'sell_report_list/report',
								'user_can' => 'report_customer_sell_report_list'
							],
							'winning_report_list' => [
								'url' => 'winning_report_list/report',
								'user_can' => 'report_winning_report_list'
							],
							'transfer_point_report_list' => [
								'url' => 'report_transfer_point_report_list/report',
								'user_can' => 'report_transfer_point_report_list'
							],
							'bid_winning_report_list' => [
								'url' => 'bid_winning_report_list/report',
								'user_can' => 'report_bid_winning_report_list'
							],
							'withdraw_report_list' => [
								'url' => 'withdraw_report_list/report',
								'user_can' => 'report_withdraw_report_list'
							],
							'add_fund_report_list' => [
								'url' => 'add_fund_report_list/report',
								'user_can' => 'report_add_fund_report_list'
							],
							'auto_deposite_history_list' => [
								'url' => 'auto_deposite_history_list/report',
								'user_can' => 'report_auto_deposite_history_list'
							],
						],

						'icon' => 'shortlisted',
						'url' => 'list/report',
						'user_can' => 'report_list'
					],

					'wallet_management' => [
						'sub_menu' => [
							'fund_request_list' => [
								'url' => 'fund_req_list/fund',
								'user_can' => 'fund_request_list'
							],
							'withdraw_request_list' => [
								'url' => 'withdraw_req_list/fund',
								'user_can' => 'withdraw_req_list'
							],
							'add_fund' => [
								'url' => 'add/fund',
								'user_can' => 'wallet_add_fund'
							],
							'bid_revert' => [
								'url' => 'bid_revert_list/fund',
								'user_can' => 'wallet_bid_revert'
							]
						],
						'icon' => 'questions',
						'url' => 'wallet_bid_revert/fund',
						'user_can' => 'wallet_bid_revert'
					],

					'games_and_number' => [
						'sub_menu' => [
							'single_digit' => [
								'url' => 'list/number/single_digit',
								'user_can' => 'number_digit_list'
							],
							'jodi_digit' => [
								'url' => 'list/number/jodi_digit',
								'user_can' => 'number_digit_list'
							],
							'single_panna' => [
								'url' => 'list/number/single_panna',
								'user_can' => 'number_digit_list'
							],
							'double_panna' => [
								'url' => 'list/number/double_panna',
								'user_can' => 'number_digit_list'
							],
							'triple_panna' => [
								'url' => 'list/number/triple_panna',
								'user_can' => 'number_digit_list'
							],
							'half_sangam' => [
								'url' => 'list/number/half_sangam',
								'user_can' => 'number_digit_list'
							],
							'full_sangam' => [
								'url' => 'list/number/full_sangam',
								'user_can' => 'number_digit_list'
							]
						],

						'icon' => 'traningcategory',
						'url' => 'single_digit_list/number',
						'user_can' => 'number_digit_list'
					],

					'starline_management' => [
						'sub_menu' => [
							'game_name_list' => [
								'url' => 'list/starline',
								'user_can' => 'starline_game_list'
							],
							'game_rates_list' => [
								'url' => 'game_rate_add/starline',
								'user_can' => 'starline_game_rates_list'
							],
							'bid_history_list' => [
								'url' => 'starlineBid_history_list/starline',
								'user_can' => 'starline_bid_history_list'
							],
							'declare_result_list' => [
								'url' => 'result_list/starline',
								'user_can' => 'starline_declare_result_list'
							],
							'result_history_list' => [
								'url' => 'result_history_list/starline',
								'user_can' => 'starline_result_history_list'
							],
							'sell_report_list' => [
								'url' => 'sell_report_list/starline',
								'user_can' => 'starline_sell_report_list'
							],
							'winning_report_list' => [
								'url' => 'starline_win_report_list/starline',
								'user_can' => 'starline_winning_report_list'
							],
							'winning_prediction_list' => [
								'url' => 'starline_prediction_list/starline',
								'user_can' => 'starline_winning_prediction_list'
							],
						],
						'icon' => 'certificates',
						'url' => 'list/certificates',
						'user_can' => 'certificates_list'
					],
					'gali_disawar_management' => [
						'sub_menu' => [
							'game_name_list' => [
								'url' => 'list/gali_disawar',
								'user_can' => 'starline_game_list'
							],
							'game_rates_list' => [
								'url' => 'game_rate_add/gali_disawar',
								'user_can' => 'starline_game_rates_list'
							],
							'bid_history_list' => [
								'url' => 'Bid_history_list/gali_disawar',
								'user_can' => 'starline_bid_history_list'
							],
							'declare_result_list' => [
								'url' => 'result_list/gali_disawar',
								'user_can' => 'starline_declare_result_list'
							],
							'result_history_list' => [
								'url' => 'result_history_list/gali_disawar',
								'user_can' => 'starline_result_history_list'
							],
							'sell_report_list' => [
								'url' => 'sell_report_list/gali_disawar',
								'user_can' => 'starline_sell_report_list'
							],
							'winning_report_list' => [
								'url' => 'win_report_list/gali_disawar',
								'user_can' => 'starline_winning_report_list'
							],
							'winning_prediction_list' => [
								'url' => 'prediction_list/gali_disawar',
								'user_can' => 'starline_winning_prediction_list'
							],
						],
						'icon' => 'galidisawar',
						'url' => 'list/gali_disawar',
						'user_can' => 'certificates_list'
					],

					'notifications' => [
						'sub_menu' => [
							'send_notification' => [
								'url' => 'singleadd/notification',
								'user_can' => 'add_notification'
							],
							'notification_list' => [
								'url' => 'list/notification',
								'user_can' => 'notification_list'
							]
						],
						'icon' => 'notification',
						'url' => 'list/notification',
						'user_can' => 'notification_list'
					],

					'user_queries' => [
						'icon' => 'redeem',
						'url' => 'list/query',
						'user_can' => 'user_queries_list'
					],
					'web_setting' => [
						'sub_menu' => [
							'banner' => [
								'url' => 'list/banner',
								'user_can' => 'web_setting_list'
							],
							'app_image' => [
								'url' => 'list/firstaid',
								'user_can' => 'web_setting_list'
							],
							'apk_manager' => [
								'url' => 'list/manager',
								'user_can' => 'web_setting_list'
							],
							'video' => [
								'url' => 'list/video',
								'user_can' => 'web_setting_list'
							],
							'Page' => [
								'url' => 'edit/page',
								'user_can' => 'web_setting_list'
							]
						],
						'icon' => 'setting',
						'url' => 'edit/page',
						'user_can' => 'web_setting_list'
					],
					'setting' => [
						'sub_menu' => [
							'account_list' => [
								'url' => 'account_list/settings',
								'user_can' => 'setting_list'
							],
							'setting_list' => [
								'url' => 'settings/brand',
								'user_can' => 'setting_list'
							],

							'how_to_play_list' => [
								'url' => 'list/page',
								'user_can' => 'slider_list'
							],
							'withdraw_time' => [
                'url' => 'withdraw-time-admin.php',
                'user_can' => 'slider_list'
              ],
              'notice_app' => [
                'url' => '/notifications/notice.php',
                'user_can' => 'slider_list'
              ]
						],
						'icon' => 'setting',
						'url' => 'setting_list/notification',
						'user_can' => 'setting_list'
					],



				];


				sidebar_menu($menus);

				if (user_can('user-role_list')) : ?>
					<!-- User Roles & Modules -->
					<li class="menu mt-2">
						<a href="#role" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
							<div class="">
								<?php echo ICONS['shortlisted']; ?>
								<span>Admin & Roles Modules</span>
							</div>
							<div>
								<?php echo ICONS['right']; ?>
							</div>
						</a>
						<ul class="collapse submenu list-unstyled" id="role" data-parent="#mainMenu">
							<li>
								<a href="<?php echo SITE_URL; ?>list/admin">Admin List</a>
							</li>
							<li>
								<a href="<?php echo SITE_URL; ?>add/admin">Admin Add</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>


			</ul>

		</nav>

	</div>
	<!--  END SIDEBAR  -->

	<!--  BEGIN CONTENT AREA  -->
	<div id="content" class="main-content">
		<div class="layout-px-spacing">