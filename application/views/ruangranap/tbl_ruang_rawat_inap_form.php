<div class="content-wrapper">
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA RUANG RAWAT INAP</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post"> 
				<table class='table table-bordered'>    
					<tr>
				    	<td width='200'>Kode Ruang Rawat Inap <?php echo form_error('kode_ruang_rawat_inap') ?></td>
				    	<td><input type="text" class="form-control" name="kode_ruang_rawat_inap" id="kode_ruang_rawat_inap" placeholder="Kode Ruang Rawat Inap" value="<?php echo $kode_ruang_rawat_inap; ?>" /></td>
				    </tr>   
				    <tr>
				    	<td width='200'>Nama Ruangan <?php echo form_error('nama_ruangan') ?></td>
				    	<td>
				    		<input type="text" class="form-control" name="nama_ruangan" id="nama_ruangan" placeholder="Nama Ruangan" value="<?php echo $nama_ruangan; ?>" />
				    	</td>
				    </tr>
				    <tr>
				    	<td width='200'>Nama Gedung <?php echo form_error('kode_gedung_rawat_inap') ?></td>
				    	<td>
							<?= cmb_dinamis('kode_gedung_rawat_inap', 'tbl_gedung_rawat_inap', 'nama_gedung', 'kode_gedung_rawat_inap', $kode_gedung_rawat_inap);?>
				    		<!--<input type="text" class="form-control" name="kode_gedung_rawat_inap" id="kode_gedung_rawat_inap" placeholder="Kode Gedung Rawat Inap" value="<?php echo $kode_gedung_rawat_inap; ?>" />-->
				    	</td>
				    </tr>
				    <tr>
				    	<td width='200'>Kelas <?php echo form_error('kelas') ?></td>
				    	<td>
							<?= form_dropdown('kelas', array('VIP' => 'VIP','Kelas 1' => 'Kelas 1','Kelas 2' => 'Kelas 2','Kelas 3' => 'Kelas 3'), $kelas, 'class="form-control"');?>
				    		<!--<input type="text" class="form-control" name="kelas" id="kelas" placeholder="Kelas" value="<?php echo $kelas; ?>" />-->
				    	</td>
				    </tr>
				    <tr>
				    	<td width='200'>Tarif <?php echo form_error('tarif') ?></td>
				    	<td><input type="text" class="form-control" name="tarif" id="tarif" placeholder="Tarif" value="<?php echo $tarif; ?>" /></td>
				    </tr>
				    <tr>
				    	<td></td>
				    	<td><!--<input type="hidden" name="kode_ruang_rawat_inap" value="<?php echo $kode_ruang_rawat_inap; ?>" />--> 
						    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
						    <a href="<?php echo site_url('ruangranap') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td>
					</tr>
				</table>
			</form>        
		</div>
	</section>
</div>