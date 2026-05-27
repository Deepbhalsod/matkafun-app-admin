<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https:   //codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/** Default Controller */
$route['default_controller'] = DEFAULT_CONTROLLER;


/*footer*/
$route['password']                  = 'Frontend/password';
$route['forgot_pass']               = 'Frontend/forgot_pass';
$route['about']                     = 'Frontend/about_us';
$route['delivery']                  = 'Frontend/delivery';
$route['returns']                   = 'Frontend/returns';
$route['contact']                   = 'Frontend/contact_us';
$route['privacy']                   = 'Frontend/privacy_policy';
$route['faq']                       = 'Frontend/faq';

/* header */

$route['home']                              = 'pages/home';
$route['gali_disawar_game_rate']            = 'pages/gali_disawar_game_rate';
$route['starline_game_rate']                = 'pages/starline_game_rate';
$route['game_chart/(:any)']                 = 'pages/game_chart/$1';
$route['privacy_policy']                    = 'pages/privacy_policy';

/** Dashboard */
$route['dashboard/login']               = 'admin/login';
$route['dashboard/forgot_pass']         = 'admin/forgot_password';
$route['dashboard/logout']              = 'admin/logout';
$route['dashboard']                     = 'admin/home';
$route['dashboard/my_profile']          = 'admin/my_profile';
$route['dashboard/change_pass']          = 'admin/change_password';
$route['list/admin']                    = 'admin/list_admin';
$route['add/admin']                     = 'admin/add_admin';
$route['edit/admin/(:any)']           = 'admin/edit_admin/$1';
$route['delete/admin/(:any)']           = 'admin/delete_admin/$1';


$route['list/query']          = 'query/list_query';

// Pages routes
$route['list/page']          = 'page/list_pages';
$route['edit/page']   = 'page/edit_pages';
$route['settings/(:any)']               = 'setting/list_setting/$1';
$route['edit/setting/(:any)']           = 'setting/edit_setting/$1';


$route['edit/report/(:any)']           = 'Report/edit_user_bid_history/$1';


// banner
$route['list/banner']                     = 'banner/list_banner';
$route['add/banner']                      = 'banner/add_banner';
$route['edit/banner/(:any)']              = 'banner/edit_banner/$1';


/** app image */
$route['list/firstaid']                    = 'firstaid/list_firstaid';
$route['add/app_image']                     = 'firstaid/add_firstaid';
$route['edit/firstaid/(:any)']             = 'firstaid/edit_firstaid/$1';
$route['delete/firstaid/(:any)']           = 'firstaid/delete_firstaid/$1';

/** File Manager */
$route['list/manager']                      = 'manager/list_manager';
$route['add/manager']                       = 'manager/add_manager';
$route['edit/manager/(:any)']               = 'manager/edit_manager/$1';
$route['delete/manager/(:any)']             = 'manager/delete_manager/$1';

/** video */
$route['list/video']                      = 'video/list_video';
$route['edit/video/(:any)']               = 'video/edit_video/$1';
$route['change-status/video/(:any)']      = 'video/change_status_video/$1';

$route['account_list/settings']                     = 'setting/add_account';


// Report
$route['sell_report_list/report']       = 'report/sell_report_list';
$route['report_user_bid_history_list/report']       = 'report/report_user_bid_history_list';
$route['report_transfer_point_report_list/report']       = 'report/report_transfer_point_report_list';
$route['winning_report_list/report']       = 'report/winning_report_list';
$route['bid_winning_report_list/report']       = 'report/bid_winning_report_list';
$route['withdraw_report_list/report']       = 'report/withdraw_report_list';


$route['add_fund_report_list/report']       = 'report/add_fund_report_list';
$route['auto_deposite_history_list/report']       = 'report/auto_deposite_history_list';

$route['sell_report_list/starline']       = 'starline/sell_report_list';
$route['sell_report_list/gali_disawar']       = 'Galidisawar/sell_report_list';

$route['starline_prediction_list/starline']       = 'starline/prediction_list';
// winning prediction

$route['list/prediction']                  = 'prediction/list_prediction';


