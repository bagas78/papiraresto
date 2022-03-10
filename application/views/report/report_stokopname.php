<?php
include 'report_header.php';
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 5, 'LAPORAN DATA STOK ACTUAL BARANG', 0, 1, 'C');
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 7, 'Periode : ' . $awal . ' s/d ' . $akhir, 0, 1, 'C');


$this->db->where('KATEGORI_IS_BARANG', 1);
$kategori = $this->db->get('kategori')->result_array();


$pdf->Cell(189, 10, 'SHIFT - 1', 1, 1, 'C');

$alpha = 'A';
$pdf->Cell(0, 1, '', 0, 1, 'C');
foreach ($kategori as $k) {
    $this->db->select('barang.ID_BARANG, barang.BARCODE, barang.NAMA_BARANG');
    $this->db->where('barang.IS_ACTIVE', 1);
    $this->db->where('barang.ID_KATEGORI', $k['ID_KATEGORI']);
    $this->db->order_by('barang.NAMA_BARANG', 'ASC');
    $data_1 = $this->db->get('barang')->result_array();

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Times', 'B', 10);
    $pdf->Cell(189, 8, strtoupper($alpha++ . '. ' . $k['KATEGORI']), 1, 1);

    $pdf->SetFont('Times', 'B', 8);
    $pdf->Cell(7, 6, 'NO', 1, 0, 'C');
    $pdf->Cell(30, 6, 'TGL', 1, 0, 'C');
    $pdf->Cell(25, 6, 'BARCODE', 1, 0, 'C');
    $pdf->Cell(58, 6, 'NAMA ITEM', 1, 0, 'C');
    $pdf->Cell(11, 6, 'STOK', 1, 0, 'C');
    $pdf->Cell(18, 6, 'ACTUAL', 1, 0, 'C');
    $pdf->Cell(15, 6, 'SELISIH', 1, 0, 'C');
    $pdf->Cell(25, 6, 'USER', 1, 1, 'C');

    $i = 1;
    foreach ($data_1 as $d) {
        
        $this->db->select('stok_opname.*, user.*, barang.BARCODE, barang.NAMA_BARANG');
        $this->db->join('barang', 'stok_opname.ID_BARANG = barang.ID_BARANG', 'LEFT');
        $this->db->join('user', 'stok_opname.ID_USER = user.ID_USER', 'LEFT');
        $this->db->group_start();
        $this->db->where('DATE(TANGGAL) >=', $awal);
        $this->db->where('DATE(TANGGAL) <=', $akhir);
        $this->db->where('stok_opname.SHIFT', 1);
        $this->db->group_end();
        $this->db->where('barang.IS_ACTIVE', 1);
        $this->db->where('barang.ID_BARANG', $d['ID_BARANG']);
        $this->db->group_by('stok_opname.ID_BARANG');
        $data_stock_opname = $this->db->get('stok_opname')->row_array();
        
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(7, 6, $i++, 1, 0, 'C');
        $pdf->Cell(30, 6, @$data_stock_opname['TANGGAL'] ? date('d/m/Y H:i', strtotime($data_stock_opname['TANGGAL'])) : date('d/m/Y', strtotime($awal)), 1, 0, 'C');
        $pdf->Cell(25, 6, $d['BARCODE'], 1, 0, 'C');
        $pdf->Cell(58, 6, $d['NAMA_BARANG'], 1, 0);
        
        $stok_kemarin = 0;
        $stok_sekarang = @$data_stock_opname['STOK_NYATA'];

        if(@$data_stock_opname['ID_STOK_OPNAME']){
            
            $this->db->where('ID_BARANG', $d['ID_BARANG']);
            $this->db->where('DATE(TANGGAL)', date('Y-m-d', strtotime($data_stock_opname['TANGGAL'] . ' -1 days')));
            $this->db->where('SHIFT', '1');
            $stok_opname_kemarin = $this->db->get('stok_opname')->row_array();
            $stok_kemarin = @$stok_opname_kemarin['STOK_NYATA'] ?? 0;
            
            $this->db->select('SUM(racikan.racikan_jumlah) as TOTAL');
            $this->db->join('penjualan', 'detil_penjualan.ID_JUAL = penjualan.ID_JUAL');
            $this->db->join('menu', 'detil_penjualan.ID_BARANG = menu.ID_BARANG');
            $this->db->join('racikan', 'menu.ID_BARANG = racikan.racikan_menu');
            $this->db->where('racikan.racikan_barang', $d['ID_BARANG']);
            $this->db->where('DATE(penjualan.TGL)', date('Y-m-d', strtotime($data_stock_opname['TANGGAL'])));
            $this->db->group_by('racikan.racikan_barang');
            $stok_jual = $this->db->get('detil_penjualan')->row_array()['TOTAL'] ?? 0;
            
            $this->db->select('SUM(detil_pembelian.QTY_BELI) as TOTAL');
            $this->db->join('pembelian', 'detil_pembelian.ID_BELI = pembelian.ID_BELI');
            $this->db->where('detil_pembelian.ID_BARANG', $d['ID_BARANG']);
            $this->db->where('DATE(pembelian.TGL_FAKTUR)', date('Y-m-d', strtotime($data_stock_opname['TANGGAL'])));
            $this->db->group_by('detil_pembelian.ID_BARANG');
            $stok_beli = $this->db->get('detil_pembelian')->row_array()['TOTAL'] ?? 0;
            
            $stok_kemarin = ($stok_kemarin - $stok_jual) + $stok_beli;
        }else{
            $this->db->where('ID_BARANG', $d['ID_BARANG']);
            $this->db->where('DATE(TANGGAL)', date('Y-m-d', strtotime($awal . ' -1 days')));
            $this->db->where('SHIFT', '1');
            $stok_opname_kemarin = $this->db->get('stok_opname')->row_array();
            $stok_kemarin = @$stok_opname_kemarin['STOK_NYATA'] ?? 0;
        }
        
        if($stok_kemarin > $stok_sekarang){
            $stok = $stok_kemarin - $stok_sekarang;
            $stok = '-'.$stok;
        }else{
            $stok = $stok_sekarang - $stok_kemarin;
        }
        
        if($info_user['TIPE'] == 'Administrator' && !$data_stock_opname){
            $pdf->Cell(11, 6, '', 1, 0, 'R');
        }else{
            $pdf->Cell(11, 6, $stok_kemarin, 1, 0, 'R');
        }
        
        $pdf->Cell(18, 6, @$data_stock_opname['STOK_NYATA'], 1, 0, 'R');
        $pdf->Cell(15, 6, $data_stock_opname ? $stok : '', 1, 0, 'R');
        $pdf->Cell(25, 6, @$data_stock_opname['NAMA_LENGKAP'], 1, 0, 'C');

        $pdf->Cell(30, 6, '', 0, 1);
    }
    $pdf->Cell(0, 2, '', 0, 1, 'C');
}

$pdf->Output('laporan_stokOpname.pdf', 'I');
