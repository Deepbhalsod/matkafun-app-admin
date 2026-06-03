<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');



// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/** Check `ErrorMsg.php` Exists */
file_exists(APPPATH . 'third_party/errorMsg.php') or exit("<center style='color: #3a4161'><h1 style='margin: 25% 0%;font-family: serif; font-size: 40px'>`ErrorMsg.php` Not Exists.</h1></center>");

/** Include `ErrorMsg.php` */
require_once APPPATH . 'third_party/errorMsg.php';

/** Check PHP Version */
version_compare(PHP_VERSION, '7.0.0', '>=') or errorMsg::Show('Your PHP Version is ' . PHP_VERSION . ', To Continue Please Update Your PHP Version to 7.0.0');

/** Get Protocol */
errorMsg::get_protocol() or errorMsg::Show('Protocol Not Define');

/** Site name : `Base Project` */
defined('SITE_NAME') or define('SITE_NAME', 'MatkaFun');
defined('Unit') or define('Unit', '');

defined('PASSWORD_SALT') or define('PASSWORD_SALT', md5('TwsTechies'));

define('DEFAULT_CONTROLLER', 'Pages/home');

define('DEFAULT_VIEW', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'public');
file_exists(APPPATH . '../temp/') or mkdir(APPPATH . '../temp/', 0777);

defined('SESS_PATH') or define('SESS_PATH', APPPATH . '../temp/');


define("DB_HOST", 'localhost');
define("DB_USER", 'sql_matkafun_fun');
define("DB_PASS", "MatkaFun@2025");
define("DB_NAME", 'sql_matkafun_fun');

// define("DB_USER", 'u472706178_pune777');
// define("DB_PASS", "Pune777@2025");
// define("DB_NAME", 'u472706178_pune777');
$root_folder = '/';

// define("DB_HOST", 'localhost');
// define("DB_USER", 'u619212085_delhi');
// define("DB_PASS", '$Z4h*+hW[C3y');
// define("DB_NAME", 'u619212085_delhi');
// $root_folder = '/';
/** Site Url : `$_SERVER['HTTP_HOST']` */
defined('SITE_URL')
	or define('SITE_URL', errorMsg::get_protocol() . $_SERVER['HTTP_HOST'] . $root_folder);