/** User */
$route['list/user']                                  = 'user/list_user';
$route['delete/user/(:any)']                         = 'user/delete_user/$1';
$route['change_status_user/user/(:any)']                  = 'user/change_status_user/$1';
$route['user_detail_list/user/(:any)']                     = 'user/user_detail_list/$1';
$route['payment_list/user/(:any)']                     = 'user/payment_list/$1';
$route['fund_credit_list/user/(:any)']                     = 'user/fund_credit_list/$1';
$route['fund_dedit_list/user/(:any)']                     = 'user/fund_dedit_list/$1';
$route['fund_req_list/user/(:any)']                     = 'user/fund_req_list/$1';

$route['unapprove_user_list/user']                                  = 'user/list_unapprove_user';

/** game */
$route['list/game']                     = 'game/list_game';
$route['add/game']                      = 'game/add_game';
$route['edit/game/(:any)']              = 'game/edit_game/$1';
$route['change_status_game/game/(:any)']     = 'game/change_status_game/$1';
$route['delete/game/(:any)']            = 'game/delete_game/$1';

/** game rate */
$route['list/game_rate']                     = 'GameRate/list_game_rate';
$route['add/game_rate']                      = 'GameRate/add_game_rate';

$route['change_status_game/game_rate/(:any)']     = 'GameRate/change_status_game/$1';
$route['delete/game_rate/(:any)']                 = 'GameRate/delete_game/$1';


/** game & number */

$route['list/number/(:any)']                         = 'Number/list_game_number/$1';


/** starline */
$route['list/starline']                     = 'starline/list_game_starline';
$route['starline_win_report_list/starline']                     = 'starline/starline_winning_report_list';
$route['add/starline']                      = 'starline/add_game_starline';
$route['delete/starline/(:any)']                        = 'starline/delete_starline_game/$1';
$route['change_status_game_starline/starline/(:any)']     = 'starline/change_status_gamestarline/$1';

$route['edit/starline/(:any)']              = 'starline/edit_game_starline/$1';
$route['edit_bid/starline/(:any)']              = 'starline/edit_bid_history_starline/$1';

$route['game_rate_add/starline']                  = 'starline/add_game__rate_starline';
$route['starlineBid_history_list/starline']       = 'starline/starline_bid_history_list';

$route['result_list/starline']       = 'starline/list_result_starline';
$route['result_history_list/starline']                      = 'starline/result_history_starline';


/** Galidisawar  */

$route['prediction_list/gali_disawar']       = 'Galidisawar/prediction_list';


$route['list/gali_disawar']                                 = 'Galidisawar/list_game_gali_disawar';
$route['win_report_list/gali_disawar']             = 'Galidisawar/gali_disawar_winning_report_list';
$route['add/gali_disawar']                                  = 'Galidisawar/add_game_gali_disawar';
$route['delete/gali_disawar/(:any)']                        = 'Galidisawar/delete_gali_disawar_game/$1';
$route['change_status_game_starline/gali_disawar/(:any)']   = 'Galidisawar/change_status_gamegali_disawar/$1';

$route['edit/gali_disawar/(:any)']                          = 'Galidisawar/edit_game_gali_disawar/$1';
$route['edit_bid/gali_disawar/(:any)']                      = 'Galidisawar/edit_bid_history_gali_disawar/$1';

$route['game_rate_add/gali_disawar']                        = 'Galidisawar/add_game__rate_gali_disawar';
$route['Bid_history_list/gali_disawar']             = 'Galidisawar/gali_disawar_bid_history_list';

$route['result_list/gali_disawar']                          = 'Galidisawar/list_result_gali_disawar';
$route['result_history_list/gali_disawar']                  = 'Galidisawar/result_history_gali_disawar';


$route['list/roles']                    = 'UserRole/list_roles';


$route['account_list/slider']                     = 'slider/list_account';

/** result */
$route['list/result']                     = 'result/list_result';
$route['add/result']                      = 'result/add_result';
$route['edit/result/(:any)']              = 'result/edit_bid_history/$1';
$route['change_status_result/result/(:any)']     = 'result/change_status_result/$1';
$route['delete/result/(:any)']            = 'result/delete_result/$1';
$route['autoresult/fetchAutoResult/(:any)']                 = 'AutoResult/fetchAutoResult/$1';


