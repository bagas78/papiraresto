<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?php echo $title ?></h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php echo $this->session->flashdata('message'); ?>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<h2 style="text-align: right"> Invoice <b id="invoice"></b></h2>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9 col-sm-12 col-xs-12">
								<h1>Total (Rp)</h1>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12">
								<h1 style="text-align: right" id="subtot"> 0</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form class="form-horizontal" method="post" action="<?php echo base_url('penjualan/simpanpenjualan') ?>">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('d/m/Y') ?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control" name="idoperator" id="idoperator" readonly value="<?php echo $user['ID_USER'] ?>">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Operator</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<!-- <input type="hidden" class="form-control" name="operator" id="operator" readonly value="<?php echo $user['NAMA_LENGKAP'] ?>"> -->
									<select id="karyawan" name="karyawan" class="form-control select2" required>
										<?php foreach ($karyawan as $k) : ?>
											<option value="<?php echo $k['ID_KARYAWAN'] ?>"><?php echo $k['NAMA_KARYAWAN'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Customer</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<select id="customer" name="customer" class="form-control select2" required>



										<?php foreach ($customer as $c) : ?>
											<option value="<?php echo $c['ID_CS'] ?>"><?php echo $c['NAMA_CS'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>



				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="form-group">
								<input type="hidden" class="form-control" name="idbarangitem" id="idbarangitem" readonly>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Menu</label>
								<div class="input-group">
									<input type="text" class="form-control" name="barcode" id="barcode" autofocus autocomplete="off" onkeypress="scanBarcode()">
									<span class="input-group-btn">
										<button type="button" onclick="tampildata()" class="btn btn-primary"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Qty</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="qty" id="qty" autocomplete="off">
								</div>
							</div>
							<div style="text-align: right">
								<button type="button" onclick="addItemByClick()" class="btn btn-success btn-sm"><i class="fa fa-shopping-cart m-right-xs"></i> Tambah</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Menu</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="namaitem" id="namaitem" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Harga</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="harga" id="harga">
									<span class="error" id="error-harga" style="color: red; display: none;"></span>
								</div>
							</div>
							
							<div class="form-group">
				             <label class="control-label col-md-3 col-sm-3 col-xs-12">Diskon</label>
				             <div class="col-md-9 col-sm-9 col-xs-12">
				               <select id="diskon" class="form-control">
				                 <option value="0">Tidak ada</option>
				                 <?php foreach ($diskon as $dis): ?>
				                   <option value="<?php echo $dis['diskon_persen'] ?>"><?php echo $dis['diskon_nama'] ?></option>
				                 <?php endforeach ?>
				               </select>

				             </div>
				           </div>
				           
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<table id="detilitem" width="100%" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Barcode</th>
										<th>Nama Item</th>
										<th>Harga</th>
										<th>Qty</th>
										<th>Disc / Item</th>
										<th>Total</th>
										<th>Opsi</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
						</div>
						<div class="x_content">
							<div style="text-align: right" class="pt-3">
								<button type="reset" class="btn btn-danger"><i class="fa fa-recycle m-right-xs"></i> Cancel</button>
								<button type="button" onclick="simpanPenjualan()" class="btn btn-primary"><i class="fa fa-paper-plane-o m-right-xs"></i> Payment</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include 'showdata.php' ?>
<?php include 'editdetil.php' ?>
<?php include 'checkout.php' ?>

<script type="text/javascript">

function tampildata() {

	$('#daftarbarang').DataTable({
		"bProcessing": true,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"sAjaxSource": base_url + 'menu/LoadData',
		"sAjaxDataProp": "aaData", 
		"fnRender": function (oObj) {
			uss = oObj.aData["Username"];
		},
		"aoColumns": [{
			"mDataProp": "BARCODE",
			bSearchable: true   
		},
		{
			"mDataProp": "NAMA_BARANG",
			bSearchable: true
		},
		{ 
			"mDataProp": "SATUAN",
			bSearchable: true
		},
		{
			"mDataProp": "HARGA_JUAL",
			bSearchable: true
		},
		{
			"mDataProp": function (data, type, val) {
				pKode = data.ID_BARANG;
			
				var btn = '<a href="#" id="pilihitem" class="btn btn-primary btn-xs" data-dismiss="modal" title="Pilih Data" onclick="pilihbarang(' + pKode + ')"><i class="fa fa-check-square-o"></i> Select</a>';

				return (btn).toString();
			},
			bSortable: false,
			bSearchable: false
		}
		],
		"bDestroy": true,
	});

	$('#showDataModal').modal('show');
}

function pilihbarang(e) {
	$.ajax({
		url: base_url + "barang/detilmenu/" + e,
		type: "post",
		success: function (data) {
			var obj = JSON.parse(data);
			$('#harga').val(obj.HARGA_JUAL);
			$('#namaitem').val(obj.NAMA_BARANG);
			$('#idbarangitem').val(obj.ID_BARANG);

		}
	})
}

function addItemByClick() {
	var diskon = $('#diskon').val();

	var qty = $('#qty').val();
	var harga = $('#harga').val();
	var subtotal = qty * harga;
	var id = $('#idbarangitem').val();
	var barcode = document.getElementById('barcode');

	if (qty == "") {
		alert('Field Tidak Boleh Kosong!')
	} else {
		$.ajax({
			url: base_url + "penjualan/tambahbarang/" + id + '/' + qty + '/' + subtotal + '/' + harga + '/' + diskon,
			type: "post",
			success: function (response) {
				var res = JSON.parse(response);
				if (res.status === 'success') {
					var obj = res.data;
					LoadItemBarang();
					barcode.value = "";
					barcode.focus();
					document.getElementById('qty').value = "";

					var ppn = obj.SUBTOTAL * 10 / 100;
					var hargaAkhir = ppn + Number(obj.SUBTOTAL);
					
					$('#subtotal').val(obj.SUBTOTAL);
					$('#grandtotal').val(obj.SUBTOTAL);
					// $('#nominal_ppn').val(ppn);
					$('#nominal').val(obj.SUBTOTAL);
					$("#error-harga").hide();
				} else {
					console.log();
					//error
					$('#error-harga').text(res.message);
					$('#error-harga').show();
				}
			}
		});
	}
}

function addItemByScan() {
	var qty = 1;
	var harga = $('#harga').val();
	var subtotal = qty * harga;
	var id = $('#idbarangitem').val();
	var barcode = document.getElementById('barcode');

	$.ajax({
		url: base_url + "penjualan/tambahbarang/" + id + '/' + qty + '/' + subtotal + '/' + harga,
		type: "post",
		success: function (response) {
			var res = JSON.parse(response);
			if (res.status === 'success') {
				var obj = res.data;
				LoadItemBarang();
				barcode.value = "";
				barcode.focus();
				document.getElementById('qty').value = "";
				var ppn = obj.subtotal * 10 / 100;
				var hargaAkhir = ppn + Number(obj.subtotal);
				$('#subtot').html(obj.subtotal);
				$('#subtotal').val(obj.subtotal);
				$('#grandtotal').val(obj.subtotal);
				// $('#nominal_ppn').val(ppn);
				$('#nominal').val(obj.subtotal);
				$("#error-harga").hide();
			} else {
				console.log();
				//error
				$('#error-harga').text(res.message);
				$('#error-harga').show();
			}

		}
	});
}

function LoadItemBarang() {
	$('#detilitem').DataTable({
		"bProcessing": true,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"sAjaxSource": base_url + 'penjualan/LoadData',
		"sAjaxDataProp": "aaData",
		"fnRender": function (oObj) {
			uss = oObj.aData["Username"];
		},
		"aoColumns": [{
			"mDataProp": "barcode",
			bSearchable: true
		},
		{
			"mDataProp": "nama_barang",
			bSearchable: true
		},
		{
			"mDataProp": "harga_jual",
			bSearchable: true
		},
		{
			"mDataProp": "qty_jual",
			bSearchable: true
		},
		{
			"mDataProp": "diskon",
			bSearchable: true
		},
		{
			"mDataProp": "subtotal",
			bSearchable: true
		},
		{
			"mDataProp": function (data, type, val) {

				pKode = data.id_detil_jual;

				var btn = '<a href="#" class="btn btn-primary btn-xs" title="Edit Data" onclick="editDetilItem(' + pKode + ')"><i class="fa fa-edit"></i></a> \n\ <a href="#" class="btn btn-danger btn-xs" title="Hapus Data" onclick="hapusDetilItem(' + pKode + ')"><i class="fa fa-trash "></i></a>';

				return (btn).toString();
			},
			bSortable: false,
			bSearchable: false
		}
		],
		"bDestroy": true,
	});

	//hitung sub total
	$.getJSON(base_url + 'penjualan/LoadData', function(i) {
		
		var data = i['aaData'];

		var subtot = 0;

		$.each(data, function(index) {
			 subtot += parseInt(data[index].subtotal);
		});

		$('#subtot').text(subtot);

	});
}

function editDetilItem(e) {
	var qty = $('#detilqty');
	var diskon = $('#detildiskonitem');
	var subtotal = $('#detiltotalitem');
	$.ajax({
		url: base_url + "penjualan/detilitemjualmenu/" + e,
		type: "post",
		success: function (data) {
			var obj = JSON.parse(data);
			$('#iddetiljual').val(obj.id_detil_jual);
			$('#iddetilbarang').val(obj.id_barang);
			$('#editdetilbarcode').val(obj.barcode);
			$('#namadetilitem').val(obj.nama_barang);
			$('#hargadetilitem').val(obj.harga_jual);
			$('#detilqty').val(obj.qty_jual);
			$('#hideqty').val(obj.qty_jual);
			$('#detildiskonitem').val(obj.diskon);
			$('#detiltotalitem').val(obj.subtotal);

		}
	});
	$('#editDetilModal').modal('show');
}

function hapusDetilItem(e) {
	Swal.fire({
		title: "Kamu Yakin ?",
		text: "Data Ini Akan di Hapus",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "YES"
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: base_url + "penjualan/hapusdetil/" + e,
				type: "post",
				success: function (data) {
					LoadItemBarang();
					var obj = JSON.parse(data);
					var ppn = obj.subtotal * 10 / 100;
					var hargaAkhir = ppn + Number(obj.subtotal);
					if (obj.subtotal != null) {
						$('#subtot').text(obj.subtotal);
					} else {
						$('#subtot').text(0);
					}
				}
			})
		}
	})
}

