<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Firstaid extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(['FirstaidModel', 'UsersModel']);
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }


    /**  List add_firstaid */
    public function list_firstaid()
    {
        $banner = '';
        $banner = $this->FirstaidModel->all([

            'order' => [
                'by' => 'id',
                'type' => 'DESC'
            ],

        ]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('firstaid/list', compact('banner'));
        $this->load->view('template/footer');
    }

    /** Edit banner */
    public function add_firstaid()
    {
        if ($this->input->post('addfirstaid')) {

            if (isset($_FILES['stylist_doc']['name'])) {
                $uim    = [];
                for ($i = 0; $i < count($_FILES['stylist_doc']['name']); $i++) {

                    if (!empty($_FILES['stylist_doc']['name'][$i])) {

                        // Define new $_FILES array - $_FILES['product_bnr']
                        $_FILES['single_stylist_doc']['name'] = $_FILES['stylist_doc']['name'][$i];
                        $_FILES['single_stylist_doc']['type'] = $_FILES['stylist_doc']['type'][$i];
                        $_FILES['single_stylist_doc']['tmp_name'] = $_FILES['stylist_doc']['tmp_name'][$i];
                        $_FILES['single_stylist_doc']['error'] = $_FILES['stylist_doc']['error'][$i];
                        $_FILES['single_stylist_doc']['size'] = $_FILES['stylist_doc']['size'][$i];

                        // Set preference

                        $config['file_name'] = $_FILES['stylist_doc']['name'][$i];
                        $config['upload_path'] = 'uploads/images/';
                        $config['allowed_types'] = 'gif|jpeg|png|jpg';


                        //_dd($config);

                        //Load upload library

                        $this->load->library('upload', $config);

                        $data = $this->upload->do_upload('single_stylist_doc');
                        $error = array('error' => $this->upload->display_errors());
                        $upload_data = array('upload_data' => $this->upload->data());

                        // print_r($error);
                        // _dd($upload_data);
                        // die('k');

                        // File upload
                        if ($this->upload->do_upload('single_stylist_doc')) {
                            // Get data about the file
                            $uploadData = $this->upload->data();
                            $filename = $uploadData['file_name'];

                            $path = SITE_URL . "uploads/images/" . $filename;
                            $ARR = [
                                'image'       => $path,
                            ];
                            $stylist_doc = $this->FirstaidModel->save($ARR);
                        }
                    }
                }
                redirect('list/firstaid');
            }
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('firstaid/add');
        $this->load->view('template/footer');
    }



    public function delete_firstaid($id = null)
    {

        $role = $this->FirstaidModel->destroy(['id' => $id]);
        flash_message(
            'list/firstaid',
            $role,
            'unsuccess',
            "Something Went Wrong"
        );

        flash_message(
            'list/firstaid',
            $role,
            'success',
            "App Image Deleted Successfully"
        );
    }
}    /* End of file  Product.php */
