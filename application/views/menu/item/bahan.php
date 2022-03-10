 <div class="modal fade" id="modal-racikan">
 	<div class="modal-dialog modal-lg">
 		<div class="modal-content">
 			<div class="modal-header">
 				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
 				</button>
 				<h4 class="modal-title" id="inputDataBarang">Resep <span id="bahan_nama"></span></h4>
 			</div>
 			<div class="modal-body">
 				<form class="form-horizontal" method="post" action="<?php echo base_url('menu/save_racikan') ?>">
 					
 					<input type="hidden" id="id_menu" name="id_menu" value="">

 					<div id="racikan_data"> 					
     					<table class="table datatable-racikan">
     					<thead>
                            <tr>
                                <th>Bahan</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
     					<tbody>
     					<?php $jum = 0; ?>
     					<?php foreach ($barang as $bar): ?>
     				        <tr>
     					        <td><?php echo $bar['NAMA_BARANG'] ?></td>
     					        <td>
     					            <input type="hidden" name="racikan_barang[]" value="<?php echo $bar['ID_BARANG'] ?>">
     					            <input type="number" class="form-control" id="<?php echo $bar['ID_BARANG'] ?>" name="racikan_jumlah[]" value="0">
     					        </td>
     					        <td>
     					            <input type="text" class="form-control" value="<?php echo $bar['SATUAN'] ?>" readonly>
     					        </td>
     					    </tr>
     					<?php $jum++; ?>
     					<?php endforeach ?>
     					</tbody>
                        </table>
 					</div>

 					<input type="hidden" name="foreach" value="<?php echo $jum ?>">

 					<div class="modal-footer">
 						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 						<button type="submit" class="btn btn-primary">Save changes</button>
 					</div>
 				</form>
 			</div>
 		</div>
 	</div>
 </div>