<?php date_default_timezone_set("Asia/Bangkok"); ?>

		<?php cek_user() ?>
		<div class="right_col" role="main">
		  <div class="">
		    <div class="page-title">
		      <div class="title_left">
		        <h3><?php echo $title ?></h3>
		      </div> 
		    </div>
		    <div class="clearfix"></div> 
		    <div class="row"> 
		      <div class="col-md-12 col-sm-12 col-xs-12"> 
		        <div class="x_panel"> 
		          <div class="x_title">
		            <?php include 'inputitem.php' ?>
		            <button type="button" class="btn btn-sm btn-primary" onclick="tambahitem()" title="Tambah Data" id="tambahkaryawan"><i class="fa fa-plus"></i> Tambah Data</button>
		            <button type="button" class="btn btn-sm btn-default" onclick="importExcel()" title="Import Data" id="importExcel"><i class="fa fa-upload"></i> Import Excel</button> 
		            
		            <button onclick="reset()" class="btn btn-danger btn-sm" title="Reset Stok"><i class="fa fa-minus-circle"> Reset All Stok</i></button>

		            <ul class="nav navbar-right panel_toolbox">
		              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		              </li>
		              <li><a class="close-link"><i class="fa fa-close"></i></a>
		              </li>
		            </ul>
		            <div class="clearfix"></div>
		          </div>
		          <div class="x_content">
		            <?php echo $this->session->flashdata('message'); ?>
		            <table width="100%" class="table table-striped table-bordered datatable">
		              <thead>
		                <tr>
		                  <th>Kode Item</th>
		                  <th>Barcode</th>
		                  <th>Nama Item</th>
		                  <th>Satuan</th>
		                  <th>Kategori</th>
		                  <th>Harga beli </th>
		                 <!-- <th>Harga  -->
		                  <th>Stok</th>
		                  <th width="70">Opsi</th>
		                </tr>
		              </thead>
		              <tbody>
		                <?php foreach ($item as $i) { ?>
		                  <tr>
		                    <td><?php echo $i['KODE_BARANG'] ?></td>
		                    <td><?php echo $i['BARCODE'] ?></td>
		                    <td>
		                      <?php echo $i['NAMA_BARANG'] ?>
		                     
		                    </td>
		                    <td><?php echo $i['SATUAN'] ?></td>
		                    <td><?php echo $i['KATEGORI'] ?></td>
		                    <td><?php echo $i['HARGA_BELI'] ?></td>
		                    <!-- <td><?php echo $i['HARGA_JUAL'] ?></td>  -->
		                    <td><?php echo $i['STOK'] ?></td>
		                    <td>
		                      <a href="<?php echo base_url('barang/edit/') . encrypt_url($i['ID_BARANG']) ?>" class="btn btn-primary btn-xs" title="Edit Data"><i class="fa fa-edit"></i></a>
		                      <a href="#" class="btn btn-danger btn-xs" title="Hapus Data" onclick="hapusbarang('<?php echo $i['ID_BARANG'] ?>')"><i class="fa fa-trash "></i></a>
		                    </td>
		                  </tr>
		                <?php } ?>
		              </tbody>
		            </table>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<?php include 'import.php' ?>

<script type="text/javascript">
	function tambahitem() {
		$('#inputDataBarang').modal('show');
	}

	function importExcel() {
		$('#importBarang').modal('show');
	}

	function hapusbarang(e) {
		Swal.fire({
			title: "Are you sure ?", 
			text: "Deleted data can not be restored!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!"
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: base_url + "barang/hapusbarang/" + e,
					type: "post",
					success: function (data) {
						window.location = base_url + "barang/index"
					}
				})
			}
		})
	}

	function reset() {
		Swal.fire({
			title: "Are you sure ?", 
			text: "Reset all stock",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!"
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: base_url + "barang/reset/",
					type: "post",
					success: function (data) {
						window.location = base_url + "barang/index"
					}
				})
			}
		})
	}

</script>