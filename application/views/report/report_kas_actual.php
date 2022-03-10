<?php
include 'report_header.php';
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 5, 'LAPORAN DATA ACTUAL KAS', 0, 1, 'C');
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 7, 'Periode : ' . $awal . ' s/d ' . $akhir, 0, 1, 'C');

$this->db->join('user', 'kas_actual.ID_USER = user.ID_USER', 'LEFT');
$this->db->where('DATE(TANGGAL) >=', $awal);
$this->db->where('DATE(TANGGAL) <=', $akhir);
$this->db->where('SHIFT', 1);
$this->db->order_by('TANGGAL', 'ASC');
$data_1 = $this->db->get('kas_actual')->result_array();

$this->db->join('user', 'kas_actual.ID_USER = user.ID_USER', 'LEFT');
$this->db->where('DATE(TANGGAL) >=', $awal);
$this->db->where('DATE(TANGGAL) <=', $akhir);
$this->db->where('SHIFT', 2);
$this->db->order_by('TANGGAL', 'ASC');
$data_2 = $this->db->get('kas_actual')->result_array();


$total_nominal = 0;
$total_selisih = 0;


$pdf->Cell(187, 8, 'SHIFT - 1', 1, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(7, 6, 'NO', 1, 0, 'C');
$pdf->Cell(50, 6, 'Tanggal', 1, 0, 'C');
$pdf->Cell(30, 6, 'NOMINAL', 1, 0, 'C');
$pdf->Cell(30, 6, 'ACTUAL', 1, 0, 'C');
$pdf->Cell(30, 6, 'SELISIH', 1, 0, 'C');
$pdf->Cell(40, 6, 'USER', 1, 0, 'C');

$pdf->Cell(30, 6, '', 0, 1, 'C');
$i = 1;
foreach ($data_1 as $d) {

    $total_nominal += $d['NOMINAL'];
    $total_selisih += $d['SELISIH'];

    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(7, 6, $i++, 1, 0, 'C');
    $pdf->Cell(50, 6, date('d/m/Y H:i', strtotime($d['TANGGAL'])), 1, 0);
    $pdf->Cell(30, 6, number_format($d['NOMINAL'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, 6, number_format($d['NOMINAL_NYATA'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, 6, number_format($d['SELISIH'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(40, 6, $d['NAMA_LENGKAP'], 1, 0);

    $pdf->Cell(30, 6, '', 0, 1);
}

$pdf->Cell(30, 8, '', 0, 1);
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(187, 8, 'SHIFT - 2', 1, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(7, 6, 'NO', 1, 0, 'C');
$pdf->Cell(50, 6, 'Tanggal', 1, 0, 'C');
$pdf->Cell(30, 6, 'NOMINAL', 1, 0, 'C');
$pdf->Cell(30, 6, 'ACTUAL', 1, 0, 'C');
$pdf->Cell(30, 6, 'SELISIH', 1, 0, 'C');
$pdf->Cell(40, 6, 'USER', 1, 0, 'C');

$pdf->Cell(30, 6, '', 0, 1, 'C');
$i = 1;
foreach ($data_2 as $d) {

    $total_nominal += $d['NOMINAL'];
    $total_selisih += $d['SELISIH'];

    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(7, 6, $i++, 1, 0, 'C');
    $pdf->Cell(50, 6, date('d/m/Y H:i', strtotime($d['TANGGAL'])), 1, 0);
    $pdf->Cell(30, 6, number_format($d['NOMINAL'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, 6, number_format($d['NOMINAL_NYATA'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, 6, number_format($d['SELISIH'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(40, 6, $d['NAMA_LENGKAP'], 1, 0);

    $pdf->Cell(30, 6, '', 0, 1);
}

$pdf->SetFont('Times', '', 10);

$pdf->Cell(40, 6, '', 0, 1, 'C');

$pdf->Cell(136, 6, 'TOTAL : ', 0, 0, 'R');
$pdf->Cell(11, 6, 'Rp.', 1, 0, 'C');
$pdf->Cell(41, 6, number_format($total_nominal, 0, ',', '.'), 1, 1, 'R');

$pdf->Cell(136, 6, 'SELISIH : ', 0, 0, 'R');
$pdf->Cell(11, 6, 'Rp.', 1, 0, 'C');
$pdf->Cell(41, 6, number_format($total_selisih, 0, ',', '.'), 1, 1, 'R');



$pdf->Output('laporan_kas_actual.pdf', 'I');
