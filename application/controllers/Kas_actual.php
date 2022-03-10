<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kas_actual extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->model('Kas_m');
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $data = array(
            'title'    => 'Actual Kas',
            'user'     => infoLogin(),
            'toko'     => $this->db->get('profil_perusahaan')->row(),
            'content'  => 'kas_actual/index',
            'total'    => $this->Kas_m->totalKas()
        );
        $this->load->view('templates/main', $data);
    }

    public function create()
    {
        $nominal = $this->input->post('nominal');
        $nominal_nyata = $this->input->post('nominal_nyata');
        $selisih = $nominal - $nominal_nyata;

        if ($selisih > 0) {
            $selisih = '-'.$selisih;
        }else{
            $selisih = $nominal_nyata - $nominal;
        }

        if ($this->db->get_where('actual_finish', ['TANGGAL' => $this->input->post('tanggal'), 'JENIS' => 'Actual Kas', 'SHIFT' => 1])->num_rows()) {
            $shift = 2;
        } else {
            $shift = 1;
        }

        $this->db->insert('kas_actual', [
            'NOMINAL'       => $nominal,
            'NOMINAL_NYATA' => $nominal_nyata,
            'SELISIH'       => $selisih,
            'TANGGAL'       => date('Y-m-d H:i:s', strtotime($this->input->post('tanggal') . ' ' . date('H:i:s'))),
            'SHIFT'         => $shift,
            'ID_USER'       => $this->session->userdata('id_user')
        ]);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><aria-hidden="true">×</span> </button><b>Success!</b> Data Actual Kas berhasil diubah.</div>');
        redirect('kas_actual');
    }

    public function update($id)
    {
        $nominal = $this->input->post('nominal');
        $nominal_nyata = $this->input->post('nominal_nyata');
        $selisih = $nominal - $nominal_nyata;

        if ($selisih > 0) {
            $selisih = '-'.$selisih;
        }else{
            $selisih = $nominal_nyata - $nominal;
        }

        $this->db->update('kas_actual', [
            'NOMINAL'       => $nominal,
            'NOMINAL_NYATA' => $nominal_nyata,
            'SELISIH'       => $selisih,
            'TANGGAL'       => date('Y-m-d H:i:s', strtotime($this->input->post('tanggal') . ' ' . date('H:i:s'))),
            'ID_USER'       => $this->session->userdata('id_user')
        ], [
            'ID_KAS_ACTUAL' => $id
        ]);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><aria-hidden="true">×</span> </button><b>Success!</b> Data Actual Kas berhasil diubah.</div>');
        redirect('kas_actual');
    }

    public function finish_actual()
    {
        if (!$this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Kas'])->num_rows()) {
            $this->db->insert('actual_finish', [
                'TANGGAL'   => date('Y-m-d'),
                'JENIS'     => 'Actual Kas',
                'SHIFT'     => 1
            ]);
        } else {
            $actual_finish = $this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Kas'])->row();
            $this->db->update('actual_finish', [
                'SHIFT'     => 2
            ], [
                'ID_ACTUAL_FINISH' => $actual_finish->ID_ACTUAL_FINISH
            ]);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><aria-hidden="true">×</span> </button><b>Success!</b> Data Actual sudah finish</div>');
        redirect('kas_actual');
    }
}
