<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Barang_m'); 
		cek_login();
	}

	public function semua_barang()
	{
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_item', $this->data);
	}

	public function itemBySupplier()
	{
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();

		$id = $this->input->post('itemsupp');
		$this->data['sup'] = $this->db->get_where('supplier', ['ID_SUPPLIER' => $id])->row();
		$this->data['id'] = $id;
		$this->load->view('report/report_item_by_supplier', $this->data);
	}

	public function penjualan()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_penjualan', $this->data);
	}

	public function penjualanByKar()
	{
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$id = $this->input->post('iduser');
		$this->data['user'] = $this->db->get_where('user', ['ID_USER' => $id])->row();
		$this->data['id'] = $id;
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->load->view('report/report_penjualan_byKar', $this->data);
	}

	public function penjualan_perFak()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_penjualan_faktur', $this->data);
	}

	public function penjualan_detilFak()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_penjualan_detilfak', $this->data);
	}


	public function pembelian()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_pembelian', $this->data);
	}

	public function supplier()
	{
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->data['sup'] = $this->db->get('supplier')->result_array();
		$this->data['detil'] = $this->db->get('supplier')->result_array();
		$this->load->view('report/report_supplier', $this->data);
	}

	public function kas()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_kas', $this->data);
	}
	public function kas_bank()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_bank', $this->data);
	}

	public function karyawan()
	{
		$this->data['data'] = $this->db->get('karyawan')->result_array();
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_karyawan', $this->data);
	}

	public function customer()
	{
		$this->data['data'] = $this->db->get('customer')->result_array();
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_customer', $this->data);
	}

	public function stokopname()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();   
		$this->data['info_user'] = infoLogin();
		$this->load->view('report/report_stokopname', $this->data);
	}

	public function kas_actual()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_kas_actual', $this->data);
	}

	public function laba_kotor()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_laba_kotor', $this->data);
	}

	public function laba_bersih()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['lain'] = $this->input->post('lain_lain');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_laba_bersih', $this->data);
	}

	public function print_barcode()
	{
		$this->data['barcode_num'] = $this->input->post('barcode_num');
		$this->data['jumlah'] = $this->input->post('jumlah_barcode');
		$this->load->view('report/report_barcode', $this->data);
	}

	public function struk_penjualan($id = '')
	{
		$this->data['id_resi'] = $id;
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/struk_penjualan', $this->data);
	}

	public function barang_operasional()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_operasional', $this->data);
	}

	public function barang_keluar()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_brg_keluar', $this->data);
	}
	    
	public function barang_bahan_keluar($tgl){
	 //    $this->data['awal'] = $this->input->get('date');
		// $this->data['akhir'] = $this->input->get('date'); 
		
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->data['data'] = $this->Barang_m->loadkeluar($tgl);
		$this->load->view('report/report_brg_bahan_keluar', $this->data);
	}
	
	public function hutang()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['supplier'] = $this->input->post('supplier');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_hutang', $this->data);
	}
	public function piutang()
	{
		$this->data['awal'] = $this->input->post('awal');
		$this->data['akhir'] = $this->input->post('akhir');
		$this->data['customer'] = $this->input->post('customer');
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		$this->load->view('report/report_piutang', $this->data);
	}
}
