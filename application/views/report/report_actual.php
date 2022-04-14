<?php
include 'report_header.php';
$pdf->SetFont('Times', 'B', 14); 
$pdf->Cell(0, 5, 'LAPORAN DATA STOK ACTUAL BARANG', 0, 1, 'C');
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 7, 'Periode : ' . $awal . ' s/d ' . $akhir, 0, 1, 'C');

$pdf->Cell(189, 10, 'SHIFT - 1', 1, 1, 'C'); 
 
$in = 1;

for ($d = new DateTime($awal); $d <= new DateTime($akhir); $d->modify('+1 day')){

    if ($in == 1) {

        $alpha = 1;

        foreach ($kategori_data as $kat) {

            $pdf->Cell(0, 1, '', 0, 1, 'C');
             
            //kategori 
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Times', 'B', 10);
            $pdf->Cell(189, 8, strtoupper($alpha++ . '. ' . $kat['KATEGORI']), 1, 1);
         
            //header
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
            foreach ($barang_data as $bar) {

                if ($kat['ID_KATEGORI'] == $bar['ID_KATEGORI']){

                    //body
                    $pdf->SetFont('Times', '', 9);
                    $pdf->Cell(7, 6, $i, 1, 0, 'C');
                    $pdf->Cell(30, 6, $d->format("d / m / Y"), 1, 0, 'C');
                    $pdf->Cell(25, 6, '-', 1, 0, 'C');
                    $pdf->Cell(58, 6, $bar['NAMA_BARANG'], 1, 0);

                    $ok = '';
                    foreach ($opname_data as $op) {

                        $dt = date_create($op['opname_tanggal']);

                        if (date_format($dt, 'Y-m-d') == $d->format("Y-m-d") && $bar['ID_BARANG'] == $op['opname_barang']) {
                            // ada 
                            $pdf->Cell(11, 6, $op['opname_stok'], 1, 0, 'R');       
                            $pdf->Cell(18, 6, $op['opname_stok_actual'], 1, 0, 'R');

                            $pdf->Cell(15, 6, $op['opname_stok_selisih'], 1, 0, 'R');

                            $pdf->Cell(25, 6, $op['NAMA_LENGKAP'], 1, 0, 'C');

                            $ok = 1;
                        }
                    }

                    if ($ok != 1) {
                        //tidak ada
                        $pdf->Cell(11, 6, $bar['STOK'], 1, 0, 'R');       
                        $pdf->Cell(18, 6, ' ', 1, 0, 'R');

                        $pdf->Cell(15, 6, ' ', 1, 0, 'R');

                        $pdf->Cell(25, 6, ' ', 1, 0, 'C');
                    }

                    $pdf->Cell(30, 6, '', 0, 1);

                    $i++;
                }
            }

        }

        $pdf->Cell(0, 2, '', 0, 1, 'C');

    }

$in ++;

}

//download PDF
$pdf->Output('laporan_stokOpname.pdf', 'I');
