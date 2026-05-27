<?php
// ------------------------------------------------------------------------
//					SEARCH_IN FUNCTION
// ------------------------------------------------------------------------
if (!function_exists('search_in')) {
	/** Search Array Value in String
	 *
	 * @author	Krisha Gujjjar <krishnagujjjar@gmail.com>
	 * @since	v0.0.1
	 * @version	v1.0.0	Thursday, April 30th, 2020.
	 * @param	mixed	$haystack "Variable to search in"	Default: null
	 * @param	mixed	$search  	Default: null
	 * @return	bool */
	function search_in($haystack = null, $search = null)
	{
		if (is($haystack) and is($search, 'array')) {
			foreach ($search as $niddle) {
				if (strpos($haystack, $niddle) !== false)
					return true;
			}
		} else {
			if (strpos($haystack, $search) !== false)
				return true;
		}
		return false;
	}
}

function getYoutubeEmbedUrl($url)
{

	$urlParts   = explode('/', $url);
	$vidid      = explode('&', str_replace('watch?v=', '', end($urlParts)));

	return 'https://www.youtube.com/embed/' . $vidid[0];
}

// ------------------------------------------------------------------------
//					SHOW_DEBUG FUNCTION
// ------------------------------------------------------------------------
if (!function_exists('show_debug')) {
	/** Show Console Log Message
	 * with Others Details
	 *
	 * @param mixed $data All Data type Variable
	 * @return string */
	function show_debug($data = null)
	{
		$msg = '';
		$ci = &get_instance();
		if (is_login()) {
			if (is($data, 'array') or (is($data) and is_object($data))) {
				$data = json_encode($data);
				$msg = '<script>
					console.log("%cController is %c' . ucwords($ci->router->fetch_class()) . '", "font-size: 18px; font-weight: bold;color: #3A4161", "color: #ff0062; font-size: 18px; font-weight: bold");
					console.log("%cMethod is %c' . ucwords($ci->router->fetch_method()) . '", "font-size: 18px; font-weight: bold;color: #3A4161", "color: #ff6837; font-size: 18px; font-weight: bold");
					console.table(' . $data . ');
				</script>';
			} elseif (is($data) and (is_string($data) or is_numeric($data) or is_float($data) or is_bool($data))) {
				$msg = '<script>
						console.log("%cController is %c' . ucwords($ci->router->fetch_class()) . '", "font-size: 18px; font-weight: bold;color: #3A4161", "color: #ff0062; font-size: 18px; font-weight: bold");
						console.log("%cMethod is %c' . ucwords($ci->router->fetch_method()) . '", "font-size: 18px; font-weight: bold;color: #3A4161", "color: #ff6837; font-size: 18px; font-weight: bold");
						console.log("%cYour Result: %c' . $data . '","font-size: 18px; font-weight: bold;color: #3A4161", "font-size: 18px; font-weight: bold;color: #625fff");
					</script>';
			}
		}
		return print($msg);
	}
}



// -----------------------------------------------------------
// 					PRICE_FORMAT FUNCTION
// -----------------------------------------------------------
if (!function_exists('price_format')) {
	/** Format Numaric String to Indian Currency Format
	 * @param mixed $price
	 * @return string|0 */
	function price_format($price)
	{
		return convertCurrency($price);
		$format = new NumberFormatter('en', NumberFormatter::CURRENCY);
		if (is($price) and is_string($price) or is_int($price) or is_float($price))
			return $format->formatCurrency($price, 'INR');
		return 0;
	};
}



// -----------------------------------------------------------
// 					_DATE_FORMAT FUNCTION
// -----------------------------------------------------------
if (!function_exists('_date_format')) {
	/** Format Numaric String to Indian Currency Format
	 * @param mixed $date
	 * @return string|0 */
	function _date_format($date)
	{
		if (is($date) and is_string($date))
			return date('M d, Y', strtotime($date));
		return 0;
	};
}


// -----------------------------------------------------------
// 					_TIME_FORMAT FUNCTION
// -----------------------------------------------------------
if (!function_exists('_time_format')) {
	/** Format Numaric String to Indian Currency Format
	 * @param mixed $time
	 * @return string|0 */
	function _time_format($time)
	{
		if (is($time) and is_string($time))
			return date('h: i A', strtotime($time));
		return 0;
	};
}


// -----------------------------------------------------------
// 					_DATETIME_FORMAT FUNCTION
// -----------------------------------------------------------
if (!function_exists('_datetime_format')) {
	/** Format Numaric String to Indian Currency Format
	 * @param mixed $date
	 * @return string|0 */
	function _datetime_format($date)
	{
		if (is($date) and is_string($date))
			return date('M d, Y', strtotime($date)) . ' At <br>' . date('h: i A', strtotime($date));
		return 0;
	};
}

function show_rating($rate)
{
	for ($x = 1; $x <= $rate; $x++) {
		echo '<i class="fa fa-star fa-sm orange-color" aria-hidden="true"></i>';
	}
	if (strpos($rate, '.')) {
		echo '<i class="fa fa-star-half-o fa-sm orange-color " aria-hidden="true"></i>';
		$x++;
	}
	while ($x <= 5) {
		echo '<i class="fa fa-star-o fa-sm orange-color " aria-hidden="true"></i>';
		$x++;
	}
}


