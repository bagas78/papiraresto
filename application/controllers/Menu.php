<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
 
	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('Menu_m');
	} 
	public function index()
	{ 
		$data = array(
			'title'    => 'Menu',
			'user'     => infoLogin(),
			'kategori' => $this->db->get('kategori')->result_array(),
			'satuan'   => $this->db->get('satuan')->result_array(),
			'supplier' => $this->db->get('supplier')->result_array(),
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'barang'     => $this->db->query("SELECT * FROM barang as a JOIN satuan as b ON a.ID_SATUAN = b.ID_SATUAN WHERE a.IS_ACTIVE = 1 ORDER BY a.nama_barang ASC")->result_array(),
			'content'  => 'menu/item/index',
			'item'	   => $this->Menu_m->getAllData()
		);
		$this->load->view('templates/main', $data);
	}

	public function LoadData()
	{
		$json = array(
			"aaData"  => $this->Menu_m->getAllData()
		);
		echo json_encode($json);
	}

	public function inputbarang()
	{
		$this->Menu_m->Save();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Menu berhasil disimpan.</div>');
		redirect('menu/index');
	}

	public function detilbarang($id = '')
	{
		$data = $this->Menu_m->Detail($id);
		echo json_encode($data);
	}
	public function hapusbarang($id = '')
	{
		//$this->Menu_m->Delete($id);

		$this->db->where('ID_BARANG',$id);
		$this->db->delete('menu');

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Menu berhasil dihapus.</div>');
	}

	public function caribarang($key = '')
	{
		$data = $this->Menu_m->Search($key);
		echo json_encode($data);
	}

	public function edit($id)
	{
		$id = decrypt_url($id);
		$data = array(
			'title'    => 'Edit Item',
			'user'     => infoLogin(),
			'kategori' => $this->db->get('kategori')->result_array(),
			'satuan'   => $this->db->get('satuan')->result_array(),
			'item'	   => $this->Menu_m->Detail($id),
			'supplier' => $this->db->get('supplier')->result_array(),
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'content'  => 'menu/item/edititem'
		);
		$this->load->view('templates/main', $data);
	}

	public function editbarang()
	{
		$this->Menu_m->Edit();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Menu berhasil diubah.</div>');
		redirect('menu/index');
	}

	public function updateStok($stok, $id)
	{
		$brg = $this->db->get_where('menu', ['ID_BARANG' => $id])->row_array();
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
			'title'    => 'Menu Operasional',
			'user'     => infoLogin(),
			'content'  => 'menu/barang_operasional/index',
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'load'     => $this->Menu_m->loadOperasional()
		);
		$this->load->view('templates/main', $data);
	}

	public function input_operasional()
	{
		$data = array(
			'title'    => 'Input Menu Operasional',
			'user'     => infoLogin(),
			'content'  => 'menu/barang_operasional/input',
			'toko'     => $this->db->get('profil_perusahaan')->row(),
		);
		$this->load->view('templates/main', $data);
	}

	public function create_operasional()
	{
		$this->Menu_m->Save_operasional();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Menu Operasional berhasil disimpan.</div>');
		redirect('menu/barang_operasional');
	}

	public function hapus_operasional($id = '')
	{
		$getDetil = $this->db->get_where('barang_operasional', ['id_brg_operasional' => $id])->row_array();
		$qty = $getDetil['jml'];
		$idBrg = $getDetil['id_barang'];
		$getBrg = $this->db->get_where('menu', ['ID_BARANG' => $idBrg])->row_array();
		$stokBrg = $getBrg['STOK'];
		$stok = $qty + $stokBrg;
		$updateStok = $this->db->set(array('STOK' => $stok))->where('ID_BARANG', $idBrg)->update('barang');

		$sql = "delete from barang_operasional where id_brg_operasional = '$id'";
		$this->model->General($sql);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Menu Operasional berhasil dihapus.</div>');
	}

	public function barang_rusak()
	{
		$data = array(
			'title'    => 'Pengeluaran Bahan Baku',
			'user'     => infoLogin(),
			'content'  => 'menu/barang_rusak/index',
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'load'     => $this->Menu_m->loadRusak()
		);
		$this->load->view('templates/main', $data);
	}

	public function input_barang_rusak()
	{
		$data = array(
			'title'    => 'Input Pengeluaran Bahan Baku',
			'user'     => infoLogin(),
			'content'  => 'menu/barang_rusak/input',
			'toko'     => $this->db->get('profil_perusahaan')->row(),
		);
		$this->load->view('templates/main', $data);
	}

	public function create_rusak()
	{
		$this->Menu_m->Save_rusak();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Pengeluaran Bahan Baku berhasil disimpan.</div>');
		redirect('menu/barang_rusak');
	}
	public function get_racikan($id){
		$response = $this->db->query("SELECT * FROM racikan WHERE racikan_menu = '$id'")->result_array();
		echo json_encode($response);
	}
	public function save_racikan(){
		$id_menu = $_POST['id_menu'];
		$foreach = $_POST['foreach'];

		//alert
		$success = '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Racikan berhasil disimpan.</div>';

		$danger = '<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Gagal!</b> Data Racikan gagal disimpan.</div>';
		//

		$this->db->where('racikan_menu', $id_menu);

		if ($this->db->delete('racikan')) {
			
			for ($i=0; $i < $foreach; $i++) { 
				
				$set = array(
							'racikan_menu' => $id_menu,
							'racikan_barang' => $_POST['racikan_barang'][$i], 
							'racikan_jumlah' => $_POST['racikan_jumlah'][$i], 
							);

				$this->db->set($set);

				if ($this->db->insert('racikan')) {
					// sukses
					$this->session->set_flashdata('message', $success);
				} else {
					// gagal
					$this->session->set_flashdata('message', $danger);
				} 
			}
		}

		redirect('menu/index');
		
	}
}
