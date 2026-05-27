<?php defined('BASEPATH') or exit('No direct script access allowed');

class Number extends CI_Controller
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

        $this->load->model(['GameRateModel']);
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
       public function index()
    {
        return show_404();
    }
    
    
    
    /** Load List Page */
    public function list_game_number($slug)
    {

        $numbers = [];
        $sec_num = [];
        if($slug=="single_digit")
        {
            $numbers = range(0,9);
        }elseif($slug=="jodi_digit")
        {
            $numbers = JODI_DIGIT;
        }elseif($slug=="single_panna")
        {
            $numbers = SINGLE_PANNA;
        }
        elseif($slug=="double_panna")
        {
            $numbers = Double_PANNA;
        }
        elseif($slug=="triple_panna")
        {
            $numbers = Triple_PANNA;
        }
        elseif($slug=="half_sangam")
        {
            $numbers = PANNA;
            $sec_num = range(0,9);
        }
        elseif($slug=="full_sangam")
        {
            $numbers = PANNA;
            $sec_num = PANNA;
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('number/list', compact('numbers','sec_num','slug'));
        $this->load->view('template/footer');
    }


    /** Add Category */
    public function add_game_rate()
    {
        $ratingsData = [];
        if ($this->input->post('addGamerate')) {


            if ((!empty($_POST['single_digit_value_1'])) or (!empty($_POST['single_digit_value_2']))) {

                $job = $this->GameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('single_digit_value_1'),
                    'earning_amount'      => $this->input->post('single_digit_value_2'),
                    'per_point_earning_amount' => $this->input->post('single_digit_value_2')/$this->input->post('single_digit_value_1')
                ], ['id' => 4]);
            }

            if ((!empty($_POST['jodi_digit_value_1'])) or (!empty($_POST['jodi_digit_value_2']))) {

                $job = $this->GameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('jodi_digit_value_1'),
                    'earning_amount'      => $this->input->post('jodi_digit_value_2'),
                    'per_point_earning_amount' => $this->input->post('jodi_digit_value_2')/$this->input->post('jodi_digit_value_1')
                ], ['id' => 5]);
            }

            if ((!empty($_POST['single_pana_value_1'])) or (!empty($_POST['single_pana_value_2']))) {

                $job = $this->GameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('single_pana_value_1'),
                    'earning_amount'      => $this->input->post('single_pana_value_2'),
                    'per_point_earning_amount' => $this->input->post('single_pana_value_2')/$this->input->post('single_pana_value_1')
                ], ['id' => 6]);
            }

            if ((!empty($_POST['double_pana_value_1'])) or (!empty($_POST['double_pana_value_2']))) {

                $job = $this->GameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('double_pana_value_1'),
                    'earning_amount'      => $this->input->post('double_pana_value_2'),
                    'per_point_earning_amount' => $this->input->post('double_pana_value_2')/$this->input->post('double_pana_value_1')
                ], ['id' => 7]);
            }

            if ((!empty($_POST['triple_pana_value_1'])) or (!empty($_POST['triple_pana_value_2']))) {

                $job = $this->GameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('triple_pana_value_1'),
                    'earning_amount'      => $this->input->post('triple_pana_value_2'),
                    'per_point_earning_amount' => $this->input->post('triple_pana_value_2')/$this->input->post('triple_pana_value_1')
                ], ['id' => 8]);
            }
            if ((!empty($_POST['half_sangam_value_1'])) or (!empty($_POST['half_sangam_value_2']))) {

                $job = $this->GameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('half_sangam_value_1'),
                    'earning_amount'      => $this->input->post('half_sangam_value_2'),
                    'per_point_earning_amount' => $this->input->post('half_sangam_value_2')/$this->input->post('half_sangam_value_1')
                ], ['id' => 9]);
            }
            if ((!empty($_POST['full_sangam_value_1'])) or (!empty($_POST['full_sangam_value_2']))) {

                $job = $this->GameRateModel->updateTable([
                    'cost_amount'            => $this->input->post('full_sangam_value_1'),
                    'earning_amount'      => $this->input->post('full_sangam_value_2'),
                    'per_point_earning_amount' => $this->input->post('full_sangam_value_2')/$this->input->post('full_sangam_value_1')
                ], ['id' => 10]);
            }
        }
        $single_d_Data = $this->GameRateModel->first(['conditions' => [
            'id' => 4
        ]]);
        $jodi_digit_Data = $this->GameRateModel->first(['conditions' => [
            'id' => 5
        ]]);
        $single_pana_Data = $this->GameRateModel->first(['conditions' => [
            'id' => 6
        ]]);
        $double_pana_Data = $this->GameRateModel->first(['conditions' => [
            'id' => 7
        ]]);
        $triple_pana_Data = $this->GameRateModel->first(['conditions' => [
            'id' => 8
        ]]);
        $half_sangam_Data = $this->GameRateModel->first(['conditions' => [
            'id' => 9
        ]]);

        $full_sangam_Data = $this->GameRateModel->first(['conditions' => [
            'id' => 10
        ]]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('game_rate/add', compact('full_sangam_Data', 'half_sangam_Data', 'triple_pana_Data', 'double_pana_Data', 'single_pana_Data', 'jodi_digit_Data', 'single_d_Data'));
        $this->load->view('template/footer');
    }


    /** Change Status */

    public function change_status_game($id, $stat)
    {

        if ($stat == 'inactive') {

            $job = $this->GameRateModel->updateTable([
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

            $game = $this->GameRateModel->first([

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


    public function delete_game($id = null)
    {


        $ratings = $this->GameRateModel->destroy(['id' => $id]);
        flash_message(
            'list/game_rate',
            $ratings,
            'unsuccess',
            "Something Went Wrong"
        );

        flash_message(
            'list/game_rate',
            $ratings,
            'success',
            "Game Deleted Successfully"
        );
    }
}

    /* End of file  Rating.php */