function get_status($status = null)
{
	$statuses = [
		11 => ['title' => 'new', 'class' => 'info'],
		1 => ['title' => 'Active', 'class' => 'success'],
		2 => ['title' => 'Inactive', 'class' => 'danger'],
		3 => ['title' => 'delete', 'class' => 'danger'],
		11 => ['title' => 'contacted', 'class' => 'info'],
		12 => ['title' => 'interested', 'class' => 'success'],
		13 => ['title' => 'proposal sent', 'class' => 'secondary'],
		14 => ['title' => 'not interested', 'class' => 'danger'],
		15 => ['title' => 'not convanced', 'class' => 'warning'],
		16 => ['title' => 'contact us', 'class' => 'info'],
	];

	$data = new stdClass;

	is($status) and array_key_exists($status, $statuses) and
		$data->title = ucwords($statuses[$status]['title']) or show_debug('Status of ' . $status . ', title not Define');

	is($status) and array_key_exists($status, $statuses) and
		$data->class = strtolower($statuses[$status]['class']) or show_debug('Status of ' . $status . ', Class not Define');

	return $data;
}

function get_working_status($status = null)
{
	$statuses = [
		11 => ['title' => 'new', 'class' => 'info'],
		1 => ['title' => 'Working', 'class' => 'success'],
		2 => ['title' => 'Not Working', 'class' => 'danger'],
		3 => ['title' => 'delete', 'class' => 'danger'],
		12 => ['title' => 'interested', 'class' => 'success'],
		13 => ['title' => 'proposal sent', 'class' => 'secondary'],
		14 => ['title' => 'not interested', 'class' => 'danger'],
		15 => ['title' => 'not convanced', 'class' => 'warning'],
		16 => ['title' => 'contact us', 'class' => 'info'],
	];

	$data = new stdClass;

	is($status) and array_key_exists($status, $statuses) and
		$data->title = ucwords($statuses[$status]['title']) or show_debug('Status of ' . $status . ', title not Define');

	is($status) and array_key_exists($status, $statuses) and
		$data->class = strtolower($statuses[$status]['class']) or show_debug('Status of ' . $status . ', Class not Define');

	return $data;
}

function get_shortlist_status($status = null)
{
	$statuses = [
		11 => ['title' => 'new', 'class' => 'info'],
		1 => ['title' => 'Shortlisted', 'class' => 'secondary'],
		2 => ['title' => 'Unshortlisted', 'class' => 'danger'],
		3 => ['title' => 'delete', 'class' => 'danger'],
		12 => ['title' => 'interested', 'class' => 'success'],
		13 => ['title' => 'proposal sent', 'class' => 'secondary'],
		14 => ['title' => 'not interested', 'class' => 'danger'],
		15 => ['title' => 'not convanced', 'class' => 'warning'],
		16 => ['title' => 'contact us', 'class' => 'info'],
	];

	$data = new stdClass;

	is($status) and array_key_exists($status, $statuses) and
		$data->title = ucwords($statuses[$status]['title']) or show_debug('Status of ' . $status . ', title not Define');

	is($status) and array_key_exists($status, $statuses) and
		$data->class = strtolower($statuses[$status]['class']) or show_debug('Status of ' . $status . ', Class not Define');

	return $data;
}

function get_complete_job($status = null)
{
	$statuses = [
		11 => ['title' => 'new', 'class' => 'info'],
		1 => ['title' => 'Completed', 'class' => 'info'],
		2 => ['title' => 'Not Done', 'class' => 'warning'],
		3 => ['title' => 'delete', 'class' => 'danger'],
		11 => ['title' => 'contacted', 'class' => 'info'],
		12 => ['title' => 'interested', 'class' => 'success'],
		13 => ['title' => 'proposal sent', 'class' => 'secondary'],
		14 => ['title' => 'not interested', 'class' => 'danger'],
		15 => ['title' => 'not convanced', 'class' => 'warning'],
		16 => ['title' => 'contact us', 'class' => 'info'],
	];

	$data = new stdClass;

	is($status) and array_key_exists($status, $statuses) and
		$data->title = ucwords($statuses[$status]['title']) or show_debug('Status of ' . $status . ', title not Define');

	is($status) and array_key_exists($status, $statuses) and
		$data->class = strtolower($statuses[$status]['class']) or show_debug('Status of ' . $status . ', Class not Define');

	return $data;
}

function get_delivery_status($status = null)
{
	if ($status == '0') {
		$status = '11';
	}
	$statuses = [
		'11' => ['title' => 'new', 'class' => 'info'],
		'1' => ['title' => 'accept', 'class' => 'success'],
		'2' => ['title' => 'in_processing', 'class' => 'dark'],
		'3' => ['title' => 'delivered', 'class' => 'danger'],
		'4' => ['title' => 'complete', 'class' => 'info'],
		'5' => ['title' => 'cancel ', 'class' => 'success'],
		'6' => ['title' => 'return_req', 'class' => 'info'],
		'7' => ['title' => 'refunded', 'class' => 'success'],

	];

	$data = new stdClass;

	is($status) and array_key_exists($status, $statuses) and
		$data->title = ucwords($statuses[$status]['title']) or show_debug('Status of ' . $status . ', title not Define');

	is($status) and array_key_exists($status, $statuses) and
		$data->class = strtolower($statuses[$status]['class']) or show_debug('Status of ' . $status . ', Class not Define');

	return $data;
}



