<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('Barang_m'); 
	}
	public function index() 
	{ 
 
		$data = array(
			'title'    => 'Bahan Baku',
			'user'     => infoLogin(),
			'kategori' => $this->db->get('kategori')->result_array(),
			'satuan'   => $this->db->get('satuan')->result_array(),
			'supplier' => $this->db->get('supplier')->result_array(),
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'content'  => 'barang/item/index',
			'item'	   => $this->Barang_m->getAllData()
		);

		$this->load->view('templates/main', $data);
		
	} 

	public function LoadData()
	{
		$json = array(
			"aaData"  => $this->Barang_m->getAllData()
		);
		echo json_encode($json);
	}

	public function inputbarang()
	{
		$this->Barang_m->Save();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Barang berhasil disimpan.</div>');
		redirect('barang/index');
	}

	public function detilmenu($id = '')
	{
		$data = $this->Barang_m->Detail($id);
		echo json_encode($data);
	}
 
	public function detilbarang($id = '')
	{
		$data = $this->Barang_m->Detail_barang($id);
		echo json_encode($data);
	}
	public function hapusbarang($id = '')
	{
		//$this->Barang_m->Delete($id);

		$this->db->where('ID_BARANG',$id);
		$this->db->delete('barang');

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Barang berhasil dihapus.</div>');
	}

	public function caribarang($key = '')
	{
		$data = $this->Barang_m->Search($key);
		echo json_encode($data);
	}

	public function edit($id)
	{
		$id = decrypt_url($id);
		$data = array(
			'title'    => 'Edit Bahan Baku',
			'user'     => infoLogin(),
			'kategori' => $this->db->get('kategori')->result_array(),
			'satuan'   => $this->db->get('satuan')->result_array(),
			'item'	   => $this->Barang_m->Detail_barang($id),
			'supplier' => $this->db->get('supplier')->result_array(),
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'content'  => 'barang/item/edititem'
		);
		$this->load->view('templates/main', $data);
	}

	public function editbarang()
	{
		$this->Barang_m->Edit();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Barang berhasil diubah.</div>');
		redirect('barang/index');
	}

	public function updateStok($stok, $id)
	{
		$brg = $this->db->get_where('barang', ['ID_BARANG' => $id])->row_array();
		if ($stok < 0) {
			$qty = abs($stok);
			$stokBrg = $brg['STOK'] - $qty;
		} else {

			$stokBrg = $brg['STOK'] + $stok;
		}
		$this->db->set(array('STOK' => $stokBrg))->where('ID_BARANG', $id)->update('barang');
	}

	public function barang_operasional()
	{
		$data = array(
			'title'    => 'Barang Operasional',
			'user'     => infoLogin(),
			'content'  => 'barang/barang_operasional/index',
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'load'     => $this->Barang_m->loadOperasional()
		);
		$this->load->view('templates/main', $data);
	}

	public function input_operasional()
	{
		$data = array(
			'title'    => 'Input Barang Operasional',
			'user'     => infoLogin(),
			'content'  => 'barang/barang_operasional/input',
			'toko'     => $this->db->get('profil_perusahaan')->row(),
		);
		$this->load->view('templates/main', $data);
	}

	public function create_operasional()
	{
		$this->Barang_m->Save_operasional();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Barang Operasional berhasil disimpan.</div>');
		redirect('barang/barang_operasional');
	}

	public function hapus_operasional($id = '')
	{
		$getDetil = $this->db->get_where('barang_operasional', ['id_brg_operasional' => $id])->row_array();
		$qty = $getDetil['jml'];
		$idBrg = $getDetil['id_barang'];
		$getBrg = $this->db->get_where('barang', ['ID_BARANG' => $idBrg])->row_array();
		$stokBrg = $getBrg['STOK'];
		$stok = $qty + $stokBrg;
		$updateStok = $this->db->set(array('STOK' => $stok))->where('ID_BARANG', $idBrg)->update('barang');

		$sql = "delete from barang_operasional where id_brg_operasional = '$id'";
		$this->model->General($sql);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Barang Operasional berhasil dihapus.</div>');
	}

	public function barang_keluar()
	{
		if (@$_GET['date']) {
			$tgl = $_GET['date'];
		} else {
			$tgl = '';
		}
		

		$data = array(
			'title'    => 'Pengeluaran Bahan Baku',
			'user'     => infoLogin(),
			'content'  => 'barang/barang_keluar/index',
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'load'     => $this->Barang_m->loadkeluar($tgl)
		);
		$this->load->view('templates/main', $data);
	}

	public function input_barang_keluar()
	{
		$data = array(
			'title'    => 'Input Pengeluaran Bahan Baku',
			'user'     => infoLogin(),
			'content'  => 'barang/barang_keluar/input',
			'toko'     => $this->db->get('profil_perusahaan')->row(),
		);
		$this->load->view('templates/main', $data);
	}

	public function create_keluar()
	{
		$response = $this->Barang_m->Save_keluar();

		if ($response == 1) {
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Pengeluaran Bahan Baku berhasil disimpan.</div>');

		} else {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Gagal!</b> Data Kurang Dari Jumlah Yang Di Inputkan.</div>');
		}
	
		redirect('barang/barang_keluar');
	}
	public function reset(){

		$this->db->set('STOK',0);

		if ($this->db->update('barang')) {
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Stok berhasil di reset.</div>');

		} else {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Gagal!</b> Stok gagal di reset.</div>');
		}
	
		redirect('barang/index');
	}
}
