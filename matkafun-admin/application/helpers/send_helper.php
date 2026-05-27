<?php

/** Send Mail
 *
 * @param string $mailTo
 * @param string $subject
 * @param string $msg
 * @return void */
function sendMail($mailTo, $subject, $msg, $file = null)
{
	$ci = &get_instance();
	$ci->load->library('email', [
		'protocol'  => 'SMTP',
		'smtp_host' => "mail.madhurmilan.online",
		'smtp_user' => "madhumilan@madhurmilan.online",
		'smtp_pass' => "Vinayak@2001",
		'smtp_port' => 143,
		'wordwrap'  => TRUE
	]);
	$ci->email->from('madhumilan@madhurmilan.online');

	$ci->email->to($mailTo);
	$ci->email->subject($subject);
	$ci->email->message($msg);
	isset($file) and !is_null($file) and $ci->email->attach($file);
	return $ci->email->send();
}


/** Send Message
 *
 * @param string $msg
 * @param int $mobile
 * @return string */
function shootMsg($msg, $mobile)
{
	$sender_id = 'PRPLIV';
	$key = "55E202E726F8EA";
	$routeid = "7";
	$campaign = "9417";
	$end_point_url = "http://byebyesms.com/app/smsapi/index.php";
	$url = "key=" . $key . "&campaign=" . $campaign . "&routeid=" . $routeid . "&type=text&contacts=" . $mobile . "&senderid=" . $sender_id . "&msg=" . $msg;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $end_point_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}

/**
 * Send a push notification to ALL users via OneSignal.
 * Uses the same ONESIGNAL_APP_ID as registered in ApplicationClass.java.
 *
 * @param string $title   Notification heading
 * @param string $message Notification body text
 * @param string $type    Classification type (e.g., 'CRON', 'MANUAL')
 * @return string OneSignal API raw response
 */
function sendResultNotificationOneSignal($title, $message, $type = 'GENERAL')
{
    // ✅ All credentials are centrally managed in Site_constants.php
    $app_id  = ONESIGNAL_APP_ID;
    $api_key = ONESIGNAL_REST_API_KEY;

    $fields = [
        'app_id'             => $app_id,
        'included_segments'  => ['All'],   // sends to every subscribed user
        'headings'           => ['en' => $title],
        'contents'           => ['en' => $message],
        // 'large_icon'      => SITE_URL . 'assets/img/logo.png', // Uncomment & set correct URL to show an image
        'data'               => ['notification_type' => $type]
    ];

    $ch = curl_init(ONESIGNAL_API_URL);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . $api_key,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

 function sendNotification($token, $fields)
    {


        $FCM_SERVER_KEY = FCM_SERVER_KEY;
        // $msg = array(
        //                  'message'   => 'You have new request',
        //                  'title'     => 'You have new request',
        //                  'subtitle'  => 'This is subtitle',
        //                  'body'      => ucfirst($con['username']) . " has booked a new ride, Don't keep them waiting.",
        //                  'ride_id'   => $ride,
        //                 // 'vibrate'   => 1,
        //                 // 'sound'     => 1,
        //                 // 'largeIcon' => 'large_icon',
        //);


        // $fields = [
        //   'to'            => $token,
        //    'notification'   => $msg

        //        ];

        $array = json_encode($fields);
        //      _ddd($array);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:key=' . $FCM_SERVER_KEY
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array);

        $result = curl_exec($ch);

        if ($result === FALSE) {
            return false;
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
    
function push_notification_android($fields)
{
	$url = 'https://fcm.googleapis.com/fcm/send';

	//$device_id = 'dBfQ__P5Tfer_Q2AkEmQ92:APA91bEfxERYWpy6W3WXPId3NzFTAYbaotJZYz_Fi8mX_eBkNEZtPRq87pkIqMI3mcJXJFEPOizTmSUJDN6NptMXfeh6VyBlXVtHLFuIzCIaGkyE_uQg8-kVAx_aRIa5AeFGZw_oRY7V';
	$api_key = 'AAAASSNttSQ:APA91bHvSEgGCYDTAJiQTiBCD0O9haqYK5BmHAHalmw-nSf9BzWmdG9DJ5GJlhPwRDbba_kf-579k6H86Gg6kQR5u2Blh0b5p4ZP4GET0NYCgbC-89r6nGlKWzkRjVnXtrb3hR42qH93';
	//AIzaSyCHycfIsT7sREBnmgo2yrsrHCFakzaYPYk';
	//AIzaSyBjAQluYxdwvqDmqX3rjoeed7e5WaEZJ30--
	//API URL of FCM

	/*api_key available in:
	Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
	//$api_key = 'AAAAKZLje1I:APbGQDw8FD...TjmtuINVB-g';

	/*$fields = array ('registration_ids' => array ($device_id),
	    'data' => array ("message" => $message)
	);*/

	/*$msg = array(
	    'message'   => 'here is a message. message',
	    'title'     => 'This is a title. title',
	    'subtitle'  => 'This is a subtitle. subtitle',
	    'tickerText'    => 'Ticker text here...Ticker text here...Ticker text here',
	    'vibrate'   => 1,
	    'sound'     => 1,
	    'largeIcon' => 'large_icon',
	    'smallIcon' => 'small_icon'
	);*/

	/*$fields = [
	    'to'  => "$device_id",
	    'data' => $message,
		"priority"=> 'high'
	];*/

	//header includes Content type and api key
	$headers = array(
		'Authorization:key=' . $api_key,
		'Content-Type: application/json'
	);

	// Open connection
	$ch = curl_init();

	// Set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// Disabling SSL Certificate support temporarly
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

	// Execute post
	$result = curl_exec($ch);
	if ($result === FALSE) {
		die('Curl failed: ' . curl_error($ch));
	}

	// Close connection
	curl_close($ch);

	return $result;
	// print_r(json_decode($result, true));
}