function get_payment_status($status = null)
{
	if ($status == '0') {
		$status = '11';
	}
	$status1 = [
		'11' => ['title' => 'Unpaid', 'class' => 'info'],
		'1' => ['title' => 'Paid', 'class' => 'success'],
		'2' => ['title' => 'Return', 'class' => 'dark'],

	];

	$data = new stdClass;

	is($status) and array_key_exists($status, $status1) and
		$data->title = ucwords($status1[$status]['title']) or show_debug('Status of ' . $status . ', title not Define');

	is($status) and array_key_exists($status, $status1) and
		$data->class = strtolower($status1[$status]['class']) or show_debug('Status of ' . $status . ', Class not Define');

	return $data;
}

function convertCurrency($number)
{
	// Convert Price to Crores or Lakhs or Thousands
	$length = strlen($number);
	$currency = '';

	if ($length == 4 || $length == 5) {
		// Thousand
		$number = $number / 1000;
		$number = round($number, 2);
		$ext = "Thousand";
		$ext = " k";
	} elseif ($length == 6 || $length == 7) {
		// Lakhs
		$number = $number / 100000;
		$number = round($number, 2);
		$ext = " Lac";
	} elseif ($length == 8 || $length == 9) {
		// Crores
		$number = $number / 10000000;
		$number = round($number, 2);
		$ext = " Cr";
	} else {
		$ext = ' INR';
	}
	$currency = RUPEE . $number . $ext;

	return $currency;
}


// ------------------------------------------------------------------------
//						GET_METHOD FUNCTION
// ------------------------------------------------------------------------
if (!function_exists('get_method')) {
	/** Get Current Method Name
	 *
	 * @return string */
	function get_method()
	{
		/** @var object */
		$ci = &get_instance();
		return $ci->router->fetch_method();
	}
}


// ------------------------------------------------------------------------
//						OBJECT FUNCTION
// ------------------------------------------------------------------------
if (!function_exists('object')) {
	/** Create Array to Object
	 *
	 * @return object */
	function object(array $array = [])
	{
		return json_decode(json_encode($array));
	}
}


    

function displaywords($number)
{
	$words = array(
		'0' => '', '1' => 'one', '2' => 'two',
		'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
		'7' => 'seven', '8' => 'eight', '9' => 'nine',
		'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
		'13' => 'thirteen', '14' => 'fourteen',
		'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
		'18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
		'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
		'60' => 'sixty', '70' => 'seventy',
		'80' => 'eighty', '90' => 'ninety'
	);
	$digits = array('', '', 'hundred', 'thousand', 'lakh', 'crore');
	$number = explode(".", $number);
	$result = array("", "");
	$j = 0;
	foreach ($number as $val) {
		// loop each part of number, right and left of dot
		for ($i = 0; $i < strlen($val); $i++) {
			// look at each part of the number separately  [1] [5] [4] [2]  and  [5] [8]
			$numberpart = str_pad($val[$i], strlen($val) - $i, "0", STR_PAD_RIGHT); // make 1 => 1000, 5 => 500, 4 => 40 etc.
			if ($numberpart <= 20) { // if it's below 20 the number should be one word
				$numberpart = 1 * substr($val, $i, 2); // use two digits as the word
				$i++; // increment i since we used two digits
				$result[$j] .= $words[$numberpart] . " ";
			} else {
				//echo $numberpart . "<br>\n"; //debug
				if ($numberpart > 90) {  // more than 90 and it needs a $digit.
					$result[$j] .= $words[$val[$i]] . " " . $digits[strlen($numberpart) - 1] . " ";
				} else if ($numberpart != 0) { // don't print zero
					$result[$j] .= $words[str_pad($val[$i], strlen($val) - $i, "0", STR_PAD_RIGHT)] . " ";
				}
			}
		}
		$j++;
	}
	if (trim($result[0]) != "") return $result[0] . "Rupees ";
	if ($result[1] != "") return $result[1] . "Paise";
}

// get random string with 16 numbers
function generateRandomString($length = 16)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
// get random string with 7 numbers
function generateRandom_String($length = 7)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}


function _dd($data)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

function decodeBase64Image($img, $path)
    {

        $destinationPath = FCPATH . 'uploads/' . $path;
        $image_type = 'png';
        $image_base64 = base64_decode($img);
        $fileName = uniqid() . '.' . $image_type;
        $file = $destinationPath . $fileName;

        file_put_contents($file, $image_base64);

        return $fileName;
    }

function _ddd($data)
{
	$ci = get_instance();
	echo $ci->db->last_query();
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	die;
}
/* End of file extra.php */