function editDetilJual() {
	var id = $('#iddetiljual').val();
	var harga = $('#hargadetilitem').val();
	var qty = $('#detilqty').val();
	var qty1 = $('#hideqty').val();
	var diskon = $('#detildiskonitem').val();
	var subtotal = $('#detiltotalitem').val();
	var idBrg = $('#iddetilbarang').val();
	$.ajax({
		url: base_url + "penjualan/editdetiljual/" + id + '/' + harga + '/' + diskon + '/' + qty + '/' + subtotal,
		type: "post",
		success: function (data) {
			var stok = qty1 - qty;
			updateStok(stok, idBrg);
			LoadItemBarang();
			$.ajax({
				url: base_url + "penjualan/hargatotal",
				type: "post",
				success: function (response) {
					var res = JSON.parse(response);
					console.log(res);
					if (res.status === 'success') {
						var obj = res.data;
						var ppn = obj.subtotal * 10 / 100;
						var hargaAkhir = ppn + Number(obj.subtotal);
						$('#subtot').html(obj.subtotal);
						$('#subtotal').val(obj.subtotal);
						$('#grandtotal').val(obj.subtotal);
						$('#diskon1').val(obj.diskon);
					} else {
						//alert(res.message);
					}


				}
			});
		}
	});
}

function updateStok(stok, id) {
	$.ajax({
		url: base_url + "barang/updateStok/" + stok + '/' + id,
		type: "post",
		success: function (data) {

		}
	});
}

