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
                        <form action="">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="month" name="month" class="form-control" value="<?php echo @$_GET['month'] ?? date('Y-m') ?>">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-default" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="x_content">
                        <?php echo $this->session->flashdata('message'); ?>
                        <table width="100%" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tanggal</th>
                                    <th width="30%">SHIFT - 1</th>
                                    <th width="30%">SHIFT - 2</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $last = date('t', strtotime(@$_GET['month'] ?? date('Y-m')));
                                ?>
                                <?php for ($i = 1; $i <= $last; $i++) : ?>
                                    <?php
                                    $current_date = @$_GET['month'] ? $_GET['month'] . '-' . $i : date('Y-m') . '-' . $i;
                                    $current_date = date('Y-m-d', strtotime($current_date));

                                    $this->db->select('SUM(NOMINAL) as TOTAL');
                                    $this->db->where('DATE(TANGGAL)', $current_date);
                                    $this->db->where('JENIS', 'Pemasukan');
                                    $kas = $this->db->get('kas')->row_array();

                                    $this->db->join('user', 'kas_actual.ID_USER = user.ID_USER', 'LEFT');
                                    $this->db->where('DATE(TANGGAL)', $current_date);
                                    $this->db->where('SHIFT', 1);
                                    $kas_actual_1 = $this->db->get('kas_actual')->row_array();

                                    $this->db->join('user', 'kas_actual.ID_USER = user.ID_USER', 'LEFT');
                                    $this->db->where('DATE(TANGGAL)', $current_date);
                                    $this->db->where('SHIFT', 2);
                                    $kas_actual_2 = $this->db->get('kas_actual')->row_array();
                                    ?>
                                    <tr>
                                        <td style="vertical-align: middle;"><?php echo $i ?></td>
                                        <td style="vertical-align: middle;"><?php echo date('d / m / Y', strtotime($current_date)) ?></td>
                                        <td>
                                            <table width="100%">
                                                <tr style="border-bottom: 1px solid black;">
                                                    <th width="20%">Actual</th>
                                                    <td width="5%">:</td>
                                                    <td>Rp. <?php echo $kas_actual_1 ? number_format($kas_actual_1['NOMINAL_NYATA'], 0, ',', '.') : '0' ?></td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid black;">
                                                    <th>User</th>
                                                    <td>:</td>
                                                    <td><?php echo $kas_actual_1 ? $kas_actual_1['NAMA_LENGKAP'] : '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jam</th>
                                                    <td>:</td>
                                                    <td><?php echo $kas_actual_1 ? date('H:i', strtotime($kas_actual_1['TANGGAL'])) : '-' ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table width="100%">
                                                <tr style="border-bottom: 1px solid black;">
                                                    <th width="20%">Actual</th>
                                                    <td width="5%">:</td>
                                                    <td>Rp. <?php echo $kas_actual_2 ? number_format($kas_actual_2['NOMINAL_NYATA'], 0, ',', '.') : '0' ?></td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid black;">
                                                    <th>User</th>
                                                    <td>:</td>
                                                    <td><?php echo $kas_actual_2 ? $kas_actual_2['NAMA_LENGKAP'] : '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jam</th>
                                                    <td>:</td>
                                                    <td><?php echo $kas_actual_2 ? date('H:i', strtotime($kas_actual_2['TANGGAL'])) : '-' ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <?php if ($kas['TOTAL'] && date('Y-m-d') == $current_date && !$this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Kas'])->num_rows()) : ?>
                                                <a href="javascript:void(0)" class="btn btn-primary btn-xs btn-input" title="Edit Data" data-ID_KAS_ACTUAL="<?php echo @$kas_actual_1['ID_KAS_ACTUAL'] ?>" data-NOMINAL="<?php echo @$kas_actual_1['NOMINAL'] ? $kas_actual_1['NOMINAL'] : $kas['TOTAL'] ?>" data-NOMINAL_NYATA="<?php echo @$kas_actual_1['NOMINAL_NYATA'] ?>" data-TANGGAL="<?php echo $current_date ?>"><i class="fa fa-edit"></i> Shift - 1</a>
                                            <?php endif; ?>

                                            <?php if ($kas['TOTAL'] && date('Y-m-d') == $current_date && $this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Kas', 'SHIFT' => 1])->num_rows()) : ?>
                                                <a href="javascript:void(0)" class="btn btn-primary btn-xs btn-input" title="Edit Data" data-ID_KAS_ACTUAL="<?php echo @$kas_actual_2['ID_KAS_ACTUAL'] ?>" data-NOMINAL="<?php echo @$kas_actual_2['NOMINAL'] ? $kas_actual_2['NOMINAL'] : ($kas['TOTAL'] - $kas_actual_1['NOMINAL']) ?>" data-NOMINAL_NYATA="<?php echo @$kas_actual_2['NOMINAL_NYATA'] ?>" data-TANGGAL="<?php echo $current_date ?>"><i class="fa fa-edit"></i> Shift - 2 </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                        </table>

                        <?php if (!$this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Kas'])->num_rows()) : ?>
                            <button type="button" class="btn btn-success btn-finish">Finish Actual Tanggal : &nbsp; <?php echo date('d / m / Y') ?>, Shift - 1</button>
                        <?php endif; ?>

                        <?php if ($this->db->get_where('actual_finish', ['TANGGAL' => date('Y-m-d'), 'JENIS' => 'Actual Kas', 'SHIFT' => 1])->num_rows()) : ?>
                            <button type="button" class="btn btn-success btn-finish">Finish Actual Tanggal : &nbsp; <?php echo date('d / m / Y') ?>, Shift - 2</button>
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
                <h4 class="modal-title">Input Actual Kas</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="" id="form-input">
                    <input type="hidden" name="id_kas_actual">
                    <input type="hidden" name="nominal">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="date" class="form-control" name="tanggal" id="tanggal" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Actual Kas</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" class="form-control" name="nominal_nyata" id="nominal_nyata" required autocomplete="off">
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

<script>
    $(document).ready(function() {
        $('.btn-input').click(function() {
            $('#form-input [name="id_kas_actual"]').val($(this).data('id_kas_actual'));
            $('#form-input [name="tanggal"]').val($(this).data('tanggal'));
            $('#form-input [name="nominal"]').val($(this).data('nominal'));
            $('#form-input [name="nominal_nyata"]').val($(this).data('nominal_nyata'));

            if ($(this).data('id_kas_actual')) {
                var url = base_url + 'kas_actual/update/' + $(this).data('id_kas_actual');
            } else {
                var url = base_url + 'kas_actual/create';
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
                    window.location.href = base_url + "kas_actual/finish_actual/";
                }
            })
        })
    })
</script>