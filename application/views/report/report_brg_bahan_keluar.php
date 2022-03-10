<?php
include 'report_header.php';

$awal = $this->input->get('date') ?? date('Y-m-d');

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 5, 'LAPORAN DATA BAHAN BAKU KELUAR', 0, 1, 'C');
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 7, 'Periode : ' . $awal . ' s/d ' .  $awal, 0, 1, 'C');

$this->db->join('satuan', 'barang.ID_SATUAN = satuan.ID_SATUAN');
$this->db->order_by('barang.NAMA_BARANG', 'ASC');
$result = $this->db->get('barang')->result_array();

    $pdf->Cell(0, 1, '', 0, 1, 'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Times', 'B', 10);
    
    $pdf->Cell(30, 10,  'BARCODE', 1, 0, 'C');
    $pdf->Cell(78, 10, 'NAMA ITEM', 1, 0, 'C');
    $pdf->Cell(30, 10, 'SATUAN', 1, 0, 'C');
    $pdf->Cell(25, 10, 'JML KELUAR', 1, 0, 'C');
    $pdf->Cell(25, 10, 'TANGGAL', 1, 1, 'C');
    
    $i = 1;
    foreach ($result as $d) {
        $pdf->SetFont('Times', '', 9);
        
        $this->db->select('barang.*, satuan.*, penjualan.TGL, SUM(racikan.racikan_jumlah) as TOTAL');
        $this->db->join('penjualan', 'detil_penjualan.ID_JUAL = penjualan.ID_JUAL');
        $this->db->join('menu', 'detil_penjualan.ID_BARANG = menu.ID_BARANG');
        $this->db->join('racikan', 'menu.ID_BARANG = racikan.racikan_menu');
        $this->db->join('barang', 'racikan.racikan_barang = barang.ID_BARANG');
        $this->db->join('satuan', 'barang.ID_SATUAN = satuan.ID_SATUAN');
        $this->db->where('racikan.racikan_barang', $d['ID_BARANG']);
        $this->db->where('DATE(penjualan.TGL)', $this->input->get('date') ?? date('Y-m-d'));
        $this->db->group_by('racikan.racikan_barang');
        $racikan = $this->db->get('detil_penjualan')->row_array();  
    
        if($racikan){
            $pdf->Cell(30, 6, $d['BARCODE'], 1, 0, 'L');
            $pdf->Cell(78, 6, $d['NAMA_BARANG'], 1, 0, 'L');
            $pdf->Cell(30, 6, $d['SATUAN'], 1, 0, 'L');
            $pdf->Cell(25, 6, $racikan['TOTAL'] ?? 0, 1, 0, 'R');
            $pdf->Cell(25, 6, date('d/m/Y', strtotime($racikan['TGL'])), 1, 1, 'C');
        }
    }

$pdf->Output('laporan_bahan_baku_keluar.pdf', 'I');