/** Svg Sidebar Icons */
const ICONS = [
	"redeem" => '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
	<circle cx="1.65" cy="1.65" r="1.65" transform="matrix(-1 0 0 1 12 1)" stroke="#1C274C" stroke-width="0.825"/>
	<path opacity="0.5" d="M7.6 1.11002C7.24458 1.03787 6.87671 1 6.5 1C3.46243 1 1 3.46243 1 6.5C1 7.37983 1.20659 8.2114 1.5739 8.94886C1.67152 9.14484 1.704 9.36884 1.64741 9.58034L1.31983 10.8047C1.17762 11.3361 1.66386 11.8224 2.19534 11.6802L3.41966 11.3526C3.63116 11.296 3.85516 11.3285 4.05114 11.4261C4.7886 11.7934 5.62017 12 6.5 12C9.53757 12 12 9.53757 12 6.5C12 6.12329 11.9621 5.75542 11.89 5.4" stroke="#1C274C" stroke-width="0.825" stroke-linecap="round"/>
	</svg>',
	"certificates" => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
		<path d="M10.3992 5.64079L10.0341 5.99813L10.3992 6.35547L11.477 7.41026L11.4769 7.41031L11.483 7.41601C11.4936 7.42608 11.4968 7.43383 11.4983 7.43985C11.5004 7.4477 11.5009 7.45903 11.4974 7.47205C11.4939 7.48513 11.4876 7.49487 11.4819 7.50072C11.4774 7.50529 11.4717 7.50939 11.4605 7.51208L11.4604 7.51202L11.4531 7.51389L9.98476 7.88866L9.48675 8.01576L9.62753 8.51008L10.0408 9.96133C10.0409 9.96154 10.0409 9.96176 10.041 9.96197C10.0443 9.97399 10.0435 9.9823 10.0413 9.98978C10.0387 9.99908 10.0325 10.0107 10.0217 10.0215C10.0109 10.0323 9.99935 10.0384 9.99016 10.0411C9.98278 10.0432 9.97456 10.044 9.96255 10.0407C9.96236 10.0406 9.96216 10.0406 9.96197 10.0405L8.5112 9.62709L8.01674 9.48618L7.88968 9.98438L7.51506 11.4532L7.515 11.4532L7.51324 11.4606C7.51072 11.4711 7.50704 11.4761 7.5028 11.4802C7.49708 11.4857 7.48682 11.4924 7.47235 11.4962C7.45782 11.4999 7.44541 11.4992 7.43759 11.4971C7.43166 11.4956 7.42697 11.4932 7.42116 11.487L7.42129 11.4868L7.41189 11.4772L6.35746 10.3991L6.00001 10.0336L5.64254 10.3991L4.58807 11.4772L4.58802 11.4772L4.5823 11.4832C4.57406 11.4919 4.56644 11.4958 4.5584 11.498C4.54884 11.5005 4.53651 11.5009 4.5238 11.4977C4.51126 11.4945 4.50304 11.4891 4.4986 11.4848C4.4956 11.4818 4.49042 11.4761 4.48671 11.4606L4.48677 11.4606L4.4849 11.4532L4.11027 9.98438L3.98321 9.48618L3.48875 9.62709L2.03801 10.0405C2.03779 10.0406 2.03758 10.0406 2.03737 10.0407C2.02541 10.0439 2.01719 10.0432 2.0098 10.041C2.00059 10.0384 1.989 10.0322 1.97822 10.0215C1.96745 10.0107 1.96128 9.99906 1.95861 9.98978C1.95646 9.98231 1.95568 9.974 1.95896 9.96193C1.95901 9.96173 1.95907 9.96153 1.95912 9.96133L2.37243 8.51008L2.5132 8.01576L2.0152 7.88866L0.546837 7.51389L0.546851 7.51384L0.539485 7.51207C0.528318 7.5094 0.52258 7.50531 0.518077 7.50072C0.512322 7.49485 0.506064 7.4851 0.502544 7.47201C0.499044 7.459 0.499583 7.44768 0.501603 7.43986C0.503151 7.43387 0.506312 7.42613 0.516989 7.41602L0.517036 7.41607L0.522971 7.41026L1.60074 6.35548L1.96587 5.99814L1.60075 5.64079L0.522974 4.58599L0.523023 4.58594L0.516984 4.58022C0.506352 4.57016 0.503184 4.56242 0.501629 4.55641C0.499602 4.54857 0.499065 4.53723 0.502562 4.52422C0.50608 4.51113 0.512329 4.5014 0.518062 4.49555C0.522541 4.49099 0.528271 4.48688 0.539485 4.4842L0.539498 4.48426L0.54686 4.48238L2.01522 4.10761L2.51322 3.98051L2.37245 3.4862L1.95898 2.03434C1.95571 2.02229 1.95648 2.01397 1.95863 2.00648C1.96131 1.99719 1.96748 1.98555 1.97826 1.97477C1.98903 1.96399 2.00061 1.95786 2.0098 1.95521C2.01718 1.95309 2.0254 1.95231 2.03741 1.95557L3.4888 2.36918L3.98325 2.51009L4.11032 2.01189L4.48494 0.543039L4.485 0.543053L4.48676 0.535683C4.48871 0.527541 4.49144 0.523571 4.49555 0.519614C4.50115 0.514231 4.51168 0.507304 4.52693 0.503288C4.54219 0.49927 4.55548 0.49994 4.56418 0.502146C4.571 0.503876 4.57625 0.506604 4.58234 0.51305L4.58231 0.513079L4.58682 0.517722L5.64125 1.60384L6 1.97337L6.35875 1.60384L7.4132 0.517698L7.41323 0.517727L7.41767 0.51303C7.42472 0.505584 7.43017 0.503102 7.43615 0.501602C7.44414 0.499599 7.4569 0.498895 7.47209 0.502984C7.48734 0.507092 7.49834 0.514245 7.50445 0.520159C7.50918 0.524738 7.51163 0.528834 7.51327 0.535673L7.51321 0.535686L7.51508 0.543015L7.8897 2.01187L8.01677 2.51007L8.51123 2.36915L9.96197 1.95572C9.96217 1.95566 9.96236 1.95561 9.96256 1.95556C9.97455 1.9523 9.98277 1.95307 9.99017 1.9552C9.99938 1.95785 10.011 1.964 10.0218 1.97478C10.0325 1.98556 10.0387 1.99718 10.0414 2.00646C10.0435 2.01393 10.0443 2.02223 10.041 2.03429C10.041 2.0345 10.0409 2.03471 10.0409 2.03492L9.62755 3.48617L9.48678 3.98048L9.98478 4.10759L11.4531 4.48235L11.4531 4.48241L11.4605 4.48417C11.4717 4.48684 11.4774 4.49094 11.4819 4.49553C11.4877 4.50139 11.4939 4.51115 11.4974 4.52424C11.5009 4.53725 11.5004 4.54856 11.4984 4.55638C11.4968 4.56237 11.4937 4.57012 11.483 4.58023L11.4829 4.58018L11.477 4.58599L10.3992 5.64079Z" fill="#1C274C" fill-opacity="0.5" stroke="#1C274C"/>
		</svg>',
	"questions" => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none">
	<path opacity="0.5" d="M3.3158 5.05264H5.63159" stroke="#1C274C" stroke-width="0.868421" stroke-linecap="round" stroke-linejoin="round"/>
	<path d="M11.9035 5.63159H10.3968C9.36374 5.63159 8.52631 6.4092 8.52631 7.36843C8.52631 8.32767 9.36374 9.10528 10.3968 9.10528H11.9035C11.9518 9.10528 11.9759 9.10528 11.9962 9.10404C12.3085 9.08503 12.5571 8.85411 12.5776 8.56419C12.5789 8.54528 12.5789 8.52288 12.5789 8.47808V6.25878C12.5789 6.21399 12.5789 6.19159 12.5776 6.17267C12.5571 5.88276 12.3085 5.65183 11.9962 5.63283C11.9759 5.63159 11.9518 5.63159 11.9035 5.63159Z" stroke="#1C274C" stroke-width="0.868421"/>
	<circle opacity="0.5" cx="10.2632" cy="7.36841" r="0.578947" fill="#1C274C"/>
	<path d="M11.9798 5.63158C11.9347 4.54762 11.7896 3.88302 11.3217 3.41513C10.6434 2.73685 9.55177 2.73685 7.36842 2.73685H5.63158C3.44823 2.73685 2.35656 2.73685 1.67828 3.41513C1 4.09341 1 5.18508 1 7.36843C1 9.55177 1 10.6434 1.67828 11.3217C2.35656 12 3.44823 12 5.63158 12H7.36842C9.55177 12 10.6434 12 11.3217 11.3217C11.7896 10.8538 11.9347 10.1892 11.9798 9.10527" stroke="#1C274C" stroke-width="0.868421"/>
	<path opacity="0.5" d="M3.3158 2.73684L5.47845 1.30287C6.08747 0.899044 6.91254 0.899044 7.52157 1.30287L9.68422 2.73684" stroke="#1C274C" stroke-width="0.868421" stroke-linecap="round"/>
	</svg>',
	"assignjobs" => '<svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="buffer" class="svg-inline--fa fa-buffer fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M427.84 380.67l-196.5 97.82a18.6 18.6 0 0 1-14.67 0L20.16 380.67c-4-2-4-5.28 0-7.29L67.22 350a18.65 18.65 0 0 1 14.69 0l134.76 67a18.51 18.51 0 0 0 14.67 0l134.76-67a18.62 18.62 0 0 1 14.68 0l47.06 23.43c4.05 1.96 4.05 5.24 0 7.24zm0-136.53l-47.06-23.43a18.62 18.62 0 0 0-14.68 0l-134.76 67.08a18.68 18.68 0 0 1-14.67 0L81.91 220.71a18.65 18.65 0 0 0-14.69 0l-47.06 23.43c-4 2-4 5.29 0 7.31l196.51 97.8a18.6 18.6 0 0 0 14.67 0l196.5-97.8c4.05-2.02 4.05-5.3 0-7.31zM20.16 130.42l196.5 90.29a20.08 20.08 0 0 0 14.67 0l196.51-90.29c4-1.86 4-4.89 0-6.74L231.33 33.4a19.88 19.88 0 0 0-14.67 0l-196.5 90.28c-4.05 1.85-4.05 4.88 0 6.74z"></path></svg>',
	"appratings" => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>',
	"ratings" => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-astronaut" class="svg-inline--fa fa-user-astronaut fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M64 224h13.5c24.7 56.5 80.9 96 146.5 96s121.8-39.5 146.5-96H384c8.8 0 16-7.2 16-16v-96c0-8.8-7.2-16-16-16h-13.5C345.8 39.5 289.6 0 224 0S102.2 39.5 77.5 96H64c-8.8 0-16 7.2-16 16v96c0 8.8 7.2 16 16 16zm40-88c0-22.1 21.5-40 48-40h144c26.5 0 48 17.9 48 40v24c0 53-43 96-96 96h-48c-53 0-96-43-96-96v-24zm72 72l12-36 36-12-36-12-12-36-12 36-36 12 36 12 12 36zm151.6 113.4C297.7 340.7 262.2 352 224 352s-73.7-11.3-103.6-30.6C52.9 328.5 0 385 0 454.4v9.6c0 26.5 21.5 48 48 48h80v-64c0-17.7 14.3-32 32-32h128c17.7 0 32 14.3 32 32v64h80c26.5 0 48-21.5 48-48v-9.6c0-69.4-52.9-125.9-120.4-133zM272 448c-8.8 0-16 7.2-16 16s7.2 16 16 16 16-7.2 16-16-7.2-16-16-16zm-96 0c-8.8 0-16 7.2-16 16v48h32v-48c0-8.8-7.2-16-16-16z"></path></svg>',
	"dashboard" => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
	<path opacity="0.5" d="M1 6.10196C1 4.95774 1 4.38564 1.2596 3.91137C1.5192 3.4371 1.99347 3.14276 2.94202 2.55406L3.94202 1.93344C4.94469 1.31115 5.44603 1 6 1C6.55397 1 7.05531 1.31114 8.05798 1.93343L9.05798 2.55406C10.0065 3.14276 10.4808 3.4371 10.7404 3.91137C11 4.38564 11 4.95774 11 6.10196V6.86248C11 8.81292 11 9.78815 10.4142 10.3941C9.82843 11 8.88562 11 7 11H5C3.11438 11 2.17157 11 1.58579 10.3941C1 9.78815 1 8.81292 1 6.86248V6.10196Z" stroke="#1C274C" stroke-width="0.75"/>
	<path d="M4.49998 8C4.92517 8.31516 5.44227 8.5 5.99998 8.5C6.5577 8.5 7.0748 8.31516 7.49998 8" stroke="#1C274C" stroke-width="0.75" stroke-linecap="round"/>
	</svg>',
	"booking" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><path d="M16 2L16 6"/><path d="M8 2L8 6"/><path d="M3 10L21 10"/></svg>',
	"product" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21" /><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /><polyline points="3.27 6.96 12 12.01 20.73 6.96" /><line x1="12" y1="22.08" x2="12" y2="12" /></svg>',
	"order" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13" /><polygon points="16 8 20 8 23 11 23 16 16 16 16 8" /><circle cx="5.5" cy="18.5" r="2.5" /><circle cx="18.5" cy="18.5" r="2.5" /></svg>',
	"starline" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>',
	"game" => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none">
	<path d="M7.53197 1.62338L7.9335 1.90754C8.24534 2.12824 8.61797 2.24675 9.00001 2.24675C9.38206 2.24675 9.75469 2.12823 10.0665 1.90753L10.468 1.62338C11.0411 1.2178 11.7259 1 12.428 1H12.9179C13.2413 1 13.5679 1.02039 13.8727 1.12847C15.7788 1.80452 17.09 4.27602 16.9952 9.8821C16.9761 11.0116 16.7118 12.26 15.6926 12.7474C15.375 12.8993 15.0027 13 14.5786 13C14.0698 13 13.6658 12.855 13.3539 12.6506C12.6228 12.1714 12.087 11.3711 11.311 10.9687C10.8438 10.7265 10.3253 10.6 9.79908 10.6H8.20092C7.67468 10.6 7.15615 10.7265 6.689 10.9687C5.91298 11.3711 5.37723 12.1714 4.64611 12.6506C4.33424 12.855 3.93018 13 3.42137 13C2.99733 13 2.62497 12.8993 2.30738 12.7474C1.28824 12.26 1.02394 11.0116 1.00483 9.8821C0.909991 4.27603 2.22116 1.80453 4.12732 1.12848C4.43207 1.02039 4.7587 1 5.08206 1H5.57203C6.27411 1 6.9589 1.2178 7.53197 1.62338Z" stroke="#1C274C" stroke-width="1.2" stroke-linecap="round"/>
	<path opacity="0.5" d="M5.4 5V7.4M4.2 6.2L6.6 6.2" stroke="#1C274C" stroke-width="1.2" stroke-linecap="round"/>
	<g opacity="0.5">
	<path d="M14.6 6.00001C14.6 6.33138 14.3314 6.60001 14 6.60001C13.6686 6.60001 13.4 6.33138 13.4 6.00001C13.4 5.66864 13.6686 5.40001 14 5.40001C14.3314 5.40001 14.6 5.66864 14.6 6.00001Z" fill="#1C274C"/>
	<path d="M12.2 6.00001C12.2 6.33138 11.9314 6.60001 11.6 6.60001C11.2686 6.60001 11 6.33138 11 6.00001C11 5.66864 11.2686 5.40001 11.6 5.40001C11.9314 5.40001 12.2 5.66864 12.2 6.00001Z" fill="#1C274C"/>
	<path d="M12.8 4.20001C13.1314 4.20001 13.4 4.46864 13.4 4.80001C13.4 5.13138 13.1314 5.40001 12.8 5.40001C12.4686 5.40001 12.2 5.13138 12.2 4.80001C12.2 4.46864 12.4686 4.20001 12.8 4.20001Z" fill="#1C274C"/>
	<path d="M12.8 6.60001C13.1314 6.60001 13.4 6.86864 13.4 7.20001C13.4 7.53138 13.1314 7.80001 12.8 7.80001C12.4686 7.80001 12.2 7.53138 12.2 7.20001C12.2 6.86864 12.4686 6.60001 12.8 6.60001Z" fill="#1C274C"/>
	</g>
	</svg>',
	"slider" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders"><line x1="4" y1="21" x2="4" y2="14" /><line x1="4" y1="10" x2="4" y2="3" /><line x1="12" y1="21" x2="12" y2="12" /><line x1="12" y1="8" x2="12" y2="3" /><line x1="20" y1="21" x2="20" y2="16" /><line x1="20" y1="12" x2="20" y2="3" /><line x1="1" y1="14" x2="7" y2="14" /><line x1="9" y1="8" x2="15" y2="8" /><line x1="17" y1="16" x2="23" y2="16" /></svg>',
	"post" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9" /><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" /></svg>',
	"city" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9" /><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" /></svg>',
	"page" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" /></svg>',
	"notification" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13" /><polygon points="22 2 15 22 11 13 2 9 22 2" /></svg>',
	"faq" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
	"user" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
	"shortlisted" => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
	<path opacity="0.5" d="M1 8.89472C1 7.90229 1 7.40608 1.30831 7.09777C1.61662 6.78946 2.11283 6.78946 3.10526 6.78946H9.42105C10.4135 6.78946 10.9097 6.78946 11.218 7.09777C11.5263 7.40608 11.5263 7.90229 11.5263 8.89472C11.5263 9.88715 11.5263 10.3834 11.218 10.6917C10.9097 11 10.4135 11 9.42105 11H3.10526C2.11283 11 1.61662 11 1.30831 10.6917C1 10.3834 1 9.88715 1 8.89472Z" stroke="#1C274C" stroke-width="0.789474"/>
	<path opacity="0.5" d="M1 3.10526C1 2.11283 1 1.61662 1.30831 1.30831C1.61662 1 2.11283 1 3.10526 1H9.42105C10.4135 1 10.9097 1 11.218 1.30831C11.5263 1.61662 11.5263 2.11283 11.5263 3.10526C11.5263 4.09769 11.5263 4.59391 11.218 4.90222C10.9097 5.21053 10.4135 5.21053 9.42105 5.21053H3.10526C2.11283 5.21053 1.61662 5.21053 1.30831 4.90222C1 4.59391 1 4.09769 1 3.10526Z" stroke="#1C274C" stroke-width="0.789474"/>
	<path d="M5.73685 3.10526H9.42106" stroke="#1C274C" stroke-width="0.789474" stroke-linecap="round"/>
	<path d="M3.10526 3.10526H4.15789" stroke="#1C274C" stroke-width="0.789474" stroke-linecap="round"/>
	<path d="M5.73685 8.89474H9.42106" stroke="#1C274C" stroke-width="0.789474" stroke-linecap="round"/>
	<path d="M3.10526 8.89474H4.15789" stroke="#1C274C" stroke-width="0.789474" stroke-linecap="round"/>
	</svg>',
	"misc" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-codesandbox"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /><polyline points="7.5 4.21 12 6.81 16.5 4.21" /><polyline points="7.5 19.79 7.5 14.6 3 12" /><polyline points="21 12 16.5 14.6 16.5 19.79" /><polyline points="3.27 6.96 12 12.01 20.73 6.96" /><line x1="12" y1="22.08" x2="12" y2="12" /></svg>',
	"pages" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
	"gamerate" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2" /><rect x="9" y="9" width="6" height="6" /><line x1="9" y1="1" x2="9" y2="4" /><line x1="15" y1="1" x2="15" y2="4" /><line x1="9" y1="20" x2="9" y2="23" /><line x1="15" y1="20" x2="15" y2="23" /><line x1="20" y1="9" x2="23" y2="9" /><line x1="20" y1="14" x2="23" y2="14" /><line x1="1" y1="9" x2="4" y2="9" /><line x1="1" y1="14" x2="4" y2="14" /></svg>',
	"log" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /><line x1="16" y1="13" x2="8" y2="13" /><line x1="16" y1="17" x2="8" y2="17" /><polyline points="10 9 9 9 8 9" /></svg>',
	"trash" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6" /><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /></svg>',
	"setting" => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
	<path opacity="0.5" d="M3.6906 2.00117C4.81766 1.33372 5.3812 1 6 1C6.6188 1 7.18233 1.33372 8.3094 2.00117L8.6906 2.22692C9.81766 2.89437 10.3812 3.22809 10.6906 3.77778C11 4.32746 11 4.99491 11 6.32981V6.7813C11 8.1162 11 8.78365 10.6906 9.33333C10.3812 9.88302 9.81766 10.2167 8.6906 10.8842L8.3094 11.1099C7.18233 11.7774 6.6188 12.1111 6 12.1111C5.3812 12.1111 4.81766 11.7774 3.6906 11.1099L3.3094 10.8842C2.18234 10.2167 1.6188 9.88302 1.3094 9.33333C1 8.78365 1 8.1162 1 6.7813V6.32981C1 4.99491 1 4.32746 1.3094 3.77778C1.6188 3.22809 2.18234 2.89437 3.3094 2.22692L3.6906 2.00117Z" stroke="#1C274C" stroke-width="0.833333"/>
	<circle cx="5.99999" cy="6.55555" r="1.66667" stroke="#1C274C" stroke-width="0.833333"/>
	</svg>',
	"dot" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
	"right" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>',
	"list" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>',
	"prediction" => '<svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 8 10" fill="none">
	<path d="M4 6.14288C3.52661 6.14288 3.14285 5.75912 3.14285 5.28573C3.14285 4.81235 3.52661 4.42859 4 4.42859C4.47338 4.42859 4.85714 4.81234 4.85714 5.28573C4.85714 5.75912 4.47338 6.14288 4 6.14288Z" stroke="#1C274C" stroke-width="0.642858"/>
	<path d="M4.85713 2.71429C4.38374 2.71429 3.99998 2.33053 3.99998 1.85714C3.99998 1.38376 4.38374 1 4.85713 1C5.33052 1 5.71427 1.38376 5.71427 1.85714C5.71427 2.33053 5.33052 2.71429 4.85713 2.71429Z" stroke="#1C274C" stroke-width="0.642858"/>
	<path d="M3.14288 9.57146C3.61627 9.57146 4.00002 9.18771 4.00002 8.71432C4.00002 8.24093 3.61627 7.85718 3.14288 7.85718C2.66949 7.85718 2.28574 8.24093 2.28574 8.71432C2.28574 9.18771 2.66949 9.57146 3.14288 9.57146Z" stroke="#1C274C" stroke-width="0.642858"/>
	<path opacity="0.5" d="M3.99998 8.71432H6.99999M6.99999 5.28575H4.85713M6.99999 1.85718H5.71427" stroke="#1C274C" stroke-width="0.642858" stroke-linecap="round"/>
	<path opacity="0.5" d="M4 1.85718L1 1.85718M3.14286 5.28575H1M1 8.71432H2.14286" stroke="#1C274C" stroke-width="0.642858" stroke-linecap="round"/>
	</svg>',
	"userrole" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2" /><rect x="2" y="14" width="20" height="8" rx="2" ry="2" /><line x1="6" y1="6" x2="6.01" y2="6" /><line x1="6" y1="18" x2="6.01" y2="18" /></svg>',
	"add" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>',
	"offer" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>',
	"seller" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>',
	"authentication" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock p-1 br-6 mb-1"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>',
	"coupon" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>',
	"traningcategory" => ' <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
	<circle opacity="0.5" cx="6" cy="6" r="5" stroke="#1C274C" stroke-width="0.75"/>
	<path d="M8 5H4" stroke="#1C274C" stroke-width="0.75" stroke-linecap="round"/>
	<path d="M8 7H4" stroke="#1C274C" stroke-width="0.75" stroke-linecap="round"/>
	</svg>',
	"firstaid" => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="comments" class="svg-inline--fa fa-comments fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M416 192c0-88.4-93.1-160-208-160S0 103.6 0 192c0 34.3 14.1 65.9 38 92-13.4 30.2-35.5 54.2-35.8 54.5-2.2 2.3-2.8 5.7-1.5 8.7S4.8 352 8 352c36.6 0 66.9-12.3 88.7-25 32.2 15.7 70.3 25 111.3 25 114.9 0 208-71.6 208-160zm122 220c23.9-26 38-57.7 38-92 0-66.9-53.5-124.2-129.3-148.1.9 6.6 1.3 13.3 1.3 20.1 0 105.9-107.7 192-240 192-10.8 0-21.3-.8-31.7-1.9C207.8 439.6 281.8 480 368 480c41 0 79.1-9.2 111.3-25 21.8 12.7 52.1 25 88.7 25 3.2 0 6.1-1.9 7.3-4.8 1.3-2.9.7-6.3-1.5-8.7-.3-.3-22.4-24.2-35.8-54.5z"></path></svg>',
	"job" => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
	<path opacity="0.5" d="M1.59999 7C1.59999 9.26274 1.59999 11.5941 2.3908 12.2971C3.18161 13 4.45441 13 6.99999 13C9.54558 13 10.8184 13 11.6092 12.2971C12.4 11.5941 12.4 9.26274 12.4 7" stroke="#1C274D" stroke-width="0.9"/>
	<path d="M8.59619 8.32111L12.3148 7.20553C12.5613 7.13158 12.6846 7.0946 12.7758 7.02126C12.8555 6.95722 12.9175 6.87387 12.956 6.77912C13 6.67063 13 6.54194 13 6.28456C13 5.27213 13 4.76591 12.8022 4.37957C12.63 4.04342 12.3565 3.76992 12.0204 3.59779C11.634 3.39996 11.1278 3.39996 10.1154 3.39996H3.88459C2.87216 3.39996 2.36595 3.39996 1.97961 3.59779C1.64345 3.76992 1.36996 4.04342 1.19783 4.37957C1 4.76591 1 5.27213 1 6.28456C1 6.54194 1 6.67063 1.04402 6.77912C1.08246 6.87387 1.14447 6.95722 1.22418 7.02126C1.31545 7.0946 1.43871 7.13158 1.68524 7.20553L5.40381 8.32111" stroke="#1C274D" stroke-width="0.9"/>
	<path d="M8.2 7.29999H5.8C5.63431 7.29999 5.5 7.4343 5.5 7.59999V8.89688C5.5 9.01955 5.57469 9.12986 5.68858 9.17542L6.10866 9.34345C6.68085 9.57233 7.31915 9.57233 7.89134 9.34345L8.31142 9.17542C8.42531 9.12986 8.5 9.01955 8.5 8.89688V7.59999C8.5 7.4343 8.36569 7.29999 8.2 7.29999Z" stroke="#1C274D" stroke-width="0.9" stroke-linecap="round"/>
	<path opacity="0.5" d="M5.30254 2.2C5.54964 1.50088 6.21638 1 7.00011 1C7.78384 1 8.45059 1.50088 8.69769 2.2" stroke="#1C274D" stroke-width="0.9" stroke-linecap="round"/>
	</svg>',
	"employees" => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
	<circle cx="6.21051" cy="2.89473" r="1.89473" stroke="#1C274C" stroke-width="0.710525"/>
	<path opacity="0.5" d="M9.05263 4.31574C9.83745 4.31574 10.4737 3.78556 10.4737 3.13154C10.4737 2.47751 9.83745 1.94733 9.05263 1.94733" stroke="#1C274C" stroke-width="0.710525" stroke-linecap="round"/>
	<path opacity="0.5" d="M3.36842 4.31574C2.5836 4.31574 1.94737 3.78556 1.94737 3.13154C1.94737 2.47751 2.5836 1.94733 3.36842 1.94733" stroke="#1C274C" stroke-width="0.710525" stroke-linecap="round"/>
	<ellipse cx="6.21052" cy="8.1053" rx="2.8421" ry="1.89473" stroke="#1C274C" stroke-width="0.710525"/>
	<path opacity="0.5" d="M9.99998 9.05256C10.8309 8.87034 11.421 8.40886 11.421 7.86835C11.421 7.32785 10.8309 6.86637 9.99998 6.68414" stroke="#1C274C" stroke-width="0.710525" stroke-linecap="round"/>
	<path opacity="0.5" d="M2.42104 9.05256C1.59008 8.87034 0.999985 8.40886 0.999985 7.86835C0.999985 7.32785 1.59008 6.86637 2.42104 6.68414" stroke="#1C274C" stroke-width="0.710525" stroke-linecap="round"/>
	</svg>',
	"age" => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="child" class="svg-inline--fa fa-child fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M120 72c0-39.765 32.235-72 72-72s72 32.235 72 72c0 39.764-32.235 72-72 72s-72-32.236-72-72zm254.627 1.373c-12.496-12.497-32.758-12.497-45.254 0L242.745 160H141.254L54.627 73.373c-12.496-12.497-32.758-12.497-45.254 0-12.497 12.497-12.497 32.758 0 45.255L104 213.254V480c0 17.673 14.327 32 32 32h16c17.673 0 32-14.327 32-32V368h16v112c0 17.673 14.327 32 32 32h16c17.673 0 32-14.327 32-32V213.254l94.627-94.627c12.497-12.497 12.497-32.757 0-45.254z"></path></svg>',
	"qualifications" => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="graduation-cap" class="svg-inline--fa fa-graduation-cap fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M622.34 153.2L343.4 67.5c-15.2-4.67-31.6-4.67-46.79 0L17.66 153.2c-23.54 7.23-23.54 38.36 0 45.59l48.63 14.94c-10.67 13.19-17.23 29.28-17.88 46.9C38.78 266.15 32 276.11 32 288c0 10.78 5.68 19.85 13.86 25.65L20.33 428.53C18.11 438.52 25.71 448 35.94 448h56.11c10.24 0 17.84-9.48 15.62-19.47L82.14 313.65C90.32 307.85 96 298.78 96 288c0-11.57-6.47-21.25-15.66-26.87.76-15.02 8.44-28.3 20.69-36.72L296.6 284.5c9.06 2.78 26.44 6.25 46.79 0l278.95-85.7c23.55-7.24 23.55-38.36 0-45.6zM352.79 315.09c-28.53 8.76-52.84 3.92-65.59 0l-145.02-44.55L128 384c0 35.35 85.96 64 192 64s192-28.65 192-64l-14.18-113.47-145.03 44.56z"></path></svg>',
	"result" => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chalkboard-teacher" class="svg-inline--fa fa-chalkboard-teacher fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M208 352c-2.39 0-4.78.35-7.06 1.09C187.98 357.3 174.35 360 160 360c-14.35 0-27.98-2.7-40.95-6.91-2.28-.74-4.66-1.09-7.05-1.09C49.94 352-.33 402.48 0 464.62.14 490.88 21.73 512 48 512h224c26.27 0 47.86-21.12 48-47.38.33-62.14-49.94-112.62-112-112.62zm-48-32c53.02 0 96-42.98 96-96s-42.98-96-96-96-96 42.98-96 96 42.98 96 96 96zM592 0H208c-26.47 0-48 22.25-48 49.59V96c23.42 0 45.1 6.78 64 17.8V64h352v288h-64v-64H384v64h-76.24c19.1 16.69 33.12 38.73 39.69 64H592c26.47 0 48-22.25 48-49.59V49.59C640 22.25 618.47 0 592 0z"></path></svg>',
	"vehicles" => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="car" class="svg-inline--fa fa-car fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M499.99 176h-59.87l-16.64-41.6C406.38 91.63 365.57 64 319.5 64h-127c-46.06 0-86.88 27.63-103.99 70.4L71.87 176H12.01C4.2 176-1.53 183.34.37 190.91l6 24C7.7 220.25 12.5 224 18.01 224h20.07C24.65 235.73 16 252.78 16 272v48c0 16.12 6.16 30.67 16 41.93V416c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32v-32h256v32c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32v-54.07c9.84-11.25 16-25.8 16-41.93v-48c0-19.22-8.65-36.27-22.07-48H494c5.51 0 10.31-3.75 11.64-9.09l6-24c1.89-7.57-3.84-14.91-11.65-14.91zm-352.06-17.83c7.29-18.22 24.94-30.17 44.57-30.17h127c19.63 0 37.28 11.95 44.57 30.17L384 208H128l19.93-49.83zM96 319.8c-19.2 0-32-12.76-32-31.9S76.8 256 96 256s48 28.71 48 47.85-28.8 15.95-48 15.95zm320 0c-19.2 0-48 3.19-48-15.95S396.8 256 416 256s32 12.76 32 31.9-12.8 31.9-32 31.9z"></path></svg>',
	"banner" => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="mobile" class="svg-inline--fa fa-mobile fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M272 0H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h224c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zM160 480c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32z"></path></svg>',
	"trainings" => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="school" class="svg-inline--fa fa-school fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M0 224v272c0 8.84 7.16 16 16 16h80V192H32c-17.67 0-32 14.33-32 32zm360-48h-24v-40c0-4.42-3.58-8-8-8h-16c-4.42 0-8 3.58-8 8v64c0 4.42 3.58 8 8 8h48c4.42 0 8-3.58 8-8v-16c0-4.42-3.58-8-8-8zm137.75-63.96l-160-106.67a32.02 32.02 0 0 0-35.5 0l-160 106.67A32.002 32.002 0 0 0 128 138.66V512h128V368c0-8.84 7.16-16 16-16h96c8.84 0 16 7.16 16 16v144h128V138.67c0-10.7-5.35-20.7-14.25-26.63zM320 256c-44.18 0-80-35.82-80-80s35.82-80 80-80 80 35.82 80 80-35.82 80-80 80zm288-64h-64v320h80c8.84 0 16-7.16 16-16V224c0-17.67-14.33-32-32-32z"></path></svg>',
	"number" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /><line x1="16" y1="13" x2="8" y2="13" /><line x1="16" y1="17" x2="8" y2="17" /><polyline points="10 9 9 9 8 9" /></svg>',
	"galidisawar" => '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
	<path fill-rule="evenodd" clip-rule="evenodd" d="M4.6875 3.45665V1.78589H5.3125V3.45645C5.51512 3.49738 5.70302 3.57762 5.86935 3.68831L7.05222 2.50544L7.49435 2.94758L6.31149 4.13044C6.42177 4.29657 6.50262 4.48528 6.54335 4.6873H8.21411V5.3123H6.54335C6.50242 5.51431 6.42157 5.70161 6.31149 5.86754L7.49435 7.05081L7.05222 7.49294L5.86935 6.30968C5.70302 6.42036 5.51512 6.50161 5.3125 6.54254V8.21391H4.6875V6.54254C4.48833 6.50228 4.29888 6.42375 4.12964 6.31129L2.94778 7.49314L2.50565 7.05101L3.68851 5.86774C3.57843 5.70181 3.49798 5.51452 3.45726 5.3125H1.78589V4.6875H3.45726C3.49798 4.48528 3.57823 4.29657 3.68851 4.13065L2.50565 2.94778L2.94778 2.50565L4.12964 3.68689C4.29597 3.57641 4.48508 3.49758 4.6875 3.45665Z" fill="#1C274C" fill-opacity="0.5"/>
	<path d="M4.44052 0.774395C3.68165 0.873992 2.98569 1.17359 2.40665 1.61815L2.75504 1.96815H2.75665C3.24194 1.60847 3.81613 1.3621 4.44052 1.26915V0.774395Z" fill="#1C274C"/>
	<path d="M5.55685 0.772984V1.26935C6.16723 1.35929 6.74597 1.59849 7.24173 1.96573L7.59234 1.61573C7.0127 1.17097 6.31613 0.871976 5.55685 0.772984Z" fill="#1C274C"/>
	<path d="M8.38185 2.40524L8.03185 2.75524C8.40004 3.2515 8.64013 3.83091 8.73085 4.44214H9.22722C9.12742 3.68226 8.82742 2.98468 8.38185 2.40524Z" fill="#1C274C"/>
	<path d="M8.73065 5.55786C8.6377 6.18266 8.39193 6.75746 8.03165 7.24335L8.38165 7.59335C8.82681 7.01391 9.12722 6.31734 9.22702 5.55786H8.73065Z" fill="#1C274C"/>
	<path d="M7.24173 8.03286C6.75605 8.39254 6.18165 8.63931 5.55685 8.73185V9.22722C6.31633 9.12802 7.0127 8.82823 7.59234 8.38347L7.24335 8.03286H7.24173Z" fill="#1C274C"/>
	<path d="M2.75524 8.03185L2.40524 8.38185C2.98448 8.82722 3.68145 9.12742 4.44073 9.22722V8.73044C3.81593 8.6371 3.24052 8.39194 2.75524 8.03185Z" fill="#1C274C"/>
	<path d="M0.772984 5.55786C0.872177 6.31673 1.17117 7.0131 1.61573 7.59214L1.96573 7.24153C1.60665 6.75625 1.3625 6.18165 1.26996 5.55766L0.772984 5.55786Z" fill="#1C274C"/>
	<path d="M1.61673 2.40786C1.17198 2.9869 0.872581 3.68327 0.772984 4.44234H1.26996C1.3627 3.81814 1.60786 3.24375 1.96734 2.75847L1.61673 2.40786Z" fill="#1C274C"/>
	<path fill-rule="evenodd" clip-rule="evenodd" d="M5 10C2.24294 10 0 7.75706 0 5C0 2.24294 2.24294 0 5 0C7.75706 0 10 2.24294 10 5C10 7.75706 7.75706 10 5 10ZM0.333266 5C0.333266 2.42681 2.42681 0.333266 5 0.333266C7.57319 0.333266 9.66673 2.42681 9.66673 5C9.66673 7.57319 7.57319 9.66673 5 9.66673C2.42681 9.66673 0.333266 7.57319 0.333266 5Z" fill="#1C274C"/>
	</svg>'
];

