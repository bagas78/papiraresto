<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dpenjualan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    cek_login();
  }
  public function index()
  {
    $data = array(
      'title'    => 'Daftar Penjualan',
      'user'     => infoLogin(),
      'toko'     => $this->db->get('profil_perusahaan')->row(),
      'content'  => 'daftarpenjualan/index',
    );
    $this->load->view('templates/main', $data); 
  }
  public function LoadData()
  {
    if ($this->session->userdata('tipe') == 'Gudang') {
      $sql = "SELECT b.id_jual, b.kode_jual, b.invoice, d.nama_lengkap, c.nama_cs, SUM(a.diskon) diskon, SUM(a.subtotal) as total, b.tgl, SUM(a.qty_jual) AS qty FROM detil_penjualan AS a JOIN penjualan AS b ON b.id_jual = a.id_jual JOIN customer AS c ON c.id_cs = b.id_cs JOIN user AS  d ON d.id_user = b.id_user JOIN menu e ON a.ID_BARANG = e.ID_BARANG
      WHERE  b.is_active = 1 AND e.is_bahan_baku = 1 GROUP BY a.id_jual";
    } else if ($this->session->userdata('tipe') == 'Kasir') {
      $sql = "SELECT b.id_jual, b.kode_jual, b.invoice, d.nama_lengkap, c.nama_cs, SUM(a.diskon) diskon, SUM(a.subtotal) as total, b.tgl, SUM(a.qty_jual) AS qty FROM detil_penjualan AS a JOIN penjualan AS b ON b.id_jual = a.id_jual JOIN customer AS c ON c.id_cs = b.id_cs JOIN user AS  d ON d.id_user = b.id_user JOIN menu e ON a.ID_BARANG = e.ID_BARANG
      WHERE  b.is_active = 1 AND e.is_bahan_baku = 0 GROUP BY a.id_jual";
    } else {
      $sql = "SELECT b.id_jual, b.kode_jual, b.invoice, d.nama_lengkap, c.nama_cs, SUM(a.diskon) diskon, SUM(a.subtotal) as total, b.tgl, SUM(a.qty_jual) AS qty FROM detil_penjualan AS a JOIN penjualan AS b ON b.id_jual = a.id_jual JOIN customer AS c ON c.id_cs = b.id_cs JOIN user AS  d ON d.id_user = b.id_user JOIN menu e ON a.ID_BARANG = e.ID_BARANG
      WHERE  b.is_active = 1 GROUP BY a.id_jual";
    }

    $json = array(
      "aaData"  => $this->model->General($sql)->result_array()
    );
    echo json_encode($json);
  }
  public function detilPenjualan($id = '')
  {
    $sql = "SELECT a.kode_detil_jual, c.barcode, c.nama_barang, c.harga_jual, a.qty_jual, a.diskon, a.subtotal
              FROM detil_penjualan a, penjualan b, menu c
              WHERE b.id_jual = a.id_jual AND c.id_barang = a.id_barang AND  a.id_jual = '$id'";
    $data = $this->model->General($sql)->result_array();
    echo json_encode($data);
  }
}
