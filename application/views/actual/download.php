<!DOCTYPE html>
<html>
<head>
<style>

 body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #e2e2e2;
        font-size: small;
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 10mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
    }
    
    @page {
        size: A4;
        margin: 0;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #000000;
  text-align: left;
  padding: 8px;
}

 /* Designing all grid */
.grid-container {
    display: inline-grid;
    grid-template-columns: 30% 70%;
    width: 100%;
}

</style>
</head>
<body>

<div class='html-content'>
<div class="book">
    <div class="page">

    	<table style="margin-bottom: 1%;">
          
    	<tr>
    		<td colspan="8" style="border: none; padding: 0;">
			    <div class="grid-container">
			    <img style="margin-left: 70%; margin-top: -10%;" width="100" src="<?php echo base_url('assets/img/profil/PAPIRAAA.png') ?>">
			    <div align="center">
			    	<div style="margin-left: -10%">
			    		<span style="font-size: 30px; font-weight: bold;">PAPIRA</span><br/>
			    		<span><b>Website :-/ E-Mail : -</b></span><br/>
			    		<span><b>Jln. Sultan Agung No. Telp. / Fax : - / -</b></span>
			    	</div>
			    </div>
				</div>
    		</td>
    	</tr>
		    
    	<tr>
    		<td colspan="8" style="border: none; padding: 0;">
    			<hr style="border-style: solid; border-width: 2px;">
    			<hr style="border-style: solid; margin-top: -6px;">
    		</td>
    	</tr>

		<tr>
			<td colspan="8" style="border: none; padding: 0;">
				<h2 align="center">LAPORAN DATA STOK ACTUAL BARANG</h2>
				<h4 align="center">Periode : 2022-03-10 s/d 2022-03-12</h4>
			</td>
		</tr>
		
		<tr>
			<th colspan="8"><center>SHIFT - 1</center></th>
		</tr>
		<tr>
			<td colspan="8" style="border: none; padding: 0;"></td>
		</tr>

		<?php for ($d = $awal; $d <= $akhir; $d->modify('+1 day')):?>

		<tr style="background: #009b4c;color: white;;"><th colspan="8"><center><?php echo $d->format("d / m / Y") ?></center></th></tr>

		<?php foreach ($kategori_data as $kat): ?>
			
		  <tr><th colspan="8"><?php echo strtoupper($kat['KATEGORI']) ?></th></tr>
		  <tr>
		  	<th>NO</th>
		    <th width="100">TGL</th>
		    <th>BARCODE</th>
		    <th>NAMA ITEM</th>
		    <th>STOK</th>
		    <th>ACTUAL</th>
		    <th>SELISIH</th>
		    <th>USER</th>
		  </tr>

		  <?php $i = 1; ?>

		  <?php foreach ($barang_data as $bar): ?>

		  <?php if ($kat['ID_KATEGORI'] == $bar['ID_KATEGORI']): ?>
		  	
		  <tr>
		  	<td><?php echo $i ?></td>
		  	<td><?php echo $d->format("d / m / Y") ?></td>
		  	<td>-</td>
		  	<td><?php echo $bar['NAMA_BARANG'] ?></td>
		  	<td><?= ($bar['opname_stok_actual'] != '' && date($bar['opname_tanggal_actual']) == $d->format("Y-m-d"))? $bar['opname_stok']:$bar['STOK'] ?></td>
		  	<td><?= ($bar['opname_stok_actual'] != '' && date($bar['opname_tanggal_actual']) == $d->format("Y-m-d"))? $bar['opname_stok_actual']:'0' ?></td>
		  	<td><?= ($bar['opname_stok_selisih'] != '' && date($bar['opname_tanggal_actual']) == $d->format("Y-m-d"))? $bar['opname_stok_selisih']:'0' ?></td>
		  	<td><?= ($bar['NAMA_LENGKAP'] != '' && date($bar['opname_tanggal_actual']) == $d->format("Y-m-d"))? $bar['NAMA_LENGKAP']:'-' ?></td>
		  </tr>

		  <?php $i++ ?>

		  <?php endif ?>

		  <?php endforeach ?>

		<?php endforeach ?>

		<?php endfor ?>  

		</table>  
    
    </div>
</div>
</div>

</body>

</html>

<!-- <script src="<?php echo base_url('assets/htmlpdf/jquery-3.6.0.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/htmlpdf/jspdf.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/htmlpdf/html2canvas.js') ?>"></script>

<script type="text/javascript">

    var HTML_Width = $(".html-content").width();
    var HTML_Height = $(".html-content").height();
    var top_left_margin = 15;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas($(".html-content")[0]).then(function (canvas) {
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        for (var i = 1; i <= totalPDFPages; i++) { 
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }

        pdf.save("stokopname.pdf")
        
    });

</script> -->