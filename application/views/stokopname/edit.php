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
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<form class="form-horizontal" method="post" action="<?php echo base_url('stokopname/update') ?>">
							<div class="form-group">
								<input type="hidden" class="form-control" name="idopname" id="idopname" readonly value="<?php echo $opname['id_stok_opname'] ?>">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Cari Barang/Product</label>
								<div class="input-group">
									<input type="text" class="form-control" name="barcode" id="barcode" autofocus value="<?php echo $opname['barcode'] ?>" autocomplete="off">
									<span class="input-group-btn">
										<button type="button" onclick="tampildata()" class="btn btn-primary"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Barang</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="namabarang" id="namabarang" readonly value="<?php echo $opname['nama_barang'] ?>">
									<input type="hidden" class="form-control" name="iditem" id="iditem" readonly value="<?php echo $opname['id_barang'] ?>">
									<input type="hidden" class="form-control" name="harga" id="harga" readonly value="<?php echo $opname['harga_beli'] ?>">
								</div>
							</div>
							<div class="form-group">
								<!--<label class="control-label col-md-3 col-sm-3 col-xs-12">Stok</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
						  <input type="text" class="form-control" name="stok" id="stok" required readonly value="<?php echo $opname['stok'] ?>">
						</div>
					  </div>-->
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Stok Nyata</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<input type="text" class="form-control" name="nyata" id="nyata" required value="<?php echo $opname['stok_nyata'] ?>" autocomplete="off">
									</div>
								</div>
								<!-- <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Selisih</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
						  <input type="text" class="form-control" name="selisih" id="selisih" required readonly>
						</div>
					  </div> -->
								<!--  <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
						  <textarea col="3" class="form-control" name="keterangan" id="keterangan"><?php echo $opname['keterangan'] ?></textarea>
						</div> -->
							</div>
							<div style="text-align: right">
								<button type="reset" class="btn btn-danger"><i class="fa fa-recycle m-right-xs"></i> Batal</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-edit m-right-xs"></i> Edit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'showdata.php' ?>
<script src="<?php echo base_url('assets/Javascript/mod-stokopname.js') ?>"></script>