<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="#" class="site_title"><i class="fa fa-shopping-cart"></i> <span>PAPIRA </span></a>
    </div>
    <div class="clearfix"></div>
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="<?php echo base_url('assets/production/') ?>images/user.png" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2><?php echo $user['NAMA_LENGKAP'] ?></h2>
      </div>
    </div>
    <br />
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          <?php if ($user['TIPE'] != 'Administrator' && $user['TIPE'] != 'Owner') : ?>
            <li style="display:none"><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
            <?php else : ?>
            <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
            <?php endif; ?>
            <ul class="nav child_menu">
              <li><a href="<?php echo base_url('dashboard/index') ?>">Dashboard</a></li>
            </ul>
            </li>
            <li><a><i class="fa fa-shopping-cart"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <?php if ($user['TIPE'] != 'Gudang') : ?>
                  <li><a href="<?php echo base_url('penjualan/index') ?>">Input Penjualan</a></li>
                  <li><a href="<?php echo base_url('dpenjualan/index') ?>">Daftar Penjualan</a></li>
                  <li><a href="<?php echo base_url('kas_actual/index') ?>">Kas Actual</a></li>
                <?php endif; ?>

                <?php if ($user['TIPE'] != 'Administrator' && $user['TIPE'] != 'Gudang' && $user['TIPE'] != 'Owner') : ?>
                  <li style="display:none"><a href="<?php echo base_url('pembelian/index') ?>">Entry Pembelian</a></li>
                  <li style="display:none"><a href="<?php echo base_url('dpembelian/index') ?>">Daftar Pembelian</a></li>
                <?php else : ?>
                  <li><a href="<?php echo base_url('pembelian/index') ?>">input Pembelian</a></li>
                  <li><a href="<?php echo base_url('dpembelian/index') ?>">Daftar Pembelian</a></li>
                <?php endif; ?>




                <!-- <li><a href="<?php echo base_url('hutang/index') ?>">Hutang</a></li> -->
                <!-- <li><a href="<?php echo base_url('piutang/index') ?>">Piutang</a></li> -->
              </ul>
            </li>

            <?php if ($user['TIPE'] != 'Administrator' && $user['TIPE'] != 'Gudang' && $user['TIPE'] != 'Owner') : ?>
              <li style="display:none"><a><i class="fa fa-desktop"></i> Master Data <span class="fa fa-chevron-down"></span></a>
              <?php else : ?>
              <li><a><i class="fa fa-desktop"></i> Master Data <span class="fa fa-chevron-down"></span></a>
              <?php endif; ?>
              <ul class="nav child_menu">
               <?php if($user['TIPE'] != 'Gudang') : ?>
              <li><a href="<?php echo base_url('menu/index') ?>">Menu</a></li>
              <?php endif ?>
              <li><a href="<?php echo base_url('diskon/index') ?>">Diskon</a></li>
              <li><a href="<?php echo base_url('barang/index') ?>">Bahan Baku</a></li>
              <li><a href="<?php echo base_url('kategori/index') ?>">Kategori </a></li>
              <li><a href="<?php echo base_url('satuan/index') ?>">Satuan </a></li>
              <ul class="nav child_menu">
               
                  <ul class="nav child_menu">
                    </ul>
                  </ul>
                </li>
                <li><a href="<?php echo base_url('supplier/index') ?>">Data Supplier</a></li>
                <?php if ($user['TIPE'] == 'Administrator') : ?>
                  <li><a href="<?php echo base_url('customer/index') ?>">Data Customer</a></li>
                <?php endif; ?>
                <li><a href="<?php echo base_url('karyawan/index') ?>">Data Karyawan</a></li>
                <!-- <li><a href="<?php //echo base_url('mutasi/index')
                                  ?>">Mutasi Barang</a></li> -->
                <li><a href="<?php echo base_url('stokopname/index') ?>">Actual Stok </a></li>
                <!--<li><a href="<?php echo base_url('barang/barang_operasional') ?>">Barang Operasional</a></li>  -->
                <li><a href="<?php echo base_url('barang/barang_keluar') ?>">Pengeluaran Bahan Baku</a></li>
              </ul>
              </li>
              <?php if ($user['TIPE'] != 'Administrator' && $user['TIPE'] != 'Gudang' && $user['TIPE'] != 'Owner') : ?>

                <li style="display:none"><a><i class="fa fa-money"></i> Keuangan <span class="fa fa-chevron-down"></span></a>
                <?php else : ?>
                  <!-- <li><a><i class="fa fa-money"></i> Keuangan <span class="fa fa-chevron-down"></span></a> -->
                <?php endif; ?>
                <ul class="nav child_menu">
                  <!-- <li><a href="<?php echo base_url('kas/index') ?>">Kas</a></li> -->
                  <!-- <li><a href="<?php echo base_url('ppn/index') ?>">PPN</a></li> -->
                  <!-- <li><a href="<?php echo base_url('bank/index') ?>">Bank</a></li> -->
                </ul>
                </li>

                <?php if ($user['TIPE'] != 'Administrator' && $user['TIPE'] != 'Owner') : ?>
                  <li style="display:none"><a><i class="fa fa-file-text-o"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                  <?php else : ?>
                  <li><a><i class="fa fa-file-text-o"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                  <?php endif; ?>
                  <ul class="nav child_menu">
                    <!--<li><a href="<?php echo base_url('laporan/barang') ?>">Laporan Bahan Baku</a></li>-->
                    <li><a href="<?php echo base_url('laporan/penjualan') ?>">Laporan Penjualan</a></li>
               <!-- <li><a href="<?php echo base_url('laporan/penjualan_perFak') ?>">Penjualan Per-Faktur</a> --></li>
                    <li><a href="<?php echo base_url('laporan/pembelian') ?>">Laporan Pembelian</a></li>
                    <!-- <li><a href="<?php //echo base_url('laporan/mutasi')
                                      ?>">Laporan Mutasi Barang</a></li> -->
                    <li><a href="<?php echo base_url('laporan/stokopname') ?>">Laporan Actual Stok </a></li>
                    <li><a href="<?php echo base_url('laporan/kas_actual') ?>">Laporan Actual Kas </a></li>
                    <!-- <li><a href="<?php echo base_url('laporan/laba_rugi') ?>">Laporan Laba Rugi</a></li> -->
                    <!-- <li><a href="<?php echo base_url('laporan/kas') ?>">Laporan Kas</a></li> -->
                    <!-- <li><a href="<?php echo base_url('laporan/kas_bank') ?>">Laporan Kas Bank</a></li> -->
                    <!-- <li><a href="<?php echo base_url('laporan/barang_operasional') ?>">Laporan Barang Operasional</a></li> -->
            
                    <!-- <li><a href="<?php echo base_url('laporan/hutang') ?>">Laporan Hutang</a></li> -->
                    <!-- <li><a href="<?php echo base_url('laporan/piutang') ?>">Laporan Piutang</a></li> -->
                  </ul>
                  </li>
                  <?php if ($user['TIPE'] != 'Owner'): ?>
                    <li style="display:none"><a><i class="fa fa-user"></i> Management User <span class="fa fa-chevron-down"></span></a>
                    <?php else : ?>
                    <li><a><i class="fa fa-user"></i> Management User <span class="fa fa-chevron-down"></span></a>
                    <?php endif; ?>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('user/index') ?>">Data User</a></li>
                    <!--  <li><a href="<?php echo base_url('userlog/index') ?>">User Log</a></li> -->
                    </ul>
                    </li>
                    <?php if ($user['TIPE'] != 'Administrator' && $user['TIPE'] != 'Gudang' && $user['TIPE'] != 'Owner') : ?>
                      <li style="display:none"><a><i class="fa fa-bar-chart-o"></i> Grafik <span class="fa fa-chevron-down"></span></a>
                      <?php else : ?>
                        <!-- <li><a><i class="fa fa-bar-chart-o"></i> Grafik <span class="fa fa-chevron-down"></span></a> -->
                      <?php endif; ?>
                      <ul class="nav child_menu">
                        <!-- <li><a href="<?php echo base_url('grafik/index') ?>">Grafik</a></li> -->
                      </ul>
                      </li>
                      <?php if ($user['TIPE'] != 'Administrator') : ?>
                        <li style="display:none"><a><i class="fa fa-magic"></i> Tools <span class="fa fa-chevron-down"></span></a>
                        <?php else : ?>
                        <li><a><i class="fa fa-magic"></i> Tools <span class="fa fa-chevron-down"></span></a>
                        <?php endif; ?>
                        <ul class="nav child_menu">
                          <li><a href="<?php echo base_url('barcode/index') ?>">Generate Barcode</a></li>
                          <li><a href="<?php echo base_url('backup/index') ?>">Backup Data</a></li>
                          <!-- <li><a href="<?php echo base_url('applog/index') ?>">Application Log</a></li>-->
                        </ul>
                        </li>
                        <?php if ($user['TIPE'] != 'Administrator') : ?>
                          <li style="display:none"><a><i class="fa fa-gears"></i> Setting <span class="fa fa-chevron-down"></span></a>
                          <?php else : ?>
                          <li><a><i class="fa fa-gears"></i> Setting <span class="fa fa-chevron-down"></span></a>
                          <?php endif; ?>
                          <ul class="nav child_menu">
                            <li><a href="<?php echo base_url('profil/index') ?>">Profil Toko</a></li>
                           <!-- <li><a href="<?php //echo base_url('promo/index')
                                              ?>">Setting Promo</a></li> -->
                          </ul>
                          </li>
        </ul>
      </div>
    </div>

  </div>
</div>