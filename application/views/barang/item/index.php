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
		                  <th>Actual</th>
		                  <th>Selisih</th>
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

		                    <!-- data opname -->
		                    <?php $tanggal = date('Y-m-d'); $id_barang = $i['ID_BARANG']; $op = $this->db->query("SELECT * FROM t_opname WHERE opname_tanggal_actual = '$tanggal' AND opname_barang = '$id_barang'")->row_array(); ?>

		                    <td><?= (@$op['opname_stok_actual'])? @$op['opname_stok_actual']:'0' ?></td>
		                    <td><?= (@$op['opname_stok_selisih'])? @$op['opname_stok_actual'] - $i['STOK'] : '0' ?></td>
		                    <td>
		                      <button onclick="modal_actual(<?=(@$op['opname_stok_actual'] != '')? @$op['opname_id'] : "'".$i['NAMA_BARANG']."'" ?>,<?php echo $i['ID_BARANG'] ?>)" class="btn btn-success btn-xs"><i class="fa fa-th"></i></button>

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

<!-- modal input -->
<div class="modal fade in" id="modal-input">
  <div class="modal-dialog bs-example-modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Input Actual Stok</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" action="<?php echo base_url('actual/save_barang') ?>">
          <input type="hidden" name="stok">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="date" class="form-control" name="tanggal" id="tanggal" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Barang</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" name="barang" id="barang" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Actual Stok</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="number" class="form-control" name="actual" id="actual" required autocomplete="off">
            </div>
          </div>

          <!--hidden-->
          <input type="hidden" name="id_barang" id="id_barang">
          <input type="hidden" name="id_actual" id="id_actual">

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function modal_actual(id,id_barang){

    //reset value
    $('input').val('');

    console.log(typeof id);

    if (typeof id == 'number') {

      $.ajax({
        url: '<?php echo base_url('actual/get_data') ?>',
        type: 'POST',
        dataType: 'json',
        data: {id: id},
      })
      .done(function(response) {

        //barang axist
        $('#tanggal').val(response['tanggal_opname']);
        $('#barang').val(response['NAMA_BARANG']);
        $('#actual').val(response['opname_stok_actual']);
        $('#id_barang').val(id_barang);
        $('#id_actual').val(id);
        $('#modal-input').modal('toggle');
      });

    }else{
      //barang non exist
      $('#tanggal').val('<?php echo date('Y-m-d') ?>');
      $('#barang').val(id);
      $('#id_barang').val(id_barang);
      $('#modal-input').modal('toggle');
    }

  }
</script>

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

</script>