/** fund */
$route['fund_req_list/fund']                     = 'fund/list_fund_req';
$route['withdraw_req_list/fund']                     = 'fund/list_withdraw_req';
$route['bid_revert_list/fund']                     = 'fund/bid_revert_list';

$route['add/fund']                      = 'fund/add_fund';
$route['change_status_result/fund/(:any)']     = 'fund/change_status_result/$1';
$route['delete/fund/(:any)']            = 'fund/delete_result/$1';


/** Certificates */
$route['list/certificates']                     = 'Certificates/list_certificates';
$route['details_list/certificates']                   = 'Certificates/list_details';
$route['add/certificates']                      = 'Certificates/add_certificates';
$route['edit/certificates/(:any)']              = 'Certificates/edit_certificates/$1';
$route['change-status/certificates/(:any)']     = 'Certificates/change_status_certificates/$1';
$route['delete/certificates/(:any)']            = 'Certificates/delete_certificates/$1';

/* Qualifications */
$route['list/qualifications']                     = 'Qualifications/list_qualifications';
$route['add/qualifications']                      = 'Qualifications/add_qualifications';
$route['edit/qualifications/(:any)']              = 'Qualifications/edit_qualifications/$1';
$route['delete/qualifications/(:any)']            = 'Qualifications/delete_qualifications/$1';
$route['change-status/qualifications/(:any)']     = 'Qualifications/change_status_qualifications/$1';

/* Experience */
$route['list/experiences']                      = 'Experience/list_experiences';
$route['add/experiences']                       = 'Experience/add_experiences';
$route['edit/experiences/(:any)']               = 'Experience/edit_experiences/$1';
$route['delete/experiences/(:any)']             = 'Experience/delete_experiences/$1';
$route['change-status/experiences/(:any)']      = 'Experience/change_status_experiences/$1';
$route['icon_list/experiences']                 = 'Experience/list_experiences_icon';
$route['working_list/experiences']                 = 'Experience/list_experiences_working';
$route['icon_edit/experiences/(:any)']          = 'Experience/edit_experiences_icon/$1';
$route['working_edit/experiences/(:any)']        = 'Experience/edit_experiences_working/$1';
$route['change-icon-status/experiences/(:any)'] = 'Experience/change_icon_status/$1';

/* Skills */
$route['list/skills']                     = 'Skills/list_skills';
$route['add/skills']                      = 'Skills/add_skills';
$route['edit/skills/(:any)']              = 'Skills/edit_skills/$1';
$route['delete/skills/(:any)']            = 'Skills/delete_skills/$1';
$route['change-status/skills/(:any)']     = 'Skills/change_status_skills/$1';

/* Vehicles */
$route['list/vehicles']                     = 'Vehicles/list_vehicles';
$route['add/vehicles']                      = 'Vehicles/add_vehicles';
$route['edit/vehicles/(:any)']              = 'Vehicles/edit_vehicles/$1';
$route['delete/vehicles/(:any)']            = 'Vehicles/delete_vehicles/$1';
$route['change-status/vehicles/(:any)']     = 'Vehicles/change_status_vehicles/$1';

/* Electronics */
$route['list/electronics']                     = 'Electronics/list_electronics';
$route['add/electronics']                      = 'Electronics/add_electronics';
$route['edit/electronics/(:any)']              = 'Electronics/edit_electronics/$1';
$route['delete/electronics/(:any)']            = 'Electronics/delete_electronics/$1';
$route['change-status/electronics/(:any)']     = 'Electronics/change_status_electronics/$1';

/* Jobs Category */
$route['list/category']                     = 'category/list_category';
$route['details_list/category']           = 'category/list_details';
$route['add/category']                      = 'category/add_category';
$route['edit/category/(:any)']              = 'category/edit_category/$1';
$route['delete/category/(:any)']            = 'category/delete_category/$1';
$route['change-status/category/(:any)']     = 'category/change_status_category/$1';

/* Traning Category */
$route['list/traning_category']                     = 'TraningCategory/list_category';
$route['add/traning_category']                      = 'TraningCategory/add_category';
$route['edit/traning_category/(:any)']              = 'TraningCategory/edit_category/$1';
$route['delete/traning_category/(:any)']            = 'TraningCategory/delete_category/$1';
$route['change-status/traning_category/(:any)']     = 'TraningCategory/change_status_category/$1';

