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
              <form action="<?php echo base_url('actual') ?>" method="POST">
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
                    <!-- <th width="20%">SHIFT - 2</th> -->
                    <?php if ($current == date('Y-m-d')): ?>
                      <th>Opsi</th>
                    <?php endif ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($opname as $o): ?>
                    <?php
                    $current_date = @$current;
                    $date = date_create($o['opname_tanggal']); 
                    $tanggal = date_format($date,'Y-m-d');
                    $jam = date_format($date,'h:i');
                    ?>
                    <tr>
                      <td><?php echo date('d / m / Y', strtotime($_GET['date'] ?? $current)) ?></td>
                      <td><?php echo $o['KODE_BARANG'] ?></td>
                      <td><?php echo $o['NAMA_BARANG'] ?></td>

                      <?php if ($current_date == $tanggal): ?>
                        <td style="background: <?= ($o['opname_stok_actual'] < 1)?'#fba27740;':'#9efb7740;' ?> border: 1px; solid black; color: black;">
                      <?php else: ?>
                        <td style="background: #fba27740; border: 1px; solid black; color: black;">
                      <?php endif ?>


                        <table width="100%">
                          <tr style="border-bottom: 1px solid black;">
                            <th width="20%">Actual</th>
                            <td width="5%">:</td>

                            <?php if ($current_date == $tanggal): ?>
                              <td><?= ($o['opname_stok_actual'] < 1)?'0': $o['opname_stok_actual'] ?></td>
                            <?php else: ?>
                              <td>0</td>
                            <?php endif ?>
                            
                          </tr>
                          <tr style="border-bottom: 1px solid black;">
                            <th width="20%">User</th>
                            <td width="5%">:</td>

                            <?php if ($current_date == $tanggal): ?>
                              <td><?= ($o['opname_stok_actual'] < 1)?'-': $o['USERNAME'] ?></td>
                            <?php else: ?>
                              <td>-</td>
                            <?php endif ?>

                          </tr>
                          <tr style="border-bottom: 1px solid black;">
                            <th width="20%">Jam</th>
                            <td width="5%">:</td>

                            <?php if ($current_date == $tanggal): ?>
                              <td><?= ($o['opname_stok_actual'] < 1)?'-': $jam ?></td>
                            <?php else: ?>
                              <td>-</td>
                            <?php endif ?>

                          </tr>
                        </table>
                      </td>

                    <?php if ($current == date('Y-m-d')): ?>
                      <td class="text-center">
                        <button onclick="modal_actual(<?=($o['opname_stok_actual'] != '')? $o['opname_id'] : "'".$o['NAMA_BARANG']."'" ?>,<?php echo $o['ID_BARANG'] ?>)" class="btn btn-primary btn-xs btn-input" title="Edit Data" ><i class="fa fa-edit"></i> Shift - 1</button>
                      </td>
                    <?php endif ?>
                      
                    </tr>

                  <?php endforeach; ?>
                </tbody>
              </table>
              
              <br><br><br>
                            
              <?php if(!@$_GET['date'] || (@$_GET['date'] == date('Y-m-d'))) : ?>
                            
              <?php if (!$this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Stok'])->num_rows()) : ?>
                <button type="button" class="btn btn-block btn-success btn-finish"><h4>Finish Actual Tanggal :  <?php echo date_format(date_create($current), 'd / m / Y'); ?>, &nbsp;SHIFT - 1 ( Satu )</h4></button>
              <?php endif; ?>

              <?php if ($this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Stok', 'SHIFT' => 1])->num_rows()) : ?>
                <button type="button" class="btn btn-block btn-success btn-finish"><h4>Finish Actual Tanggal :  <?php echo date_format(date_create($current), 'd / m / Y'); ?>, &nbsp;SHIFT - 2 ( Dua )</h4></button>
              <?php endif; ?>
              
              <?php endif; ?>
              
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


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
            <form class="form-horizontal" method="post" action="<?php echo base_url('actual/save') ?>">
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