<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Game extends CI_Controller
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

        $this->load->model(['GamesModel','GameMarketDayWise']);
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }


    /** Load List Page */
    public function list_game()
    {

        $ratingsData = [];
        $ratingsData = $this->GamesModel->all([
             'conditions' => ['status!=' => '3'],

            'order' => [
                'by'   => 'id',
                'type' => 'DESC'
            ]
        ]);
        
        $t=date('d-m-Y');
        $day = date("D",strtotime($t));
        
        if($day=="Mon")
        {
            foreach($ratingsData as $key=>$val)
            {
                 $whr_day  = [
                        'conditions' => ['game_id' => $val['id']],
                        'fields' => ['mon_open','mon_close'],
                    ];

                $day_market = $this->GameMarketDayWise->first($whr_day);
                
                $ratingsData[$key]['open_time'] = $day_market['mon_open'];
                $ratingsData[$key]['close_time'] = $day_market['mon_close'];
                
            }
            
        }elseif($day=="Tue")
        {
            foreach($ratingsData as $key=>$val)
            {
                 $whr_day  = [
                        'conditions' => ['game_id' => $val['id']],
                        'fields' => ['tue_open','tue_close'],
                    ];

                $day_market = $this->GameMarketDayWise->first($whr_day);
                
                $ratingsData[$key]['open_time'] = $day_market['tue_open'];
                $ratingsData[$key]['close_time'] = $day_market['tue_close'];
                
            }
            
        }elseif($day=="Wed")
        {
            foreach($ratingsData as $key=>$val)
            {
                 $whr_day  = [
                        'conditions' => ['game_id' => $val['id']],
                        'fields' => ['wed_open','wed_close'],
                    ];

                $day_market = $this->GameMarketDayWise->first($whr_day);
                
                $ratingsData[$key]['open_time'] = $day_market['wed_open'];
                $ratingsData[$key]['close_time'] = $day_market['wed_close'];
                
            }
            
        }elseif($day=="Thu")
        {
            foreach($ratingsData as $key=>$val)
            {
                 $whr_day  = [
                        'conditions' => ['game_id' => $val['id']],
                        'fields' => ['thu_open','thu_close'],
                    ];

                $day_market = $this->GameMarketDayWise->first($whr_day);
                
                $ratingsData[$key]['open_time'] = $day_market['thu_open'];
                $ratingsData[$key]['close_time'] = $day_market['thu_close'];
                
            }
            
        }elseif($day=="Fri")
        {
            foreach($ratingsData as $key=>$val)
            {
                 $whr_day  = [
                        'conditions' => ['game_id' => $val['id']],
                        'fields' => ['fri_open','fri_close'],
                    ];

                $day_market = $this->GameMarketDayWise->first($whr_day);
                
                $ratingsData[$key]['open_time'] = $day_market['fri_open'];
                $ratingsData[$key]['close_time'] = $day_market['fri_close'];
                
            }
            
            
        }elseif($day=="Sat")
        {
            
            foreach($ratingsData as $key=>$val)
            {
                 $whr_day  = [
                        'conditions' => ['game_id' => $val['id']],
                        'fields' => ['sat_open','sat_close'],
                    ];

                $day_market = $this->GameMarketDayWise->first($whr_day);
                
                $ratingsData[$key]['open_time'] = $day_market['sat_open'];
                $ratingsData[$key]['close_time'] = $day_market['sat_close'];
                
            }
            
        }elseif($day=="Sun")
        {
            foreach($ratingsData as $key=>$val)
            {
                 $whr_day  = [
                        'conditions' => ['game_id' => $val['id']],
                        'fields' => ['sun_open','sun_close'],
                    ];

                $day_market = $this->GameMarketDayWise->first($whr_day);
                
                $ratingsData[$key]['open_time'] = $day_market['sun_open'];
                $ratingsData[$key]['close_time'] = $day_market['sun_close'];
                
            }
        }
        
        


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('game/list', compact('ratingsData'));
        $this->load->view('template/footer');
    }


    /** Add Category */
    public function add_game()
    {
        if ($this->input->post('addGames')) {
            $open_time = $this->input->post('open_time');
            $close_time = $this->input->post('close_time');
            
            if($open_time > $close_time)
            {
               
                flash_message(
                'add/game',
                true,
                'unsuccess',
                "Please fill Open time small than the close time"
                ); 
            }else{
                
                 $rateingsss = $this->GamesModel->save([
                'name'                           => $this->input->post('name'),
                'open_time'                      => $this->input->post('open_time'),
                'close_time'                     => $this->input->post('close_time'),
                'status'                         => '2',
                ]);
                if($rateingsss)
                {
                
                    $rateinss = $this->GameMarketDayWise->save([
                        'game_id'                             => $rateingsss,
                        'mon_open'                      => $this->input->post('open_time'),
                        'mon_close'                            => $this->input->post('close_time'),
                        'tue_open'                      => $this->input->post('open_time'),
                        'tue_close'                            => $this->input->post('close_time'),
                         'wed_open'                      => $this->input->post('open_time'),
                        'wed_close'                            => $this->input->post('close_time'),
                         'thu_open'                      => $this->input->post('open_time'),
                        'thu_close'                            => $this->input->post('close_time'),
                         'fri_open'                      => $this->input->post('open_time'),
                        'fri_close'                            => $this->input->post('close_time'),
                         'sat_open'                      => $this->input->post('open_time'),
                        'sat_close'                            => $this->input->post('close_time'),
                         'sun_open'                      => $this->input->post('open_time'),
                        'sun_close'                            => $this->input->post('close_time'),
                    ]);
                 }
                 
                 
                flash_message(
                    'add/game',
                    $rateingsss,
                    'unsuccess',
                    "Something Went Wrong"
                );
    
                flash_message(
                    'list/game',
                    $rateingsss,
                    'success',
                    "Game Added Successfully"
                );
                    
            }
            
           
        }


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('game/add');
        $this->load->view('template/footer');
    }

    /** Add Category */
    public function edit_game($id)
    {


        if ($this->input->post('editgame')) {

            $rate = $this->GameMarketDayWise->updateTable([
                   'monday'                      => $this->input->post('mon_status'),
                   'mon_open'                      => $this->input->post('mon_open_time'),
                    'mon_close'                            => $this->input->post('mon_close_time'),
                    'tuesday'                      => $this->input->post('tue_status'),
                    'tue_open'                      => $this->input->post('tue_open_time'),
                    'tue_close'                            => $this->input->post('tue_close_time'),
                    'wednesday'                      => $this->input->post('wed_status'),
                     'wed_open'                      => $this->input->post('wed_open_time'),
                    'wed_close'                            => $this->input->post('wed_close_time'),
                    'thursday'                      => $this->input->post('thu_status'),
                     'thu_open'                      => $this->input->post('thu_open_time'),
                    'thu_close'                            => $this->input->post('thu_close_time'),
                    'friday'                      => $this->input->post('fri_status'),
                     'fri_open'                      => $this->input->post('fri_open_time'),
                    'fri_close'                            => $this->input->post('fri_close_time'),
                    'saturday'                      => $this->input->post('sat_status'),
                     'sat_open'                      => $this->input->post('sate_open_time'),
                    'sat_close'                            => $this->input->post('sate_close_time'),
                    'sunday'                      => $this->input->post('sun_status'),
                     'sun_open'                      => $this->input->post('sun_open_time'),
                    'sun_close'                            => $this->input->post('sun_close_time'),
            ], ['game_id' => $id]);
            // _ddd($vehicles);

            flash_message(
                'edit/game/' . $id,
                $rate,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/game',
                $rate,
                'success',
                "Games Updated Successfully"
            );
        }


        $ratingssssData = '';
        $ratingssssData = $this->GameMarketDayWise->first([
            'conditions' => [
                'game_id'     => $id,
            ]
        ]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('game/edit', compact('ratingssssData'));
        $this->load->view('template/footer');
    }

    /** Change Status */

    public function change_status_game($id, $stat)
    {

        if ($stat == 'inactive') {

            $job = $this->GamesModel->updateTable([
                'status'            => '2',
                'market_status'      => '2'
            ], ['id' => $id]);

            flash_message(
                'list/game',
                $job,
                'success',
                "Status Inactive Successfully"
            );
        }

        if ($stat == 'active') {

            $game = $this->GamesModel->first([

                'conditions' => ['id' => $id]
            ]);

            $open_time = $game['open_time'];
            $close_time = $game['close_time'];
            date_default_timezone_set("Asia/Kolkata");
            $current_time = date("H:i");
            $open_time_24 = date("H:i", strtotime($open_time));
            $close_time_24 = date("H:i", strtotime($close_time));

            if (($close_time_24 >= $current_time) and ($current_time >= $open_time_24)) {
                $m_stts = '1';
            } else {
                $m_stts = '2';
            }

            $job = $this->GamesModel->updateTable([
                'status'            => '1',
                'market_status'      => $m_stts
            ], ['id' => $id]);
            flash_message(
                'list/game',
                $job,
                'success',
                "Status Active Successfully"
            );
        }
    }
    
    public function change_delete($id)
	{

		$job = $this->GamesModel->updateTable([
			'status'=>'3'
		], ['id' => $id]);
	

		flash_message(
			'list/game',
			$job,
			'success',
			"Deleted Successfully"
		);
	}


    public function delete_game($id = null)
    {


        $ratings = $this->GamesModel->destroy(['id' => $id]);
        flash_message(
            'list/game',
            $ratings,
            'unsuccess',
            "Something Went Wrong"
        );

        flash_message(
            'list/game',
            $ratings,
            'success',
            "Game Deleted Successfully"
        );
    }
}

    /* End of file  Rating.php */
