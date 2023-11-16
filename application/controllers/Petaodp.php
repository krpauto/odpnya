<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Petaodp extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->data['CI'] = &get_instance();
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->model('M_Admin');
        if ($this->session->userdata('masuk_sistem_rekam') != TRUE) {
            $url = base_url('login');
            redirect($url);
        }
    }

    public function index()
    {
        $this->data['idbo'] = $this->session->userdata('ses_id');
        $this->data['title_web'] = 'Peta | SIG PT PLN BATAM';
        $this->data['odp'] = $this->M_Admin->get_table_maps('gis_odp');;
        $this->data['odp'] =  $this->db->query("SELECT * FROM gis_odp ORDER BY id_odp ASC")->result_array();
        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('petaodp/v_peta', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function pencarian()
    {
        $keyword = $this->input->post('keyword');
        $data = array(
            'title_web' => 'Pencarian Unit | SIG Sawit',
            'keyword' =>  $keyword,
            'idbo' => $this->session->userdata('ses_id'),
            'nama' => $this->M_Admin->get_odp_keyword($keyword),
            'daftar_odp' =>  $this->db->query("SELECT * FROM gis_odp ORDER BY id_odp ASC")->result_array()
        );
        $this->load->view('header_view', $data);
        $this->load->view('sidebar_view', $data);
        $this->load->view('petaodp/v_cari', $data);
        $this->load->view('footer_view', $data);
    }
}
