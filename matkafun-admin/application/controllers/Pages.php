<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load FrontEnd Pages */
class Pages extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model(['GalidisawarBidModel', 'GalidisawarGameRateModel', 'GalidisawarGameModel', 'GalidisawarResultModel','StarlineGameRateModel','StarlineResultsModel','StarlineGamesModel','GamesModel','GameRateModel','ResultsModel', 'VideoModel', 'SettingsModel','settingsModel', 'PagesModel','ManagerModel','FirstaidModel','BannerModel']);
	}


	public function home()
	{
		$whr_arr1  = [
			'conditions' => ['id' => 1],
			'fields' => ['about']
		];
		$settingData = $this->PagesModel->first($whr_arr1);

		$whr_arrss1  = [
			'conditions' => ['id' => 1],
			'fields' => ['url']
		];
		$settingDataapk = $this->ManagerModel->first($whr_arrss1);


		$date = date("Y-m-d");
        $start_date = ("$date 00:00:00");
        $end_date = ("$date 23:59:59");
        
		$datein = date('d M Y');
		
        $lautries = [];
	    $lautries = $this->GamesModel->all(['conditions' => ['status'=>'1'],'order' =>['by'=>'open_time','type'=>'ASC']]);
	    if($lautries)
	    {
    	    foreach($lautries as $key=> $val)
    	    {
    	        
    	       	$whr_arr11  = [
        			'conditions' => [
        			    'decleared_at>=' => $start_date,
        			    'decleared_at<=' => $end_date,
        			    'game_id'=>$val['id']
        			    ]
    		     ];
    		   $Data1 = $this->ResultsModel->first($whr_arr11);
    		   
    		   $lautries[$key]['result'] = $Data1;
    		   $start_time = $val['open_time'];
    		   $end_time = $val['close_time'];
    		   $lautries[$key]['open_time'] = date("g:i A", strtotime($start_time));
    		   $lautries[$key]['close_time'] = date("g:i A", strtotime($end_time));
     
    	    }
	
        }
        
        $starline_game = [];
	    $starline_game = $this->StarlineGamesModel->all(['conditions' => ['status'=>'1'],'order' =>['by'=>'time','type'=>'ASC']]);
	    if($starline_game)
	    {
    	    foreach($starline_game as $key_starline=> $val_starline)
    	    {
    	        
    	       	$whr_arr1122  = [
        			'conditions' => [
        			    'date>=' => $start_date,
        			    'date<=' => $end_date,
        			    'game_id'=> $val_starline['id'],
        			    ]
    		     ];
    		    
    		   $Data12 = $this->StarlineResultsModel->first($whr_arr1122);
    		   if(!empty($Data12)){
    		      $starline_game[$key_starline]['result'] = $Data12['panna']."-".$Data12['digit']; 
    		   }else{
    		       
    		       $starline_game[$key_starline]['result'] = '***-*'; 
    		   }
    		   
    		   $start_time = $val_starline['time'];
    		   $starline_game[$key_starline]['time'] = date("g:i A", strtotime($start_time));
     
    	    }
        }
        
        $galidisawar_game = [];
	    $galidisawar_game = $this->GalidisawarGameModel->all(['conditions' => ['status'=>'1'],'order' =>['by'=>'time','type'=>'ASC']]);
	    if($galidisawar_game)
	    {
    	    foreach($galidisawar_game as $key_galidisawar => $val_galidisawar)
    	    {
    	        
    	       	$whr_arr_galidisawar  = [
        			'conditions' => [
        			    'date>=' => $start_date,
        			    'date<=' => $end_date,
        			    'game_id'=> $val_galidisawar['id'],
        			    ]
    		     ];
    		    
    		   $Data_galidisawar = $this->GalidisawarResultModel->first($whr_arr_galidisawar);
    		   if(!empty($Data_galidisawar)){
    		      $galidisawar_game[$key_galidisawar]['result'] = $Data_galidisawar['left_digit']."-".$Data_galidisawar['right_digit']; 
    		   }else{
    		       
    		       $galidisawar_game[$key_galidisawar]['result'] = '**'; 
    		   }
    		   
    		   $start_time = $val_galidisawar['time'];
    		   $galidisawar_game[$key_galidisawar]['time'] = date("g:i A", strtotime($start_time));
     
    	    }
        }
       
		
		$whrvideo = [
			'conditions' => [
				'status' => '1',
				'id'=>1
			]
		];
		$Video = $this->VideoModel->first($whrvideo);
		if ($Video) {
			$SVideo = $Video;
		} else {
			$SVideo = '';
		}
		
		$starline_rate = $this->StarlineGameRateModel->all();
		if ($starline_rate) {
			$rate = $starline_rate;
		} else {
			$rate = '';
		}
	    
	    $galidisawar_rate = $this->GalidisawarGameRateModel->all();
		if ($galidisawar_rate) {
			$galidisawar_rate_new = $galidisawar_rate;
		} else {
			$galidisawar_rate_new = '';
		}
		
		
		$play = $this->GameRateModel->all();
		if ($play) {
			$plays = $play;
		} else {
			$plays = '';
		}
	
	    $app_ss = $this->FirstaidModel->all([
	         'order' => [
				'by'   => 'id',
				'type' => 'DESC'
			]   
	    ]);
	    
	    $bnr_img = $this->BannerModel->first(['id'=>'1']);
	    
	    $support_mobile = $this->SettingsModel->first(['option_key'=>'mobile_no_1']);
	    
	    $whtsp_mobile = $this->SettingsModel->first(['option_key'=>'whatsapp_no']);
	    
	    $whr_logo  = [
            'conditions' => ['option_key' => 'web_logo'],
            'fields' => ['option_value']
        ];
        $web_logo = $this->SettingsModel->first($whr_logo);
        
        $whr_name  = [
            'conditions' => ['option_key' => 'project_name'],
            'fields' => ['option_value']
        ];
        $web_name = $this->SettingsModel->first($whr_name);
	
		$this->load->view('pages/index', compact('galidisawar_game','galidisawar_rate_new','rate','starline_game','web_name','web_logo','plays','SVideo', 'lautries', 'settingData','datein', 'settingDataapk','app_ss','bnr_img','support_mobile','whtsp_mobile'));
	}

	public function game_chart($slug)
	{
	    $red_digit = RED_DIGIT;
		$slugg = str_replace("_", " ", $slug);
		$sluggss =  urldecode($slugg);
     
		$whrarr  = [
			'conditions' => [
				'name' => $sluggss,
				'status' => '1'
			]
		];
		$lautry = $this->GamesModel->first($whrarr);
		if($lautry)
		{
		  	$whr_arrRAJn  = [
			'conditions' => [
    				'game_id' => $lautry['id']
    			],
    			'order' => [
    				'by'   => 'decleared_at',
    				'type' => 'DESC'
    			]
    		];
    		$DataRAJn = $this->ResultsModel->all($whr_arrRAJn); 
    			foreach ($DataRAJn as $key => $value) {
    
    				$dd =  $value['decleared_at'];
    				$newDate = date('d M Y', strtotime($dd));
    				$dayDate = date('D', strtotime($dd));
    				$DataRAJn[$key]['date'] = $newDate;
    				$DataRAJn[$key]['day'] = $dayDate;
    			}
    			
    			$SRIsdDEVI = $DataRAJn;
		}else{
		    $SRIsdDEVI = '';
		}
	    
	     $whr_name  = [
            'conditions' => ['option_key' => 'project_name'],
            'fields' => ['option_value']
        ];
        $web_name = $this->SettingsModel->first($whr_name);
        
        
		$this->load->view('pages/game_chart', compact('SRIsdDEVI', 'sluggss','red_digit','web_name'));
	}
	
	public function starline_game_rate()
	{
	    $gameResults = array();
	    
	    $oldestResult  = [
			'conditions' => [
    				
    			],
    			'order' => [
    				'by'   => 'id',
    				'type' => 'ASC'
    			]
    		];
	    $oldResult = $this->StarlineResultsModel->first($oldestResult);
	    $oldestDate = date('Y-m-d');
	    if($oldResult){
	        $oldestDate = date('Y-m-d', strtotime($oldResult['date']));
	    }
	    $currentDate = date('Y-m-d');
	    
	    $startTime = strtotime($oldestDate);
        $endTime = strtotime($currentDate);
        
        $whrarr  = [
			'conditions' => [
				'status' => 1
			],
			'order' => [
			    'by' => 'time',
			    'type' => 'ACS'
			    ]
		];
		$games = $this->StarlineGamesModel->all($whrarr);
		
		for ( $i = $endTime; $i >= $startTime; $i = $i - 86400 ){
		    $thisDate = date( 'd-m-Y', $i );
            $declareStart = date('Y-m-d 00:00:00',$i);
            $declareEnd = date('Y-m-d 23:59:59',$i);
		    foreach($games as $gameKey => $gameData){
                $whr_con  = [
                    'conditions' => [
                    'game_id' => $gameData['id'],
                    'date>=' => $declareStart,
                    'date<=' => $declareEnd
                ]];
                $gameResult = $this->StarlineResultsModel->first($whr_con);
                $name = $gameData['name'];
                if($gameResult){
                    $gameResults[$thisDate][$name]['panna'] = $gameResult['panna'];
                    $gameResults[$thisDate][$name]['digit'] = $gameResult['digit'];
                }
                else{
                    $gameResults[$thisDate][$name]['panna'] = '***';
                    $gameResults[$thisDate][$name]['digit'] = '*';
                }
		    }
		}
		
	    
	    $whr_name  = [
            'conditions' => ['option_key' => 'project_name'],
            'fields' => ['option_value']
        ];
        $web_name = $this->SettingsModel->first($whr_name);
        
        
		$this->load->view('pages/starline_game_rate', compact('games', 'web_name','gameResults'));
	}
    
    public function gali_disawar_game_rate()
	{
	    $gameResults = array();
	    
	    $oldestResult  = [
			'conditions' => [
    				
    			],
    			'order' => [
    				'by'   => 'id',
    				'type' => 'ASC'
    			]
    		];
	    $oldResult = $this->GalidisawarResultModel->first($oldestResult);
	    $oldestDate = date('Y-m-d', strtotime($oldResult['date']));
	    $currentDate = date('Y-m-d');
	    
	    $startTime = strtotime($oldestDate);
        $endTime = strtotime($currentDate);
        
        $whrarr  = [
			'conditions' => [
				'status' => 1
			],
			'order' => [
			    'by' => 'time',
			    'type' => 'ACS'
			    ]
		];
		$games = $this->GalidisawarGameModel->all($whrarr);
		
		for ( $i = $endTime; $i >= $startTime; $i = $i - 86400 ){
		    $thisDate = date( 'd-m-Y', $i );
            $declareStart = date('Y-m-d 00:00:00',$i);
            $declareEnd = date('Y-m-d 23:59:59',$i);
		    foreach($games as $gameKey => $gameData){
                $whr_con  = [
                    'conditions' => [
                    'game_id' => $gameData['id'],
                    'date>=' => $declareStart,
                    'date<=' => $declareEnd
                ]];
                $gameResult = $this->GalidisawarResultModel->first($whr_con);
                $name = $gameData['name'];
                if($gameResult){
                    $gameResults[$thisDate][$name]['left_digit'] = $gameResult['left_digit'];
                    $gameResults[$thisDate][$name]['right_digit'] = $gameResult['right_digit'];
                }
                else{
                    $gameResults[$thisDate][$name]['left_digit'] = '*';
                    $gameResults[$thisDate][$name]['right_digit'] = '*';
                }
		    }
		}
		
	    
	    $whr_name  = [
            'conditions' => ['option_key' => 'project_name'],
            'fields' => ['option_value']
        ];
        $web_name = $this->SettingsModel->first($whr_name);
        
        
		$this->load->view('pages/gali_disawar_game_rate', compact('games', 'web_name','gameResults'));
	}

	public function privacy_policy()
	{
	    $whr_name  = [
            'conditions' => ['option_key' => 'project_name'],
            'fields' => ['option_value']
        ];
        $web_name = $this->SettingsModel->first($whr_name);
        
        $whr_logo  = [
            'conditions' => ['option_key' => 'web_logo'],
            'fields' => ['option_value']
        ];
        $web_logo = $this->SettingsModel->first($whr_logo);



		$this->load->view('pages/privacy_policy', compact('web_name','web_logo'));
	}
}

/* End of file  Pages.php */
