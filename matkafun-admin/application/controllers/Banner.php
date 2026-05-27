<?php defined('BASEPATH') or exit('No direct script access allowed');
/** Load Category Pages & Queries */
class Banner extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(['BannerModel']);
    }


    /** Load Default Index To Show 404 Error
     *
     * @return void */
    public function index()
    {
        return show_404();
    }


    /** Load Category List Page */
    public function list_banner()
    {

        $sliderData = [];
        $slider = $this->BannerModel->all();


        is($slider, 'array')
            and $sliderData = json_decode(json_encode([
                'type' => 'sliders',
                'data' => $slider

            ]));
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('banner/list', compact('sliderData'));
        $this->load->view('template/footer');
    }

    /** Add Category */
    public function edit_banner($id)
    {


        if ($this->input->post('editbanner')) {


            $form_imagesss = upload(['uploads/slider' => 'bannerImg']);

            isset($form_imagesss['bannerImg']) and $banner_image = $form_imagesss['bannerImg'][0] or $banner_image = $this->input->post('oldbannerImg');


            $slider = $this->BannerModel->updateTable([
                'image' => $banner_image,
            ], ['id' => $id]);

            flash_message(
                'edit/banner/' . $id,
                $slider,
                'unsuccess',
                "Something Went Wrong"
            );

            flash_message(
                'list/banner',
                $slider,
                'success',
                "Banner Updated Successfully"
            );
        }


        $sliderData = '';
        $slider = $this->BannerModel->first([
            'conditions' => [
                'id'     => $id,
            ]
        ]);
        empty($slider) or is_array($slider) and $sliderData = json_decode(json_encode($slider));

        $slides = json_decode(json_encode($this->BannerModel->all([
            'feilds' => ['id'],
        ])));
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('banner/edit', compact('slides', 'sliderData'));
        $this->load->view('template/footer');
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
