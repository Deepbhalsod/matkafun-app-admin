<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Video extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(['VideoModel', 'UsersModel']);
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }

    /**  List Video */
    public function list_video()
    {
        $banner = '';
        $banner = $this->VideoModel->all();

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('video/list', compact('banner'));
        $this->load->view('template/footer');
    }

    public function edit_video($id)
    {

        if ($this->input->post('editvideo')) {

            $url = $this->input->post('url');
            $vdeo_url = getYoutubeEmbedUrl($url);
            $vehicle = $this->VideoModel->updateTable([
                'url'             => $url,

            ], ['id' => $id]);

            flash_message(
                'edit/video/' . $id,
                $vehicle,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/video',
                $vehicle,
                'success',
                "video Updated Successfully"
            );
        }


        $banner = $this->VideoModel->first([
            'conditions' => [
                'id'     => $id
            ]
        ]);


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('video/edit', compact('banner'));
        $this->load->view('template/footer');
    }

    /** Change Status */
    public function change_status_video($user_id)
    {

        if ($this->input->post('changeStatusUser')) {

            $user = $this->VideoModel->updateTable([
                'status'            => $this->input->post('status'),
            ], ['id' => $user_id]);

            flash_message(
                'list/video',
                $user,
                'success',
                "video updated successfull"
            );
        }

        $User = $this->VideoModel->first([
            'conditions' => [
                'id'     => $user_id,
                'status!=' => '3',
            ],
            'datatype'   => 'json'
        ]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('video/change_status', compact('User'));
        $this->load->view('template/footer');
    }
}    /* End of file */