/* Traning */
$route['list/trainings']                     = 'Trainings/list_trainings';
$route['details_list/trainings']             = 'Trainings/list_details';
$route['add/trainings']                      = 'Trainings/add_trainings';
$route['edit/trainings/(:any)']              = 'Trainings/edit_trainings/$1';
$route['delete/trainings/(:any)']            = 'Trainings/delete_trainings/$1';
$route['change-status/trainings/(:any)']     = 'Trainings/change_status_trainings/$1';

/* RedeemRequest */
$route['list/redeem']                       = 'RedeemRequest/list_redeem';
$route['add/redeem']                        = 'RedeemRequest/add_redeem';
$route['edit/redeem/(:any)']                = 'RedeemRequest/edit_redeem/$1';
$route['delete/redeem/(:any)']              = 'RedeemRequest/delete_redeem/$1';
$route['pay/redeem/(:any)/(:any)/(:any)']   = 'RedeemRequest/pay/$1/$2/$3';
$route['decline/redeem/(:any)']             = 'RedeemRequest/decline/$1';

/* Ratings */
$route['list/ratings']                       = 'Ratings/list_ratings';
$route['add/ratings']                        = 'Ratings/add_ratings';
$route['edit/ratings/(:any)']              = 'Ratings/edit_ratings/$1';
$route['delete/ratings/(:any)']            = 'Ratings/delete_ratings/$1';
$route['change-status/ratings/(:any)']     = 'Ratings/change_status_ratings/$1';

/* App Ratings */
$route['list/appratings']                       = 'Apprating/list_appratings';
$route['add/appratings']                        = 'Apprating/add_appratings';
$route['edit/appratings/(:any)']                = 'Apprating/edit_appratings/$1';
$route['delete/appratings/(:any)']              = 'Apprating/delete_appratings/$1';
$route['change-status/appratings/(:any)']       = 'Apprating/change_status_appratings/$1';

/* Sliders */
$route['list/slider']                   = 'slider/list_slider';
$route['add/slider']                    = 'slider/add_slider';
$route['edit/slider/(:any)']            = 'slider/edit_slider/$1';
$route['delete/slider/(:any)']          = 'slider/delete_slider/$1';
$route['change-status/slider/(:any)']   = 'slider/change_status/$1';

/* Jobs */
$route['list/job']                   = 'Job/list_job';
$route['details_list/job']           = 'Job/list_details';
$route['add/job']                    = 'Job/add_job';
$route['edit/job/(:any)']            = 'Job/edit_job/$1';
$route['delete/job/(:any)']          = 'Job/delete_job/$1';
$route['change-status/job/(:any)']   = 'Job/change_status/$1';

/* Assign Jobs */
$route['list/assignjobs']                   = 'Assignjobs/list_assignjobs';
$route['details_list/assignjobs']           = 'Assignjobs/list_details';
$route['add/assignjobs']                    = 'Assignjobs/add_assignjobs';
$route['edit/assignjobs/(:any)']            = 'Assignjobs/edit_assignjobs/$1';
$route['delete/assignjobs/(:any)']          = 'Assignjobs/delete_assignjobs/$1';
$route['change-status/assignjobs/(:any)']   = 'Assignjobs/change_status_assignjobs/$1';

