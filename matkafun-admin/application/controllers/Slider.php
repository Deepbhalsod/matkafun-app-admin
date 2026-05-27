<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Slider extends CI_Controller
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

        $this->load->model(['SlidersModel']);
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }


    /** Load Category List Page */
    public function list_slider()
    {

        $sliderData = [];
        $slider = $this->SlidersModel->all([

            'order' => [
                'by'   => 'sliders.id',
                'type' => 'DESC'
            ]
        ]);



        is($slider, 'array')
            and $sliderData = json_decode(json_encode([
                'type' => 'sliders',
                'data' => $slider

            ]));
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('slider/list', compact('sliderData'));
        $this->load->view('template/footer');
    }


    /** Add Category */
    public function add_slider()
    {
        if ($this->input->post('addSlider')) {
            $title              = $_REQUEST['title'];

            /* Upload Images */

            $form_images = upload(['uploads/slider' => 'sliderImg']);

            /* Check Document Image Uploaded */

            flash_message(
                'add/slider',
                isset($form_images['sliderImg']),
                'unsuccess',
                'Something Went Wrong',
                "Please Upload Slider Image & Try Again."
            );

               isset($form_images['sliderImg']) and $slider_image = $form_images['sliderImg'][0] or $slider_image = "";
              
               $slider = $this->SlidersModel->save([
                            'image'             => $slider_image,
                            'title'             => $title,
                            'status'            => '2'
                        ]);
              
              
              
              
              
        // 			$config['upload_path']         = './uploads/slider/';
        //             $config['allowed_types']     = 'gif|jpg|png|jpeg';
        //             $config['encrypt_name']        = TRUE;
        
        //             $this->load->library('upload', $config);
                   
        //             if ($this->upload->do_upload('sliderImg')) {
        
        //                 $data = array('upload_data' => $this->upload->data());
        
        //                 $FileName     = $data['upload_data']['file_name'];
        //                 $FullPath     = $data['upload_data']['full_path'];
        //                 $path         = SITE_URL . "uploads/slider/" . $data['upload_data']['file_name'];
                       
        //                 $img = file_get_contents($path);
                                  
        //                         // Encode the image string data into base64
        //                 $data = base64_encode($img);
            				
                       

        //             }
            
            
            flash_message(
                'add/slider',
                $slider,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/slider',
                $slider,
                'success',
                " Slider Successfully"
            );
        }
        $slides = json_decode(json_encode($this->SlidersModel->all([])));

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('slider/add', compact('slides'));
        $this->load->view('template/footer');
    }

    /** Add Category */
    public function edit_slider($id)
    {


        if ($this->input->post('editSlider')) {

            /* Upload Images */
            $form_images = upload(['uploads/slider' => 'sliderImg']);

            isset($form_images['sliderImg']) and $slider_image = $form_images['sliderImg'][0] or $slider_image = $this->input->post('oldsliderImg');
            
            
             $slider = $this->SlidersModel->updateTable([
                'image'       => $slider_image,
                'title' => $this->input->post('title'),
            ], ['id' => $id]);
                        
                        
            	   // $config['upload_path']         = './uploads/slider/';
                //     $config['allowed_types']     = 'gif|jpg|png|jpeg';
                //     $config['encrypt_name']        = TRUE;
        
                //     $this->load->library('upload', $config);
                   
                //     if ($this->upload->do_upload('sliderImg')) {
        
                //         $data = array('upload_data' => $this->upload->data());
        
                //         $FileName     = $data['upload_data']['file_name'];
                //         $FullPath     = $data['upload_data']['full_path'];
                //         $path         = SITE_URL . "uploads/slider/" . $data['upload_data']['file_name'];
                       
                //         $img = file_get_contents($path);
                                  
                //                 // Encode the image string data into base64
                //         $data = base64_encode($img);
            
                       
                        

                //     }

           

            flash_message(
                'edit/slider/' . $id,
                $slider,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/slider',
                $slider,
                'success',
                "Slider Updated Successfully"
            );
        }


        $sliderData = '';
        $slider = $this->SlidersModel->first([
            'conditions' => [
                'id'     => $id,
            ]
        ]);
        empty($slider) or is_array($slider) and $sliderData = json_decode(json_encode($slider));

        $slides = json_decode(json_encode($this->SlidersModel->all([
            'feilds' => ['id']
        ])));
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('slider/edit', compact('slides', 'sliderData'));
        $this->load->view('template/footer');
    }

    /** Change Status */

    public function change_status($id, $stat)
    {
        if ($stat == 'inactive') {

            $job = $this->SlidersModel->updateTable([
                'status'            => '2'
            ], ['id' => $id]);

            flash_message(
                'list/slider',
                $job,
                'success',
                "Status Inactive Successfully"
            );
        }

        if ($stat == 'active') {

            $job = $this->SlidersModel->updateTable([
                'status'            => '1'
            ], ['id' => $id]);
            flash_message(
                'list/slider',
                $job,
                'success',
                "Status Active Successfully"
            );
        }
    }


    public function delete_slider($id = null)
    {
        empty($id) and show_404();

        user_can('slider_delete') or show_404();

        flash_message(
            'list/slider',
            $id,
            'unsuccess',
            "Please Select Id"
        );

        $sliders = $this->SlidersModel->destroy(['id' => $id]);
        flash_message(
            'list/slider',
            $sliders,
            'unsuccess',
            "Something Went Wrong"
        );

        flash_message(
            'list/slider',
            $sliders,
            'success',
            "slider Deleted Successfully"
        );
    }
}

    /* End of file  Product.php */
