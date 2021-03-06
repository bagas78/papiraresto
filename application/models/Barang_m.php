<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_m extends CI_Model
{

    protected $table = 'barang'; 
    protected $primary = 'id_barang';

    public function getAllData() 
    {
        if ($this->session->userdata('tipe') == 'Gudang') {
            $sql = "SELECT a.ID_BARANG, a.KODE_BARANG, a.BARCODE ,a.NAMA_BARANG, a.IS_BAHAN_BAKU, b.SATUAN, c.KATEGORI, a.HARGA_BELI, 
        a.HARGA_JUAL, a.STOK, a.ACTUAL, a.ACTUAL_TANGGAL FROM barang a LEFT JOIN satuan b ON b.ID_SATUAN = a.ID_SATUAN LEFT JOIN kategori c ON c.ID_KATEGORI = a.ID_KATEGORI WHERE a.IS_ACTIVE = 1 AND a.is_bahan_baku = 1";
        } else if ($this->session->userdata('tipe') == 'Kasir') {
            $sql = "SELECT a.ID_BARANG, a.KODE_BARANG, a.BARCODE ,a.NAMA_BARANG, a.IS_BAHAN_BAKU, b.SATUAN, c.KATEGORI, a.HARGA_BELI, 
        a.HARGA_JUAL, a.STOK, a.ACTUAL, a.ACTUAL_TANGGAL FROM barang a LEFT JOIN satuan b ON b.ID_SATUAN = a.ID_SATUAN LEFT JOIN kategori c ON c.ID_KATEGORI = a.ID_KATEGORI WHERE a.IS_ACTIVE = 1 AND a.is_bahan_baku = 0";
        } else {
            $sql = "SELECT a.ID_BARANG, a.KODE_BARANG, a.BARCODE ,a.NAMA_BARANG, a.IS_BAHAN_BAKU, b.SATUAN, c.KATEGORI, a.HARGA_BELI, 
        a.HARGA_JUAL, a.STOK, a.ACTUAL, a.ACTUAL_TANGGAL FROM barang a LEFT JOIN satuan b ON b.ID_SATUAN = a.ID_SATUAN LEFT JOIN kategori c ON c.ID_KATEGORI = a.ID_KATEGORI WHERE a.IS_ACTIVE = 1";
        }
        return $this->db->query($sql)->result_array();
    }

    public function Save()
    {
        $this->db->select("RIGHT (barang.kode_barang, 5) as kode_barang", false);
        $this->db->order_by("kode_barang", "DESC");
        $this->db->limit(1);
        $query = $this->db->get('barang');

        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode_barang) + 1;
        } else {
            $kode = 1;
        }
        $kodebrg = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodebarang = "BRG-" . $kodebrg;
        $data = array(
            'KODE_BARANG'   => $kodebarang,
            'BARCODE'       => htmlspecialchars($this->input->post('barcode'), true),
            'NAMA_BARANG'   => htmlspecialchars($this->input->post('namabarang'), true),
            'ID_KATEGORI'   => htmlspecialchars($this->input->post('kategori'), true),
            'ID_SATUAN'     => htmlspecialchars($this->input->post('satuan'), true),
            'ID_SUPPLIER'   => htmlspecialchars($this->input->post('supplier'), true),
            'STOK_MINIMAL'  => htmlspecialchars($this->input->post('minimal'), true),
            'HARGA_BELI'    => htmlspecialchars($this->input->post('beli'), true),
            'HARGA_JUAL'    => htmlspecialchars($this->input->post('jual'), true),
            'STOK'          => htmlspecialchars($this->input->post('stok'), true),
            'IS_ACTIVE'     => 1,
            'IS_BAHAN_BAKU' => 1
        );
        return $this->db->insert($this->table, $data);
    }

    public function Edit()
    {
        $id = $this->input->post('iditem');
        $data = array(
            'BARCODE'        => htmlspecialchars($this->input->post('barcode'), true),
            'NAMA_BARANG'   => htmlspecialchars($this->input->post('namabarang'), true),
            'ID_KATEGORI'   => htmlspecialchars($this->input->post('kategori'), true),
            'ID_SATUAN'     => htmlspecialchars($this->input->post('satuan'), true),
            'ID_SUPPLIER'   => htmlspecialchars($this->input->post('supplier'), true),
            'HARGA_BELI'    => htmlspecialchars($this->input->post('beli'), true),
            'HARGA_JUAL'    => htmlspecialchars($this->input->post('jual'), true),
            'STOK'    => htmlspecialchars($this->input->post('stok'), true),
        );
        return $this->db->set($data)
            ->where($this->primary, $id)
            ->update($this->table);
    }

    public function Delete($id)
    {
        return $this->db->set(array('is_active' => 0))
            ->where($this->primary, $id)
            ->update($this->table);
    }

    public function Detail($id) 
    {
        return $this->db->query("SELECT * FROM menu WHERE ID_BARANG = '$id'")->row_array();
    }

     public function Detail_barang($id) 
    {
        return $this->db->query("SELECT * FROM barang WHERE ID_BARANG = '$id'")->row_array();
    }

    public function Search($key)
    {
        return $this->db->get_where($this->table, ['barcode' => $key])->row_array();
    }

    public function getStokHabis()
    {
        $sql = "SELECT a.ID_BARANG, a.KODE_BARANG, a.BARCODE ,a.NAMA_BARANG, b.SATUAN, c.KATEGORI,
        a.STOK FROM barang a LEFT JOIN satuan b ON b.ID_SATUAN = a.ID_SATUAN LEFT JOIN kategori c ON c.ID_KATEGORI = a.ID_KATEGORI WHERE a.is_active = 1 AND a.STOK < 5 AND a.is_bahan_baku = 1 ORDER BY a.STOK ASC";
        return $this->db->query($sql)->result_array();
    }

    public function Save_operasional()
    {
        $harga = $this->input->post('harga');
        $jml = $this->input->post('jml');
        $nilai = $jml * $harga;
        $id = $this->input->post('iditem');
        $data = array(
            'id_barang'       => htmlspecialchars($id, true),
            'jml'             => htmlspecialchars($jml, true),
            'nilai'           => $nilai,
            'tanggal'         => date('Y-m-d H:i:s'),
            'jenis'           => 'Operasional',
        );
        $this->db->insert('barang_operasional', $data);
        $sqlstok = "select stok from barang where id_barang = '$id'";
        $stok = implode($this->db->query($sqlstok)->row_array());
        $hasil = $stok - $jml;
        $update = "update barang set stok = '$hasil' where id_barang = '$id'";
        $this->db->query($update);
    }

    public function loadOperasional()
    {
        $sql = "SELECT d.id_brg_operasional, a.barcode, a.nama_barang, d.jenis, d.nilai, d.tanggal, d.jml, c.satuan, b.kategori FROM  barang a, kategori b, satuan c, barang_operasional d
        WHERE a.id_satuan = c.id_satuan AND a.id_kategori = b.id_kategori AND d.id_barang = a.id_barang AND d.jenis = 'Operasional'";
        return $this->db->query($sql)->result_array();
    }

    public function loadkeluar($tgl = '')
    {
        // $this->db->join('satuan', 'barang.ID_SATUAN = satuan.ID_SATUAN');
        // $this->db->order_by('barang.NAMA_BARANG', 'ASC');
        // return $this->db->get('barang')->result_array();

        if ($tgl == '') {
            $date = date('Y-m-d');
        } else {
            $date = date($tgl);
        }

        
        $sql = "SELECT *, SUM(a.jml) AS total FROM barang_operasional AS a JOIN barang AS b ON a.id_barang = b.ID_BARANG JOIN satuan AS c ON b.ID_SATUAN = c.ID_SATUAN WHERE DATE_FORMAT(a.tanggal, '%Y-%m-%d') = '$date' GROUP BY a.id_barang";
        return $this->db->query($sql)->result_array();
    }

    public function Save_keluar()
    {
        $harga = $this->input->post('harga');
        $jml = $this->input->post('jml');
        $nilai = $jml * $harga;
        $id = $this->input->post('iditem');
        $data = array(
            'id_barang'       => htmlspecialchars($id, true),
            'jml'             => htmlspecialchars($jml, true),
            'nilai'           => $nilai,
            'tanggal'         => date('Y-m-d H:i:s'),
            'jenis'           => 'Barang Keluar',
        );

        $sqlstok = "select stok from barang where id_barang = '$id'";
        $stok = implode($this->db->query($sqlstok)->row_array());

        if ($stok >= $jml) {

            $this->db->insert('barang_operasional', $data);


            //kurangi stok
            $hasil = $stok - $jml;
            $update = "update barang set stok = '$hasil' where id_barang = '$id'";
            $this->db->query($update);

            return 1;
        } else {


            return 0;
        }
    }
}
