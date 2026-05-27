<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
/** Load Category Pages & Queries */
class Notification extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here

        flash_message(
            'dashboard/login',
            is_login(),
            'unsuccess',
            'Please Login Then Try Again'
        );

        $this->load->helper('send');

        $this->load->model([
            'UsersModel',
            'NotificationModel'
        ]);
    }

    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }
    
    public function sendNotification($token, $fields)
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

    /** Add single user Notification */
    public function add_single_notification()
    {


        if ($this->input->post('addNotificationsingle')) {

           
            if($_POST['user_id']=="All") {
                $title = ucfirst($this->input->post('title'));
                $mes   = ucfirst($this->input->post('message'));

                // ✅ FIX: OneSignal broadcast replaces deprecated per-user FCM loop
                sendResultNotificationOneSignal($title, $mes, 'MANUAL_BROADCAST');

                $Notification = $this->NotificationModel->save([
                    'message' => $mes,
                    'heading' => "[ADMIN] " . $title,
                    'user_id' => 'all',
                    'status'  => true,
                    'created_date' => date('Y-m-d H:i:s')
                ]);

            }else{
                
                 $user = $this->UsersModel->first([
                    'conditions' => [
                        'id' => $_POST['user_id'],
                    ]
                ]);
    
                $mes= ucfirst($this->input->post('message'));
                $title = ucfirst($this->input->post('title'));
    
                $token = $user['token_id'];
    
                
                $message = array(
                'title' => 'Garena Matka',
                'message' => $title,
                'body' => $mes,
                'image' => SITE_URL . 'assets/img/logo.png',
                'imageUrl' => SITE_URL . 'assets/img/logo.png',
                );
    
    
                $noti = array(
                    'body'   => $mes,
                    'title' =>$title
    
                );
    
                $fields = [
                    'to'              => $token,
                    'notification'   => $noti,
                    'data'           => $message,
                ];
    
    
                $notification = $this->sendNotification($token, $fields);
                
    
    
                $Notification = $this->NotificationModel->save([
                    'message'     => $this->input->post('message'),
                    'heading'      => $this->input->post('title'),
                    'user_id'   => $this->input->post('user_id'),
                    'status'    => true,
                    'created_date' => date('Y-m-d H:i:s')
                ]);
            }
           

            flash_message(
                'add/notification',
                $Notification,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/notification',
                $Notification,
                'success',
                "Notification Added Successfully"
            );
        }
        $employee = json_decode(json_encode($this->UsersModel->all([
            'conditions' => ['status!=' => '3'],
            'fields' => ['id', 'username','mobile']
        ])));

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('notification/singleadd', compact('employee'));
        $this->load->view('template/footer');
    }




    /** Load Category List Page */
    public function list_notification()
    {

        $plan_param = [
            'conditions' => [
                'status ='   => '1'
            ],
            'order' => [
                'by'   => 'notifications.id',
                'type' => 'DESC'
            ],
            'datatype' => 'json'
        ];

        $Notification = $this->NotificationModel->all($plan_param);



        $NotificationData = '';
        empty($Notification) or is_array($Notification) and $NotificationData = object([
            'type' => 'Notification',
            'data' => $Notification
        ]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('notification/list', compact('NotificationData'));
        $this->load->view('template/footer');
    }

    

    /** Delete Category */
    public function delete_notification($id = null)
    {
        empty($id) and show_404();

        user_can('notification_delete') or show_404();

        flash_message(
            'list/notification',
            $id,
            'unsuccess',
            "Please Select Id"
        );

        $notification = $this->NotificationModel->destroy(['id' => $id]);
        flash_message(
            'list/notifications',
            $notification,
            'unsuccess',
            "Something Went Wrong"
        );

        flash_message(
            'list/notification',
            $notification,
            'success',
            "notification Deleted Successfully"
        );
    }
}

    /* End of file Category.php */
