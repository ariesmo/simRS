<div class="content-wrapper">
    <section class="content">
    	<div class="col-md-6">
    		<div class="box box-warning box-solid">
	            <div class="box-header with-border">
	                <h3 class="box-title">DATA PENDAFTARAN</h3>
	            </div>
	            <form action="<?php echo $action; ?>" method="post"> 
					<table class='table table-bordered'>        
						<tr>
						    <td width='200'>No Registrasi <?php echo form_error('no_registrasi') ?></td>
						    <td><input type="text" class="form-control" name="no_registrasi" id="no_registrasi" readonly="" placeholder="No Registrasi" value="<?php echo noRegisterOtomatis(); ?>" /></td>
						</tr>
						<tr>
						    <td width='200'>No Rawat <?php echo form_error('no_rawat') ?></td>
						    <td><input type="text" class="form-control" name="no_rawat" id="no_rawat" readonly="" placeholder="no_rawat" value="<?php echo date('Y/m/d/').noRegisterOtomatis(); ?>" /></td>
						</tr>
						<!--<tr>
						    <td width='200'>No Rekamedis <?php echo form_error('no_rekamedis') ?></td>
						    <td><input type="text" class="form-control" name="no_rekamedis" id="no_rekamedis" placeholder="No Rekamedis" value="<?php echo $no_rekamedis; ?>" /></td>
						</tr>-->
						<tr>
						    <td width='200'>Cara Masuk <?php echo form_error('cara_masuk') ?></td>
						    <td>
								<?= form_dropdown('cara_masuk', array('RAWAT JALAN' => 'RAWAT JALAN', 'RAWAT INAP' => 'RAWAT INAP', 'UGD' => 'UGD'), $cara_masuk, 'class="form-control"');?>
						    	<!--<input type="text" class="form-control" name="cara_masuk" id="cara_masuk" placeholder="Cara Masuk" value="<?php echo $cara_masuk; ?>" />-->
						    </td>
						</tr>
						<tr>
						    <td width='200'>Ruang Rawat <?php echo form_error('ruang_rawat') ?></td>
						    <td>
								<input type="text" class="form-control" name="ruang_rawat" id="ruang_rawat" placeholder="Nomor Ruangan Rawat" value="" />
						    	<!--<input type="text" class="form-control" name="cara_masuk" id="cara_masuk" placeholder="Cara Masuk" value="<?php echo $cara_masuk; ?>" />-->
						    </td>
						</tr>
						<tr>
							<td width='200'>Tanggal Daftar <?php echo form_error('tanggal_daftar') ?></td>
							<td><input type="text" class="form-control" name="tanggal_daftar" id="tanggal_daftar" placeholder="Tanggal Daftar" value="<?php echo date('Y-m-d'); ?>" /></td>
						</tr>
						<tr>
							<td width='200'>Kode Dokter Penanggung Jawab <?php echo form_error('kode_dokter_penanggung_jawab') ?></td>
							<td><input type="text" class="form-control" name="kode_dokter_penanggung_jawab" id="kode_dokter_penanggung_jawab" placeholder="Kode Dokter Penanggung Jawab" value="<?php echo $kode_dokter_penanggung_jawab; ?>" /></td>
						</tr>
						<tr>
							<td width='200'>Id Poli <?php echo form_error('id_poli') ?></td>
							<td>
								<?= cmb_dinamis('id_poli', 'tbl_poliklinik', 'nama_poliklinik', 'id_poliklinik', $id_poli, 'class="form-control"');?>
								<!--<input type="text" class="form-control" name="id_poli" id="id_poli" placeholder="Id Poli" value="<?php echo $id_poli; ?>" />-->
							</td>
						</tr>
						<!--<tr>
							<td width='200'>Nama Penanggung Jawab <?php echo form_error('nama_penanggung_jawab') ?></td>
							<td><input type="text" class="form-control" name="nama_penanggung_jawab" id="nama_penanggung_jawab" placeholder="Nama Penanggung Jawab" value="<?php echo $nama_penanggung_jawab; ?>" /></td>
						</tr>-->
						<!--<tr>
							<td width='200'>Hubungan Dengan Penanggung Jawab <?php echo form_error('hubungan_dengan_penanggung_jawab') ?></td>
							<td><input type="text" class="form-control" name="hubungan_dengan_penanggung_jawab" id="hubungan_dengan_penanggung_jawab" placeholder="Hubungan Dengan Penanggung Jawab" value="<?php echo $hubungan_dengan_penanggung_jawab; ?>" /></td>
						</tr>--> 
					    <!--<tr>
					    	<td width='200'>Alamat Penanggung Jawab <?php echo form_error('alamat_penanggung_jawab') ?></td>
					    	<td> <textarea class="form-control" rows="3" name="alamat_penanggung_jawab" id="alamat_penanggung_jawab" placeholder="Alamat Penanggung Jawab"><?php echo $alamat_penanggung_jawab; ?></textarea></td>
					    </tr>-->
						<tr>
							<td width='200'>Id Jenis Bayar <?php echo form_error('id_jenis_bayar') ?></td>
							<td>
								<?= cmb_dinamis('id_jenis_bayar', 'tbl_jenis_bayar', 'jenis_bayar', 'id_jenis_bayar', $id_jenis_bayar, 'class="form-control"');?>
								<!--<input type="text" class="form-control" name="id_jenis_bayar" id="id_jenis_bayar" placeholder="Id Jenis Bayar" value="<?php echo $id_jenis_bayar; ?>" />-->
							</td>
						</tr>
						<tr>
							<td width='200'>Asal Rujukan <?php echo form_error('asal_rujukan') ?></td>
							<td><input type="text" class="form-control" name="asal_rujukan" id="asal_rujukan" placeholder="Asal Rujukan" value="<?php echo $asal_rujukan; ?>" /></td>
						</tr>
						<tr>
							<td></td>
							<td>
							<!--<input type="hidden" name="no_rawat" value="<?php echo $no_rawat; ?>" />-->
						    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
						    <a href="<?php echo site_url('pendaftaran') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td>
						</tr>
					</table>
				        
			</div>
    	</div>
    	<div class="col-md-6">
    		<div class="box box-warning box-solid">
	            <div class="box-header with-border">
	                <h3 class="box-title">DATA PASIEN</h3>
	            </div>
	     
					<table class='table table-bordered'>        
						<!--<tr>
						    <td width='200'>No Registrasi <?php echo form_error('no_registrasi') ?></td>
						    <td><input type="text" class="form-control" name="no_registrasi" id="no_registrasi" placeholder="No Registrasi" value="<?php echo $no_registrasi; ?>" /></td>
						</tr>-->
						<tr>
						    <td width='200'>No Rekamedis <?php echo form_error('no_rekamedis') ?></td>
						    <td><input type="text" class="form-control" name="no_rekamedis" id="no_rekamedis" placeholder="No Rekamedis" value="<?php echo $no_rekamedis; ?>" /></td>
						</tr>
						<!--<tr>
						    <td width='200'>Nama Pasien <?php echo form_error('nama_pasien') ?></td>
						    <td><input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Nama Pasien" value=""/></td>
						</tr>-->
						<tr>
						    <td width='200'>Tanggal Pendaftaran <?php echo form_error('tanggal_daftar') ?></td>
						    <td><input type="date" class="form-control" name="tanggal_daftar" id="tanggal_daftar" placeholder="Tanggal Pendaftaran" value="<?php echo date('Y-m-d'); ?>" /></td>
						</tr>
						<!--<tr>
						    <td width='200'>Cara Masuk <?php echo form_error('cara_masuk') ?></td>
						    <td><input type="text" class="form-control" name="cara_masuk" id="cara_masuk" placeholder="Cara Masuk" value="<?php echo $cara_masuk; ?>" /></td>
						</tr>-->
						<!--<tr>
							<td width='200'>Tanggal Daftar <?php echo form_error('tanggal_daftar') ?></td>
							<td><input type="text" class="form-control" name="tanggal_daftar" id="tanggal_daftar" placeholder="Tanggal Daftar" value="<?php echo $tanggal_daftar; ?>" /></td>
						</tr>-->
						<!--<tr>
							<td width='200'>Kode Dokter Penanggung Jawab <?php echo form_error('kode_dokter_penanggung_jawab') ?></td>
							<td><input type="text" class="form-control" name="kode_dokter_penanggung_jawab" id="kode_dokter_penanggung_jawab" placeholder="Kode Dokter Penanggung Jawab" value="<?php echo $kode_dokter_penanggung_jawab; ?>" /></td>
						</tr>-->
						<!--<tr>
							<td width='200'>Id Poli <?php echo form_error('id_poli') ?></td>
							<td><input type="text" class="form-control" name="id_poli" id="id_poli" placeholder="Id Poli" value="<?php echo $id_poli; ?>" /></td>
						</tr>-->
						<tr>
							<td width='200'>Nama Penanggung Jawab <?php echo form_error('nama_penanggung_jawab') ?></td>
							<td><input type="text" class="form-control" name="nama_penanggung_jawab" id="nama_penanggung_jawab" placeholder="Nama Penanggung Jawab" value="<?php echo $nama_penanggung_jawab; ?>" /></td>
						</tr>
						<tr>
							<td width='200'>Hubungan Dengan Penanggung Jawab <?php echo form_error('hubungan_dengan_penanggung_jawab') ?></td>
							<td>
								<?= form_dropdown('hubungan_dengan_penanggung_jawab', array('Orang tua' => 'Orang Tua', 'Saudara Kandung' => 'Saudara Kandung', 'Famili Lain' => 'Famili Lain'), $hubungan_dengan_penanggung_jawab, 'class="form-control"');?>
								<!--<input type="text" class="form-control" name="hubungan_dengan_penanggung_jawab" id="hubungan_dengan_penanggung_jawab" placeholder="Hubungan Dengan Penanggung Jawab" value="<?php echo $hubungan_dengan_penanggung_jawab; ?>" />-->
							</td>
						</tr> 
					    <tr>
					    	<td width='200'>Alamat Penanggung Jawab <?php echo form_error('alamat_penanggung_jawab') ?></td>
					    	<td> <textarea class="form-control" rows="3" name="alamat_penanggung_jawab" id="alamat_penanggung_jawab" placeholder="Alamat Penanggung Jawab"><?php echo $alamat_penanggung_jawab; ?></textarea></td>
					    </tr>
						<!--<tr>
							<td width='200'>Id Jenis Bayar <?php echo form_error('id_jenis_bayar') ?></td>
							<td><input type="text" class="form-control" name="id_jenis_bayar" id="id_jenis_bayar" placeholder="Id Jenis Bayar" value="<?php echo $id_jenis_bayar; ?>" /></td>
						</tr>-->
						<!--<tr>
							<td width='200'>Asal Rujukan <?php echo form_error('asal_rujukan') ?></td>
							<td><input type="text" class="form-control" name="asal_rujukan" id="asal_rujukan" placeholder="Asal Rujukan" value="<?php echo $asal_rujukan; ?>" /></td>
						</tr>-->
						<!--<tr>
							<td></td>
							<td><input type="hidden" name="no_rawat" value="<?php echo $no_rawat; ?>" /> 
						    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
						    <a href="<?php echo site_url('pendaftaran') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td>
						</tr>-->
					</table>
				</form>        
			</div>
    	</div>  
	</section>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>

<script type="text/javascript">
    $(function() {
        //autocomplete
        $("#kode_dokter_penanggung_jawab").autocomplete({
            source: "<?php echo base_url()?>/index.php/pendaftaran/autocomplate_dokter",
            minLength: 1
        });				
    });
</script>

<script type="text/javascript">
    $(function() {
        //autocomplete
        $("#no_rekamedis").autocomplete({
            source: "<?php echo base_url()?>/index.php/pendaftaran/autocomplate_no_rekamedis",
            minLength: 1
        });				
    });
</script>