/** employees */
$route['list/employees']                         = 'Employees/list_employees';
$route['employeedetails_list/employees/(:any)']  = 'Employees/list_employeedetails/$1';
$route['bio_list/employees/(:any)']              = 'Employees/list_employees_bio/$1';
$route['educations_list/employees/(:any)']       = 'Employees/list_employees_educations/$1';
$route['bankdetails_list/employees/(:any)']      = 'Employees/list_employees_bankdetails/$1';
$route['emails_list/employees/(:any)']           = 'Employees/list_employees_emails/$1';
$route['contact_list/employees/(:any)']          = 'Employees/list_employees_contact/$1';
$route['experiences_list/employees/(:any)']      = 'Employees/list_employees_experiences/$1';
$route['skills_list/employees/(:any)']           = 'Employees/list_employees_skills/$1';
$route['achivements_list/employees/(:any)']      = 'Employees/list_employees_achivements/$1';
$route['languages_list/employees/(:any)']        = 'Employees/list_employees_languages/$1';
$route['appliedjobs_list/employees/(:any)']      = 'Employees/list_employees_appliedjobs/$1';
$route['assignjobs_list/employees/(:any)']       = 'Employees/list_employees_assignjobs/$1';
$route['favjobs_list/employees/(:any)']          = 'Employees/list_employees_favjobs/$1';
$route['completejobs_list/employees/(:any)']     = 'Employees/list_employees_completejobs/$1';
$route['jobdetails_list/employees/(:any)']       = 'Employees/list_employees_jobdetails/$1';
$route['add/employees']                          = 'Employees/add_employees';
$route['edit/employees/(:any)']                  = 'Employees/edit_employees/$1';
$route['delete/employees/(:any)']                = 'Employees/delete_employees/$1';
$route['bio_delete/employees/(:any)']            = 'Employees/delete_employees_bio/$1';
$route['education_delete/employees/(:any)']      = 'Employees/delete_employees_education/$1';
$route['bankdetails_delete/employees/(:any)']     = 'Employees/delete_employees_bankdetails/$1';
$route['emails_delete/employees/(:any)']         = 'Employees/delete_employees_emails/$1';
$route['contacts_delete/employees/(:any)']       = 'Employees/delete_employees_contacts/$1';
$route['experiences_delete/employees/(:any)']     = 'Employees/delete_employees_experiences/$1';
$route['skills_delete/employees/(:any)']         = 'Employees/delete_employees_skills/$1';
$route['achivements_delete/employees/(:any)']     = 'Employees/delete_employees_achivements/$1';
$route['languages_delete/employees/(:any)']      = 'Employees/delete_employees_languages/$1';
$route['change-status/employees/(:any)']         = 'Employees/change_status_employees/$1';
$route['history_employees/employees/(:any)']     = 'Employees/history_list_employees/$1';
$route['history_delete/employees/(:any)']        = 'Employees/history_employees_delete/$1';
$route['assignss_delete/employees/(:any)']        = 'Employees/assignss_employees_delete/$1';
$route['applied_delete/employees/(:any)']        = 'Employees/applied_employees_delete/$1';
$route['favjobs_delete/employees/(:any)']        = 'Employees/favjobs_employees_delete/$1';

/** Questions */
$route['list/questions']                     = 'Questions/list_questions';
$route['details_list/questions']             = 'Questions/list_details';
$route['add/questions']                      = 'Questions/add_questions';
$route['edit/questions/(:any)']              = 'Questions/edit_questions/$1';
$route['delete/questions/(:any)']            = 'Questions/delete_questions/$1';
$route['change-status/questions/(:any)']     = 'Questions/change_status_questions/$1';

/** Age Group */
$route['list/age']                           = 'Age/list_age';
$route['add/age']                            = 'Age/add_age';
$route['edit/age/(:any)']                    = 'Age/edit_age/$1';
$route['delete/age/(:any)']                  = 'Age/delete_age/$1';
$route['change-status/age/(:any)']           = 'Age/change_status_age/$1';

/** Shortlisted */
$route['list/shortlisted']                           = 'Shortlisted/list_shortlisted';
$route['details_list/shortlisted']                   = 'Shortlisted/list_details';
$route['add/shortlisted']                            = 'Shortlisted/add_shortlisted';
$route['edit/shortlisted/(:any)']                    = 'Shortlisted/edit_shortlisted/$1';
$route['delete/shortlisted/(:any)']                  = 'Shortlisted/delete_shortlisted/$1';
$route['change-status/shortlisted/(:any)']           = 'Shortlisted/change_status_shortlisted/$1';

/* Notifications */
$route['list/notification']             = 'notification/list_notification';
$route['add/notification']              = 'notification/add_notification';
$route['delete/notification/(:any)']    = 'notification/delete_notification/$1';
$route['singleadd/notification']        = 'notification/add_single_notification';

