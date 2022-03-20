<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Actual extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		cek_login();
		cek_user();
		$this->load->model('Stokopname_m');
		date_default_timezone_set('Asia/Jakarta');
	} 

	public function index() 
	{
		$data = array(
			'title'    => 'Data Stok Opname',
			'user'     => infoLogin(),
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'content'  => 'actual/index',
		);

		if (@$_POST['date']) {
			// search
			$data['current'] = $_POST['date'];
			$date = $_POST['date'];
		} else {
			// sekarang
			$data['current'] = date('Y-m-d');
			$date = date('Y-m-d');
		}

		$data['opname'] = $this->db->query("SELECT * FROM t_opname as a JOIN user AS b ON a.opname_user = b.ID_USER RIGHT JOIN barang AS c ON a.opname_barang = c.ID_BARANG AND DATE_FORMAT(a.opname_tanggal,'%Y-%m-%d') = '$date' JOIN kategori as d ON c.ID_KATEGORI = d.ID_KATEGORI WHERE c.IS_ACTIVE = 1")->result_array();

		$this->load->view('templates/main', $data);
	}

	public function get_data(){
		$id = $_POST['id'];
		$response = $this->db->query("SELECT *, DATE_FORMAT(opname_tanggal,'%Y-%m-%d') AS tanggal_opname FROM t_opname as a JOIN user AS b ON a.opname_user = b.ID_USER RIGHT JOIN barang AS c ON a.opname_barang = c.ID_BARANG WHERE a.opname_id = '$id'")->row_array();
		
		echo json_encode($response);
	}

	public function save(){
		$user = $this->session->userdata('id_user');
		@$id_actual = $_POST['id_actual'];
		$id_barang = $_POST['id_barang'];
		
		//selisih
		$barang = $this->db->query("SELECT * FROM barang WHERE ID_BARANG = '$id_barang'")->row_array();
		$stok = $barang['STOK'];
		$actual = $_POST['actual'];
		$selisih = $actual - $stok;

		//besok
		$date = date('Y/m/d');
		$besok = date('Y-m-d',strtotime($date . "+1 days"));

		if (@$id_actual) {
			// update
			$set = array(
						'opname_stok' => $stok,
						'opname_stok_actual' => $actual,
						'opname_stok_selisih' => $selisih,
					);

			$this->db->where('opname_id',$id_actual);
			$this->db->set($set);
			$this->db->update('t_opname');


		} else {
			// insert
			$set = array(
						'opname_user' => $user,
						'opname_barang' => $id_barang,
						'opname_stok' => $stok,
						'opname_stok_actual' => $actual,
						'opname_stok_selisih' => $selisih,
						'opname_tanggal_actual' => $besok, 
					);

			$this->db->set($set);
			$this->db->insert('t_opname');

		}

		//update barang
		$set1 = array(
						'ACTUAL' => $actual,
						'ACTUAL_TANGGAL' => $besok, 
					);
		$this->db->where('ID_BARANG',$id_barang);
		$this->db->set($set1);
		$this->db->update('barang');

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><aria-hidden="true">×</span> </button><b>Success!</b> Data Actual sudah finish</div>');

		redirect(base_url('actual'));
	}
	public function save_barang(){
		$user = $this->session->userdata('id_user');
		@$id_actual = $_POST['id_actual'];
		$id_barang = $_POST['id_barang'];
		
		//selisih
		$barang = $this->db->query("SELECT * FROM barang WHERE ID_BARANG = '$id_barang'")->row_array();
		$stok = $barang['STOK'];
		$actual = $_POST['actual'];
		$selisih = $actual - $stok;

		//besok
		$date = date('Y/m/d h:i:s');
		$kemarin = date('Y-m-d h:i:s',strtotime($date . "-1 days"));

		if (@$id_actual) {
			// update
			$set = array(
						'opname_stok' => $stok,
						'opname_stok_actual' => $actual,
						'opname_stok_selisih' => $selisih,
					);

			$this->db->where('opname_id',$id_actual);
			$this->db->set($set);
			$this->db->update('t_opname');
		} else {
			// insert
			$set = array(
						'opname_user' => $user,
						'opname_barang' => $id_barang,
						'opname_stok' => $stok,
						'opname_stok_actual' => $actual,
						'opname_stok_selisih' => $selisih,
						'opname_tanggal' => $kemarin, 
						'opname_tanggal_actual' => date('Y-m-d'), 
					);

			$this->db->set($set);
			$this->db->insert('t_opname');
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><aria-hidden="true">×</span> </button><b>Success!</b> Data Actual sudah finish</div>');

		redirect(base_url('barang/index'));
	}

	public function laporan()
	{
		$data = array(
			'title'    => 'Laporan Stok Actual',
			'user'     => infoLogin(),
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'content'  => 'actual/laporan',
		);

		$this->load->view('templates/main', $data);
	}
	public function download(){
		$this->data['profil'] = $this->db->get('profil_perusahaan')->row_array();
		
		// $data['awal'] = new DateTime($_POST['awal']);
		$data['awal'] = $_POST['awal'];
		$data['akhir'] = $_POST['akhir'];

		$data['kategori_data'] = $this->db->query("SELECT * FROM barang AS a JOIN kategori AS b ON a.ID_KATEGORI = b.ID_KATEGORI WHERE a.IS_ACTIVE = 1 AND b.KATEGORI_IS_BARANG = 1 GROUP BY a.ID_KATEGORI")->result_array();
		$data['barang_data'] = $this->db->query("SELECT * FROM barang AS a LEFT JOIN t_opname AS b ON a.ID_BARANG = b.opname_barang LEFT JOIN user AS c ON b.opname_user = c.ID_USER WHERE a.IS_ACTIVE = 1")->result_array();

		$this->load->view('report/report_actual',$data);
	}
}
