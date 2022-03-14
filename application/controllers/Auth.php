<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data["title"] = "PAPIRA Coffe & Resto";
            $data["toko"] =  $this->db->get('profil_perusahaan')->row();
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login(); 
        }
    }
    private function _user_log()
    {
        date_default_timezone_set('Asia/Jakarta');
        $username = $this->input->post('username');
        $pswd = $this->input->post('password');

        $user = $this->db->get_where('user', ['USERNAME' => $username])->row_array();
        $user_log = array(
            'ID_USER'     => $user['ID_USER'],
            'WAKTU'       => date('d/m/Y H:i:s'),
        );
        $this->model->Simpan('user_log', $user_log);
    }
    private function _login()
    {
        $username = $this->input->post('username');
        $pswd = $this->input->post('password');

        $user = $this->db->get_where('user', ['USERNAME' => $username])->row_array();

        if ($user) {

            if (password_verify($pswd, $user['PASSWORD'])) {

                //switch stok actual
                $brg = $this->db->query("SELECT * FROM barang WHERE NOT ACTUAL = '' AND IS_ACTIVE = 1")->result_array();

                foreach ($brg as $key) {
                    if ($key['ACTUAL'] != '') {
                        
                        $set = array(
                                        'STOK' => $key['ACTUAL'],
                                        'ACTUAL_TANGGAL' => NULL,
                                        'ACTUAL' => NUll,
                                    );
                        $this->db->where('ID_BARANG',$key['ID_BARANG']);
                        $this->db->set($set);
                        $this->db->update('barang');
                    }
                }

                $data = [
                    'id_user'      => $user['ID_USER'],
                    'username'     => $user['USERNAME'],
                    'tipe'         => $user['TIPE']
                ];

                $this->session->set_userdata($data);
                if ($user['TIPE'] == 'Administrator' || $user['TIPE'] == 'Owner') {
                    $this->_user_log();
                    redirect('dashboard');
                } else if ($user['TIPE'] == 'Kasir') {
                    $this->_user_log();
                    redirect('penjualan');
                } else {
                    $this->_user_log();
                    redirect('barang');
                }

            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <b>Error :</b> Password Salah. </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"><b>Error :</b> Username belum terdaftar. </div>');
            redirect('auth');
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><b>Success :</b> Berhasil Logout. </div>');
        redirect('auth');
    }
    public function blocked()
    {
        $data = array(
            'user'    => infoLogin(),
            'title'   => 'Access Denied!'
        );
        $this->load->view('auth/blocked', $data);
    }
}
