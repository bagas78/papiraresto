<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stokopname_m extends CI_Model
{

  protected $table = 'stok_opname';
  protected $primary = 'id_stok_opname';

  public function getAllData()
  {
    // $sql = "SELECT a.id_stok_opname, b.kode_barang, b.nama_barang, a.stok, a.stok_nyata, a.selisih, a.keterangan, a.tanggal, a.nilai FROM stok_opname a, barang b WHERE a.id_barang = b.id_barang";

    // $this->db->join();
    $this->db->where('is_active', 1);
    if ($this->session->userdata('tipe') == 'Gudang') {
      $this->db->where('is_bahan_baku', 1);
    } else if ($this->session->userdata('tipe') == 'Kasir') {
      $this->db->where('is_bahan_baku', 0);
    }
    return $this->db->get('barang')->result_array();
  }

  public function Save()
  {
    $stok = $this->input->post('stok');
    $stokNyata = $this->input->post('nyata');
    $harga = $this->input->post('harga');
    $selisih = $stok - $stokNyata;

    if ($selisih > 0) {
        $selisih = '-'.$selisih;
    }else{
        $selisih = $stokNyata - $stok;
    }
    
    $nilai = $selisih * $harga;

    if ($this->db->get_where('actual_finish', ['TANGGAL' => $this->input->post('tanggal'), 'JENIS' => 'Actual Stok', 'SHIFT' => 1])->num_rows()) {
      $shift = 2;
    } else {
      $shift = 1;
    }

    $data = array(
      'ID_BARANG'    => htmlspecialchars($this->input->post('iditem'), true),
      'STOK'         => $stok,
      'STOK_NYATA'   => $stokNyata,
      'SELISIH'      => $selisih,
      'NILAI'        => $nilai,
      'KETERANGAN'   => htmlspecialchars($this->input->post('keterangan'), true),
      'TANGGAL'      => date('Y-m-d H:i:s'),
      'SHIFT'        => $shift,
      'ID_USER'      => $this->session->userdata('id_user')
    );
    return $this->db->insert($this->table, $data);
  }

  public function Edit()
  {
    $stok = $this->input->post('stok');
    $stokNyata = $this->input->post('nyata');
    $harga = $this->input->post('harga');
    $selisih = $stok - $stokNyata;
    $id = $this->input->post('idopname');

     if ($selisih >0) {
        $selisih = '-'.$selisih;
    }else{
        $selisih = $stokNyata - $stok;
    }
    
    $nilai = $selisih * $harga;

    $data = array(
      'ID_BARANG'    => htmlspecialchars($this->input->post('iditem'), true),
      'STOK'         => $stok,
      'STOK_NYATA'   => $stokNyata,
      'SELISIH'      => $selisih,
      'NILAI'        => $nilai,
      'KETERANGAN'   => htmlspecialchars($this->input->post('keterangan'), true),
      'TANGGAL'      => date('Y-m-d H:i:s'),
      'ID_USER'      => $this->session->userdata('id_user')
    );
    return $this->db->set($data)
      ->where($this->primary, $id)
      ->update($this->table);
  }

  public function Delete($id)
  {
    return $this->db->where($this->primary, $id)->delete($this->table);
  }

  public function Detail($id)
  {
    $sql = "SELECT a.id_stok_opname, b.kode_barang, b.barcode, b.nama_barang, a.stok, a.stok_nyata, a.selisih,  
	    a.keterangan, b.id_barang, b.harga_beli, a.tanggal, a.nilai FROM stok_opname a, barang b WHERE a.id_barang = b.id_barang AND a.id_stok_opname = '$id'";
    return $this->db->query($sql)->row_array();
  }
}
