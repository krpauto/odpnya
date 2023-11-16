<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Odp extends CI_Controller
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
        $this->db->order_by('id_odp');
        $this->data['odp'] = $this->M_Admin->get_table('gis_odp');
        $this->db->order_by('id_odp');
        $this->data['opssawit_user'] = $this->M_Admin->get_table_opssawit_user();

        $this->data['title_web'] = 'Data ODP | SIG PT PLN BATAM';
        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('odp/odp_view', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function tambah()
    {
        $this->data['idbo'] = $this->session->userdata('ses_id');
        $this->data['odp'] = $this->M_Admin->get_table('gis_odp');

        $this->data['title_web'] = 'Tambah Odp | SIG PT PLN BATAM';
        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('odp/tambah_view', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function add()
    {
        $nama_odp = htmlentities($this->input->post('nama_odp', TRUE));
        $status = htmlentities($this->input->post('status', TRUE));
        $alamat = htmlentities($this->input->post('alamat', TRUE));
        $latitude = htmlentities($this->input->post('latitude', TRUE));
        $longitude = htmlentities($this->input->post('longitude', TRUE));
        $warna = htmlentities($this->input->post('warna', TRUE));

        $dd = $this->db->query("SELECT * FROM gis_odp WHERE nama_odp = '$nama'");
        if ($dd->num_rows() > 0) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert"> Gagal Tambah Unit : ' . $nama . ' !, Nama Unit Sudah Ada<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect(base_url('odp/tambah'));
        } else {
            // setting konfigurasi upload
            $nmfile = $nama . '_' . time();
            $config['upload_path'] = './assets_style/file/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['file_name'] = $nmfile;
            // load library upload
            $this->load->library('upload', $config);

            // uploud file pertama
            if ($this->upload->do_upload('foto')) {
                $this->upload->data();
                $file1 = array('upload_data' => $this->upload->data());
            } else {
                return false;
            }

            $data = array(
                'nama_odp' => $nama_odp,
                'status' => $status,
                'alamat' => $alamat,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'warna' => $warna,
                'foto' => $file1['upload_data']['file_name'],
            );
            $this->db->insert('gis_odp', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"> Tambah Unit berhasil !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect(base_url('odp'));
        }
    }

    public function edit()
    {
        if ($this->uri->segment('3') == '') {
            echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('odp') . '";</script>';
        }
        $this->data['idbo'] = $this->session->userdata('ses_id');
        $count = $this->M_Admin->CountTableId('krpaja', 'id_odp', $this->uri->segment('3'));
        if ($count > 0) {
            $this->data['odp'] = $this->M_Admin->get_tableid_edit('gis_odp', 'no_odp', $this->uri->segment('3'));
        } else {
            echo '<script>alert("ODP TIDAK DITEMUKAN");window.location="' . base_url('odp') . '"</script>';
        }
        $this->data['title_web'] = 'Edit Odp | SIG PT PLN BATAM';
        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('odp/edit_view', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function detail()
    {
        $this->data['idbo'] = $this->session->userdata('ses_id');
        $count = $this->M_Admin->CountTableId('gis_odp', 'no_odp', $this->uri->segment('3'));
        if ($count > 0) {
            $this->data['odp'] = $this->M_Admin->get_tableid_edit('gis_odp', 'no_odp', $this->uri->segment('3'));
        } else {
            echo '<script>alert("UNIT TIDAK DITEMUKAN");window.location="' . base_url('odp') . '"</script>';
        }

        $this->data['title_web'] = 'Detail Unit | SIG Sawit';
        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('odp/detail', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function upd()
    {
        $nama_odp = htmlentities($this->input->post('nama_odp', TRUE));
        $alamat = htmlentities($this->input->post('alamat', TRUE));
        $latitude = htmlentities($this->input->post('latitude', TRUE));
        $longitude = htmlentities($this->input->post('longitude', TRUE));
        $warna = htmlentities($this->input->post('warna', TRUE));
        $id = htmlentities($this->input->post('no_odp', TRUE));

        // setting konfigurasi upload
        $post = $this->input->post();
        $nmfile = $nama . '_' . time();
        $config['upload_path'] = './assets_style/file/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 5000;
        $config['file_name'] = $nmfile;
        // load library upload
        $this->load->library('upload', $config);

        if (!empty($_FILES['foto']['name'])) {
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto')) {
                $this->upload->data();
                $file1 = array('upload_data' => $this->upload->data());
            } else {
                return false;
            }

            $foto = './assets_style/file/' . htmlentities($post['foto_old']);
            if (file_exists($foto)) {
                unlink($foto);
            }

            $data = array(
                'nama_odp' => $nama_odp,
                'status' => $status,
                'alamat' => $alamat,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'warna' => $warna,
                'foto' => $file1['upload_data']['file_name']
            );
        } else {
            $data = array(
                'nama_odp' => $nama_odp,
                'status' => $status,
                'alamat' => $alamat,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'warna' => $warna
            );
        }
        $this->M_Admin->update_table('gis_odp', 'no_odp', $id, $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Berhasil Update Unit : ' . $nama . ' !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect(base_url('odp'));
    }

    public function del()
    {
        if ($this->uri->segment('3') == '') {
            echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('odp') . '";</script>';
        }

        $odp = $this->M_Admin->get_tableid_edit('gis_odp', 'no_odp', $this->uri->segment('3'));
        unlink('./assets_style/file/' . $odp->foto);
        $this->M_Admin->delete_table('gis_odp', 'no_odp', $this->uri->segment('3'));
        $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Unit Berhasil di Hapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect(base_url('odp'));
    }
}
