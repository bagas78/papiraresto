<?php cek_user()?>
		 <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $title?></h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!--<a href="<?php echo base_url('barang/input_barang_keluar')?>" class="btn btn-sm btn-primary" title="Tambah Data" id=""><i class="fa fa-plus"></i> Tambah Data</a>-->
                    <form action="">
                        <input type="date" name="date" value="<?php echo @$_GET['date'] ?? date('Y-m-d') ?>" required>
                        <button type="submit">Cari</button>
                        <button type="button" onclick="window.location.href='<?php echo base_url('report/barang_bahan_keluar'.@$SERVER['QUERY_STRING']) ?>'">PDF</button>
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
                          <th>Barcode</th>
                          <th>Nama Item</th>
                          <th>Satuan</th>
                          <th class="text-center" width="10%">Jumlah Keluar</th>
                          <!--<th>Nilai</th>-->
                          <!--<th>Jenis</th> -->
                          <th class="text-center">Tanggal</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach($load as $d){?>
                      <?php
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
                      ?>
                        <?php if($racikan) : ?>
                        <tr>
                          <td><?php echo $d['BARCODE']?></td>
                          <td><?php echo $d['NAMA_BARANG']?></td>
                          <td><?php echo $d['SATUAN']?></td>
                          <td class="text-right"><?php echo $racikan['TOTAL'] ?? 0 ?></td>
                          <td class="text-center"><?php echo date('d/m/Y', strtotime($racikan['TGL'])) ?></td>
                        </tr>
                        <?php endif; ?>
                       <?php }?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include 'Js.php'?>
