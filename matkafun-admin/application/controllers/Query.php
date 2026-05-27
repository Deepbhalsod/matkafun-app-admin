<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Query extends CI_Controller
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
 
        $this->load->model(['QueryModel']);
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }


    /** Load List Page */
    public function list_query()
    {

        $userData = [];
        $userData = $this->QueryModel->all([

            'order' => [
                'by'   => 'id',
                'type' => 'DESC'
            ]
        ]);


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('query/list', compact('userData'));
        $this->load->view('template/footer');
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
