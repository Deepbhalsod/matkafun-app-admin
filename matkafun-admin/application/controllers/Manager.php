<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Manager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(['ManagerModel', 'UsersModel']);
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }


    /** Add manager */
    public function add_manager()
    {

        if ($this->input->post('addmanager')) {

            $mystring = $_FILES['product']['name'];
            $word = ".apk";
            if (strpos($mystring, $word) !== false) {


                if (!is_dir('uploads/apk')) {
                    mkdir('./uploads/apk', 0777, true);
                }

                $config['upload_path']          = './uploads/apk';
                $config['allowed_types']        = 'apk|APK';
                $config['max_size']             = 100000; // Increased max size
                $this->load->library('upload', $config);
                
                $path = '';

                if ($this->upload->do_upload('product')) {
                    $data = array('upload_data' => $this->upload->data());
                    $FileName       = $data['upload_data']['file_name'];
                    $FullPath       = $data['upload_data']['full_path'];
                    $path           = SITE_URL . "uploads/apk/" . $data['upload_data']['file_name'];
                    
                     $firstaid = $this->ManagerModel->updateTable([
                        'url'           => $path,
                    ], ['id' => 1]);
    
                    flash_message(
                        'list/manager',
                        $firstaid,
                        'success',
                        "Apk Created Successfully"
                    );
                } else {
                     flash_message(
                        'add/manager',
                        '',
                        'unsuccess',
                        $this->upload->display_errors()
                    );
                }
            } else {
             
                 $firstaid = $this->ManagerModel->updateTable([
                    'url'           => $_POST['url'],
                ], ['id' => 1]);
                
                 flash_message(
                    'add/manager',
                    $firstaid,
                    'unsuccess',
                    "Something Went Wrong"
                );

                flash_message(
                    'list/manager',
                    $firstaid,
                    'success',
                    "Apk Created Successfully"
                );
                
            }
        }
        
         $apk= $this->ManagerModel->first(['id' => 1]);


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('manager/add',compact('apk'));
        $this->load->view('template/footer');
    }



    /**  List manager */
    public function list_manager()
    {
        $banner = '';
        $banner = $this->ManagerModel->all([

            'order' => [
                'by' => 'id',
                'type' => 'DESC'
            ],

        ]);

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('manager/list', compact('banner'));
        $this->load->view('template/footer');
    }

    public function delete_manager($id = null)
    {

        $role = $this->ManagerModel->destroy(['id' => $id]);
        flash_message(
            'list/manager',
            $role,
            'unsuccess',
            "Something Went Wrong"
        );

        flash_message(
            'list/manager',
            $role,
            'success',
            "manager Deleted Successfully"
        );
    }
}    /* End of file  Product.php */
