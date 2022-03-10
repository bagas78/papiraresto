<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diskon extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data['title'] = 'Diskon';
        $data['content'] = 'diskon/index';
        $data['user'] = infoLogin();
        $data['toko'] = $this->db->get('profil_perusahaan')->row();

        $data['data'] = $this->db->query("SELECT * FROM t_diskon WHERE diskon_hapus = 0")->result_array();

        $this->load->view('templates/main', $data);
    }
    public function add(){
        $set = array(
                        'diskon_nama' => $_POST['diskon_nama'],
                        'diskon_persen' => $_POST['diskon_persen'], 
                    );
        $this->db->set($set);
        if ($this->db->insert('t_diskon')) {
            $alert = 'alert-success';
            $respon = 'Data Diskon berhasil disimpan.';
        }else{
            $alert = 'alert-danger';
            $respon = 'Data Diskon Gagal disimpan.';
        }

        $this->session->set_flashdata('message', '<div class="alert '.$alert.' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>'.$respon.'</div>');

        redirect(base_url('diskon'));
    }
    public function edit($id){

        $set = array(
                        'diskon_nama' => $_POST['diskon_nama'],
                        'diskon_persen' => $_POST['diskon_persen'], 
                    );
        $this->db->where('diskon_id',$id);
        $this->db->set($set);
        if ($this->db->update('t_diskon')) {
            $alert = 'alert-success';
            $respon = 'Data Diskon berhasil disimpan.';
        }else{
            $alert = 'alert-danger';
            $respon = 'Data Diskon Gagal disimpan.';
        }

        $this->session->set_flashdata('message', '<div class="alert '.$alert.' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>'.$respon.'</div>');

        redirect(base_url('diskon'));
    }
    public function hapus($id){
        $set = array(
                        'diskon_hapus' => 1,
                    );
        $this->db->where('diskon_id',$id);
        $this->db->set($set);
        if ($this->db->update('t_diskon')) {
            $alert = 'alert-success';
            $respon = 'Data Diskon berhasil hapus.';
        }else{
            $alert = 'alert-danger';
            $respon = 'Data Diskon Gagal hapus.';
        }

        $this->session->set_flashdata('message', '<div class="alert '.$alert.' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>'.$respon.'</div>');
    }
}
