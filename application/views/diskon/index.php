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
           	<button type="button" class="btn btn-sm btn-primary" onclick="modal('<?php echo base_url('diskon/add') ?>')" title="Tambah Data" id="tambahkaryawan"><i class="fa fa-plus"></i> Tambah Data</button>
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
            <table class="table table-striped table-bordered datatable table-responsive">
            	<thead>
            		<tr>
            			<th>Nama Diskon</th>
            			<th>Total Diskon</th>
            			<th width="50">Opsi</th>
            		</tr>
            	</thead>
            	<tbody>
            		<?php foreach ($data as $key): ?>
	            		<tr>
	            			<td><?php echo $key['diskon_nama'] ?></td>
	            			<td><?php echo $key['diskon_persen'].'%' ?></td>
	            			<td>
	            				<button onclick="modal('<?php echo base_url('diskon/edit/'.$key['diskon_id']) ?>','<?php echo $key['diskon_nama'] ?>','<?php echo $key['diskon_persen'] ?>')" class="btn btn-primary btn-xs" title="Edit Data"><i class="fa fa-edit"></i></button>
		                      	<button onclick="hapus('<?php echo $key['diskon_id'] ?>')" class="btn btn-danger btn-xs" title="Hapus Data"><i class="fa fa-trash "></i></button>
	            			</td>
	            		</tr>
            		<?php endforeach ?>
            	</tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

 <div class="modal fade">
 	<div class="modal-dialog">
 		<div class="modal-content">

 			<div class="modal-header">
 				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
 				</button>
 				<h4 class="modal-title">Entry Data Diskon</h4>
 			</div>
 			
 			<form class="form-horizontal" id="url" method="post" accept-charset="utf-8">

 				<div class="modal-body">
 					<div class="form-group">
 						<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Diskon</label>
 						<div class="col-md-9 col-sm-9 col-xs-12">
 							<input required="" type="text" class="form-control" id="diskon_nama" name="diskon_nama" autocomplete="off">
 						</div>
 					</div>
 					<div class="form-group">
 						<label class="control-label col-md-3 col-sm-3 col-xs-12">Total Diskon (%)</label>
 						<div class="col-md-9 col-sm-9 col-xs-12">
 							<input required="" type="number" class="form-control" id="diskon_persen" name="diskon_persen" autocomplete="off">
 						</div>
 					</div>
 				</div>
 				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>

			</form>
 		
 		</div>
 	</div>
 </div>

 <script type="text/javascript">
 	function modal(url ,nama = '',persen = ''){

 		if (nama != '') {
 			$('#diskon_nama').val(nama);
 			$('#diskon_persen').val(persen);
 		}else{
 			$('#diskon_nama').val('');
 			$('#diskon_persen').val('');
 		}

 		$('#url').attr('action', url);
 		$('.modal').modal('toggle');
 	}
 	function hapus(id) {
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
					url: base_url + "diskon/hapus/" + id,
					type: "post",
					success: function (respon) {
						window.location = base_url + "diskon/index";
					}
				})
			}
		})
	}
 </script>