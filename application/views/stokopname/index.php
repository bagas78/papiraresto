	<?php cek_user() ?>
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<!--<h3><?php echo $title ?></h3>-->
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<form action="">
								<div class="row">
									<div class="col-md-3">
										<input type="date" name="date" class="form-control" value="<?php echo @$_GET['date'] ?? date('Y-m-d') ?>">
									</div>
									<div class="col-md-3">
										<button class="btn btn-default" type="submit">Cari</button>
									</div>
								</div>
							</form>

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
										<th>Tanggal</th>
										<th>Kode Brg</th>
										<th>Nama Item</th>
										<th width="20%">SHIFT - 1</th>
										<th width="20%">SHIFT - 2</th>
										<th>Opsi</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($opname as $o) { ?>
										<?php
										$current_date = @$_GET['date'] ?? date('Y-m-d');

										$this->db->join('user', 'stok_opname.ID_USER = user.ID_USER', 'LEFT');
										$this->db->where('ID_BARANG', $o['ID_BARANG']);
										$this->db->where('DATE(TANGGAL)', $current_date);
										$this->db->where('SHIFT', 1);
										$stok_opname_1 = $this->db->get('stok_opname')->row_array();

										$this->db->join('user', 'stok_opname.ID_USER = user.ID_USER', 'LEFT');
										$this->db->where('ID_BARANG', $o['ID_BARANG']);
										$this->db->where('DATE(TANGGAL)', $current_date);
										$this->db->where('SHIFT', 2);
										$stok_opname_2 = $this->db->get('stok_opname')->row_array();
										?>
										<tr>
											<td style="vertical-align: middle; border-bottom: 1px solid black;"><?php echo date('d / m / Y', strtotime($_GET['date'] ?? date('Y-m-d'))) ?></td>
											<td style="vertical-align: middle; border-bottom: 1px solid black;"><?php echo $o['KODE_BARANG'] ?></td>
											<td style="vertical-align: middle; border-bottom: 1px solid black;"><?php echo $o['NAMA_BARANG'] ?></td>
											<td style="background: <?php echo $stok_opname_1 ? '#9efb7740' : '#fba27740' ?>; border: 1px solid black; color: black;">
												<table width="100%">
													<tr style="border-bottom: 1px solid black;">
														<th width="20%">Actual</th>
														<td width="5%">:</td>
														<td><?php echo $stok_opname_1 ? $stok_opname_1['STOK_NYATA'] : '0' ?></td>
													</tr>
													<tr style="border-bottom: 1px solid black;">
														<th>User</th>
														<td>:</td>
														<td><?php echo $stok_opname_1 ? $stok_opname_1['NAMA_LENGKAP'] : '-' ?></td>
													</tr>
													<tr>
														<th>Jam</th>
														<td>:</td>
														<td><?php echo $stok_opname_1 ? date('H:i', strtotime($stok_opname_1['TANGGAL'])) : '-' ?></td>
													</tr>
												</table>
											</td>
											<td style="background: <?php echo $stok_opname_2 ? '#9efb7740' : '#fba27740' ?>; border: 1px solid black; color: black;">
												<table width="100%">
													<tr style="border-bottom: 1px solid black;">
														<th width="20%">Actual</th>
														<td width="5%">:</td>
														<td><?php echo $stok_opname_2 ? $stok_opname_2['STOK_NYATA'] : '0' ?></td>
													</tr>
													<tr style="border-bottom: 1px solid black;">
														<th>User</th>
														<td>:</td>
														<td><?php echo $stok_opname_2 ? $stok_opname_2['NAMA_LENGKAP'] : '-' ?></td>
													</tr>
													<tr>
														<th>Jam</th>
														<td>:</td>
														<td><?php echo $stok_opname_2 ? date('H:i', strtotime($stok_opname_2['TANGGAL'])) : '-' ?></td>
													</tr>
												</table>
											</td>
											<td class="text-center" style="vertical-align: middle; border-bottom: 1px solid black;">
												<?php if (date('Y-m-d') == $current_date && !$this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Stok'])->num_rows()) : ?>
													<a href="javascript:void(0)" class="btn btn-primary btn-xs btn-input" title="Edit Data" data-ID_BARANG="<?php echo $o['ID_BARANG'] ?>" data-NAMA_BARANG="<?php echo $o['NAMA_BARANG'] ?>" data-HARGA_JUAL="<?php echo $o['HARGA_JUAL'] ?>" data-ID_STOK_OPNAME="<?php echo @$stok_opname_1['ID_STOK_OPNAME'] ?>" data-STOK="<?php echo @$stok_opname_1['STOK'] ? $stok_opname_1['STOK'] : $o['STOK'] ?>" data-STOK_NYATA="<?php echo @$stok_opname_1['STOK_NYATA'] ?? 0 ?>"><i class="fa fa-edit"></i> Shift - 1</a>
												<?php endif; ?>

												<?php if (date('Y-m-d') == $current_date && $this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Stok', 'SHIFT' => 1])->num_rows()) : ?>
													<a href="javascript:void(0)" class="btn btn-primary btn-xs btn-input" title="Edit Data" data-ID_BARANG="<?php echo $o['ID_BARANG'] ?>" data-NAMA_BARANG="<?php echo $o['NAMA_BARANG'] ?>" data-HARGA_JUAL="<?php echo $o['HARGA_JUAL'] ?>" data-ID_STOK_OPNAME="<?php echo @$stok_opname_2['ID_STOK_OPNAME'] ?>" data-STOK="<?php echo @$stok_opname_2['STOK'] ? $stok_opname_2['STOK'] : $o['STOK'] ?>" data-STOK_NYATA="<?php echo @$stok_opname_2['STOK_NYATA'] ?? 0 ?>"><i class="fa fa-edit"></i> Shift - 2</a>
												<?php endif; ?>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
							
							<br><br><br>
                            
                            <?php if(!@$_GET['date'] || (@$_GET['date'] == date('Y-m-d'))) : ?>
                            
							<?php if (!$this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Stok'])->num_rows()) : ?>
								<button type="button" class="btn btn-block btn-success btn-finish"><h4>Finish Actual Tanggal :  <?php echo date('d / m / Y') ?>, &nbsp;SHIFT - 1 ( Satu )</h4></button>
							<?php endif; ?>

							<?php if ($this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Stok', 'SHIFT' => 1])->num_rows()) : ?>
								<button type="button" class="btn btn-block btn-success btn-finish"><h4>Finish Actual Tanggal :  <?php echo date('d / m / Y') ?>, &nbsp;SHIFT - 2 ( Dua )</h4></button>
							<?php endif; ?>
							
							<?php endif; ?>
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade in" id="modal-input">
		<div class="modal-dialog bs-example-modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Input Actual Stok</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" action="" id="form-input">
						<input type="hidden" name="stok">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo @$_GET['date'] ?? date('Y-m-d') ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Barang</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
								<input type="hidden" name="idopname">
								<input type="hidden" class="form-control" name="iditem" id="iditem" readonly>
								<input type="hidden" class="form-control" name="harga" id="harga" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Actual Stok</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="number" class="form-control" name="nyata" id="nyata" required autocomplete="off">
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
	</div>


	<!-- <script src="<?php echo base_url('assets/Javascript/mod-stokopname.js') ?>"></script>
	<?php include 'showdata.php' ?> -->


	<script>
		$(document).ready(function() {
			$('.btn-input').click(function() {

				$('#form-input [name="idopname"]').val($(this).data('id_stok_opname'));
				$('#form-input [name="iditem"]').val($(this).data('id_barang'));
				$('#form-input [name="namabarang"]').val($(this).data('nama_barang'));
				$('#form-input [name="harga"]').val($(this).data('harga_jual'));
				$('#form-input [name="stok"]').val($(this).data('stok'));
				$('#form-input [name="nyata"]').val($(this).data('stok_nyata'));

				if ($(this).data('id_stok_opname')) {
					var url = base_url + 'stokopname/update/' + $(this).data('id_stok_opname');
				} else {
					var url = base_url + 'stokopname/create';
				}
				$('#form-input').attr('action', url);

				$('#modal-input').modal('show');
			})

			$('.btn-finish').click(function() {
				Swal.fire({
					title: "PERINGATAN",
					text: "Pastikan inputan actual sudah benar, karena data sudah tidak bisa diedit lagi ! ",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Oke, Yakin"
				}).then((result) => {
					if (result.value) {
						window.location.href = base_url + "stokopname/finish_actual/";
					}
				})
			})
		})
	</script>