/** Settings Allowed Keys */


const SETTINGS = [
	'brand' => [
		'admin_logo',
		'web_logo',
		'project_name',
		'auto_active',
		'whatsapp_no',
		'mobile_no_1',
		'telegram_channel_link',
		'email_1',
		'banner_marquee',
		'banner_img_1',
		'banner_img_2',
		'banner_img_3'

		/**
		'web_favicon',
		'admin_favicon',
	 */


	],


];

const PANNA = array("000", "100", "110", "111", "112", "113", "114", "115", "116", "117", "118", "119", "120", "122", "123", "124", "125", "126", "127", "128", "129", "130", "133", "134", "135", "136", "137", "138", "139", "140", "144", "145", "146", "147", "148", "149", "150", "155", "156", "157", "158", "159", "160", "166", "167", "168", "169", "170", "177", "178", "179", "180", "188", "189", "190", "199", "200", "220", "222", "223", "224", "225", "226", "227", "228", "229", "230", "233", "234", "235", "236", "237", "238", "239", "240", "244", "245", "246", "247", "248", "249", "250", "255", "256", "257", "258", "259", "260", "266", "267", "268", "269", "270", "277", "278", "279", "280", "288", "289", "290", "299", "300", "330", "333", "334", "335", "336", "337", "338", "339", "340", "344", "345", "346", "347", "348", "349", "350", "355", "356", "357", "358", "359", "360", "366", "367", "368", "369", "370", "377", "378", "379", "380", "388", "389", "390", "399", "400", "440", "444", "445", "446", "447", "448", "449", "450", "455", "456", "457", "458", "459", "460", "466", "467", "468", "469", "470", "477", "478", "479", "480", "488", "489", "490", "499", "500", "550", "555", "556", "557", "558", "559", "560", "566", "567", "568", "569", "570", "577", "578", "579", "580", "588", "589", "590", "599", "600", "660", "666", "667", "668", "669", "670", "677", "678", "679", "680", "688", "689", "690", "699", "700", "770", "777", "778", "779", "780", "788", "789", "790", "799", "800", "880", "888", "889", "890", "899", "900", "990", "999");
const DIGIT = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
const STR_PANNA = array(000, 100, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 122, 123, 124, 125, 126, 127, 128, 129, 130, 133, 134, 135, 136, 137, 138, 139, 140, 144, 145, 146, 147, 148, 149, 150, 155, 156, 157, 158, 159, 160, 166, 167, 168, 169, 170, 177, 178, 179, 180, 188, 189, 190, 199, 200, 220, 222, 223, 224, 225, 226, 227, 228, 229, 230, 233, 234, 235, 236, 237, 238, 239, 240, 244, 245, 246, 247, 248, 249, 250, 255, 256, 257, 258, 259, 260, 266, 267, 268, 269, 270, 277, 278, 279, 280, 288, 289, 290, 299, 300, 330, 333, 334, 335, 336, 337, 338, 339, 340, 344, 345, 346, 347, 348, 349, 350, 355, 356, 357, 358, 359, 360, 366, 367, 368, 369, 370, 377, 378, 379, 380, 388, 389, 390, 399, 400, 440, 444, 445, 446, 447, 448, 449, 450, 455, 456, 457, 458, 459, 460, 466, 467, 468, 469, 470, 477, 478, 479, 480, 488, 489, 490, 499, 500, 550, 555, 556, 557, 558, 559, 560, 566, 567, 568, 569, 570, 577, 578, 579, 580, 588, 589, 590, 599, 600, 660, 666, 667, 668, 669, 670, 677, 678, 679, 680, 688, 689, 690, 699, 700, 770, 777, 778, 779, 780, 788, 789, 790, 799, 800, 880, 888, 889, 890, 899, 900, 990, 999);
const SINGLE_PANNA = array(120, 123, 124, 125, 126, 127, 128, 129, 130, 134, 135, 136, 137, 138, 139, 140, 145, 146, 147, 148, 149, 150, 156, 157, 158, 159, 160, 167, 168, 169, 170, 178, 179, 180, 189, 190, 230, 234, 235, 236, 237, 238, 239, 240, 245, 246, 247, 248, 249, 250, 256, 257, 258, 259, 260, 267, 268, 269, 270, 278, 279, 280, 289, 290, 340, 345, 346, 347, 348, 349, 350, 356, 357, 358, 359, 360, 367, 368, 369, 370, 378, 379, 380, 389, 390, 450, 456, 457, 458, 459, 460, 467, 468, 469, 470, 478, 479, 480, 489, 490, 560, 567, 568, 569, 570, 578, 579, 580, 589, 590, 670, 678, 679, 680, 689, 690, 780, 789, 790, 890);
const Double_PANNA = array(100, 110, 112, 113, 114, 115, 116, 117, 118, 119, 122, 133, 144, 155, 166, 177, 188, 199, 200, 220, 223, 224, 225, 226, 227, 228, 229, 233, 244, 255, 266, 277, 288, 299, 300, 330, 334, 335, 336, 337, 338, 339, 344, 355, 366, 377, 388, 399, 400, 440, 445, 446, 447, 448, 449, 455, 466, 477, 488, 499, 500, 550, 556, 557, 558, 559, 566, 577, 588, 599, 600, 660, 667, 668, 669, 677, 688, 699, 700, 770, 778, 779, 788, 799, 800, 880, 889, 899, 900, 990);
const Triple_PANNA = array("000", "111", "222", "333", "444", "555", "666", "777", "888", "999");
const RED_DIGIT = array('00', '05', '11', '16', '22', '27', '33', '38', '44', '49', '50', '55', '61', '66', '72', '77', '83', '88', '94', '99');
const JODI_DIGIT = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79', '80', '81', '82', '83', '84', '85', '86', '87', '88', '89', '90', '91', '92', '93', '94', '95', '96', '97', '98', '99');
//define('SINGLE_PANNA', range(100,999));
//define('Double_PANNA', range(100,999));
const RUPEE = '&#8377 ';
const UNIT = '$';
const FCM_SERVER_KEY = 'AAAASSNttSQ:APA91bHvSEgGCYDTAJiQTiBCD0O9haqYK5BmHAHalmw-nSf9BzWmdG9DJ5GJlhPwRDbba_kf-579k6H86Gg6kQR5u2Blh0b5p4ZP4GET0NYCgbC-89r6nGlKWzkRjVnXtrb3hR42qH93';