/** List */
// $route['list/([^/]+)/?']  = 'user/list_user/$1'; // To Show List/Super-admin or List/admin or List/manager
$route['list/all/([^/]+)/?']            = 'user/list_users/$1';
$route['list/assign-users']             = 'UserRole/list_roles';
$route['list/bookings']                 = 'booking/list_bookings';
$route['list/categories']               = 'category/list_category';
//$route['list/comments']                 = 'comment/list_comment';
$route['list/contact-us']               = 'lead/list_contactus';
$route['list/content']                  = 'Content/list_content';
$route['list/customers']                = 'lead/list_customers';
$route['list/filters']                  = 'filter/list_filter';
$route['list/galleries']                = 'gallery/list_galleries';
$route['list/leads']                    = 'lead/list_leads';
$route['list/orders']                   = 'order/list_orders';
$route['list/posts']                    = 'post/list_post';
//$route['list/products']                 = 'product/list_products';
$route['list/projects']                 = 'project/list_projects';
$route['list/properties']               = 'property/list_property';
$route['list/roles']                    = 'UserRole/list_roles';
$route['list/scraped']                  = 'lead/list_scraped';
$route['settings/(:any)']               = 'setting/list_setting/$1';

$route['list/testimonials']             = 'testimonial/list_testimonial';
$route['list/tests']                    = 'test/list_test';


/** Add */
$route['add/booking']                   = 'booking/add_booking';
$route['add/category']                  = 'category/add_category';
//$route['add/comment']                   = 'comment/add_comment';
$route['add/content']                   = 'Content/add_content';
$route['add/filter']                    = 'filter/add_filter';
$route['add/gallery']                   = 'gallery/add_gallery';
$route['add/lead']                      = 'lead/add_lead';
$route['add/order']                     = 'order/add_order';
$route['add/post']                      = 'post/add_post';
$route['add/product']                   = 'product/add_product';
$route['add/project']                   = 'project/add_project';
$route['add/property']                  = 'property/add_property';
$route['add/slider']                    = 'slider/add_slider';
// $route['add/setting']                   = 'setting/add_setting';
$route['add/test']                      = 'test/add_test';
$route['add/testimonial']               = 'testimonial/add_testimonial';
$route['add/user-role']                 = 'UserRole/add_role';


/** Edit */
$route['edit/booking/(:any)']           = 'booking/edit_booking/$1';

    //$route['edit/comment/(:any)']           = 'comment/edit_comment/$1';
;
$route['edit/gallery/(:any)']           = 'gallery/edit_gallery/$1';
$route['edit/lead/(:any)']              = 'lead/edit_lead/$1';
$route['edit/order/(:any)']             = 'order/edit_order/$1';
$route['edit/post/(:any)']              = 'post/edit_post/$1';
$route['edit/project/(:any)']           = 'project/edit_project/$1';
$route['edit/setting/(:any)']           = 'setting/edit_setting/$1';
$route['edit/test/(:any)']              = 'test/edit_test/$1';
$route['edit/testimonial/(:any)']       = 'testimonial/edit_testimonial/$1';
$route['edit/user-role/(:any)']         = 'UserRole/edit_role/$1';


/** Delete */
$route['delete/booking/(:any)']         = 'booking/delete_booking/$1';
//$route['delete/comment/(:any)']         = 'comment/delete_comment/$1';
$route['delete/gallery/(:any)']         = 'gallery/delete_gallery/$1';
$route['delete/lead/(:any)']            = 'lead/delete_lead/$1';
$route['delete/order/(:any)']           = 'order/delete_order/$1';
$route['delete/post/(:any)']            = 'post/delete_post/$1';
$route['delete/product/(:any)']         = 'product/delete_product/$1';
$route['delete/project/(:any)']         = 'project/delete_project/$1';
$route['delete/property/(:any)']        = 'property/delete_property/$1';
$route['delete/slider/(:any)']          = 'slider/delete_slider/$1';
$route['delete/test/(:any)']            = 'test/delete_test/$1';
$route['delete/testimonial/(:any)']     = 'testimonial/delete_testimonial/$1';
$route['delete/user-role/(:any)']       = 'UserRole/delete_role/$1';

$route['404_override']                  = '';
$route['translate_uri_dashes']          = FALSE;