function simpanPenjualan() {
	var cs = $('#customer').val();
	var kary = $('#karyawan').val();
	var user = $('#idoperator').val();
	$('#cus').val(cs);
	$('#kary').val(kary);
	$('#kasir').val(user);
	$.ajax({
		url: base_url + "penjualan/hargatotal",
		type: "post",
		success: function (data) {
			var obj = JSON.parse(data);
			var ppn = obj.subtotal * 10 / 100;
			var hargaAkhir = ppn + Number(obj.subtotal);
			$('#diskon1').val(obj.diskon);
			$('#subtot').html(obj.subtotal);
			$('#subtotal').val(obj.subtotal);
			$('#grandtotal').val(obj.subtotal);
			// $('#nominal_ppn').val(ppn);
			$('#nominal').val(obj.subtotal);

		}
	});
	$('#pembayaranModal').modal('show');
}

function editPenjualan() {
	$('#editPembayaranModal').modal('show');
}

function detilJual(e) {
	$('#detilPenjualanModal').modal('show');
}

function scanBarcode() {
	var key = $('#barcode');
	$.ajax({
		url: base_url + "barang/caribarang/" + key.val(),
		type: "post",
		success: function (data) {
			var obj = JSON.parse(data);
			$('#harga').val(obj.HARGA_JUAL);
			$('#namaitem').val(obj.NAMA_BARANG);
			$('#idbarangitem').val(obj.ID_BARANG);
			$('#kodebrg').val(obj.KODE_BARANG);
			addItemByScan();
		}
	})
}


$(document).ready(function () {
	LoadItemBarang();
});
    
</script>