// ═══════════════════════════════════════════════════════════════════
// ONESIGNAL PUSH NOTIFICATION CONFIG
// ───────────────────────────────────────────────────────────────────
// 📌 ONESIGNAL_APP_ID
//    Where to find: OneSignal Dashboard → Your App → Settings → Keys & IDs
//    Must match the App ID initialized in Android app (ApplicationClass.java)
//    Current App: Deep's Org App
const ONESIGNAL_APP_ID = '32163764-747f-40f1-b39c-48f138f76e2f';

// 📌 ONESIGNAL_REST_API_KEY
//    Where to find: OneSignal Dashboard → Settings → Keys & IDs → REST API Key
//    ⚠️  Keep this secret — anyone with this key can send notifications to all users
//    ⚠️  Never commit this to GitHub or share publicly
const ONESIGNAL_REST_API_KEY = 'os_v2_app_gildozdup5apdm44jdytr53of4rmg4fd4hle6gu6umu4cahiqo4fmyo4c3tz6kkq5pju3no54i7sdbny6wr3aljq5b6dyqdc47dkkeq';

// 📌 ONESIGNAL_API_URL
//    The OneSignal REST API endpoint for sending push notifications
//    This should not need changing unless OneSignal changes their API
const ONESIGNAL_API_URL = 'https://api.onesignal.com/notifications';
// ═══════════════════════════════════════════════════════════════════

const Main_Chart = SITE_URL . "pages/game_chart/";
const Starline_Chart = SITE_URL . "starline_game_rate";
const GaliDesawar_Chart = SITE_URL . "gali_disawar_game_rate";
/* End of file Site_constants.php */
