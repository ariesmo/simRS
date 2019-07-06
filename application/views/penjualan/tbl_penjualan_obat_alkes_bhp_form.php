<div class="content-wrapper">
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PENJUALAN OBAT ALKES BHP</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">    
				<table class='table table-bordered'> 
					<tr>
				    	<td width='200'>No. Faktur <?php echo form_error('no_faktur') ?></td>
				    	<td><input type="text" class="form-control" name="no_faktur" id="faktur" onkeyup="load()" placeholder="Masukkan Nomor Faktur" value="<?php echo $no_faktur; ?>" /></td>
				    </tr>       
				    <tr>
				    	<td width='200'>Tanggal <?php echo form_error('tanggal') ?></td>
				    	<td><input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" /></td>
				    </tr>
				    <tr>
				    	<td width='200'>Nama Pembeli <?php echo form_error('nama_pembeli') ?></td>
				    	<td><input type="text" class="form-control" name="nama_pembeli" id="nama_pembeli" placeholder="Masukkan Nomor Pembeli" value="<?php echo $nama_pembeli; ?>" /></td>
				    </tr>
				    <tr>
				    	<td width='200'>Cari Barang <?php echo form_error('barang') ?></td>
				    	<td>
				    		<div class="row">
				    		<div class="col-xs-4">
				    			<input type="text" class="form-control" name="barang" id="barang" placeholder="Nama Barang" value="" />
				    		</div>
				    		<div class="col-xs-3">
				    			<input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="" />
				    		</div>
				    		<div class="col-xs-1">
				    			<input type="text" class="form-control" name="qty" id="qty" placeholder="Qty" value="" />
				    		</div>
				    	</div>
				    	</td>
				    </tr>
				    <tr>
				    	<td></td>
				    	<td>
				    		<!--<input type="hidden" name="no_faktur" value="<?php echo $no_faktur; ?>" /> -->
				    	<button type="button" class="btn btn-success" onclick="add()"><i class="fa fa-floppy-o"></i> Add Barang</button>
					    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
					    <a href="<?php echo site_url('penjualan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td>
					</tr>
				</table>
			</form>        
		</div>
		<div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">DAFTAR ITEM YANG DIBELI</h3>
            </div> 
            <div id="load">
            	
            </div>       
		</div>
	</section>
</div>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script type="text/javascript">
    $(function() {
        //autocomplete
        $("#barang").autocomplete({
            source: "<?php echo base_url()?>/index.php/dataobat/autocomplate_barang",
            minLength: 1
        });				
    });
</script>
<script type="text/javascript">
    $(function() {
        //autocomplete
        $("#kode_supplier").autocomplete({
            source: "<?php echo base_url()?>/index.php/supplier/autocomplate",
            minLength: 1
        });				
    });
</script>
<script type="text/javascript">
    function add(){
    	var faktur 		 = $('#faktur').val();
    	var barang 		 = $('#barang').val();
    	var qty    		 = $('#qty').val();
    	$.ajax({
    		url: "<?= base_url();?>index.php/penjualan/add_ajax",
    		data: "faktur="+faktur+"&barang="+barang+"&qty="+qty,
    		success: function(html){
    			alert('Berhasil');
    			load();
    		}
    	});
    }
    function load(){
    	var faktur = $('#faktur').val();
    	$.ajax({
    		url: "<?= base_url();?>index.php/penjualan/load_ajax",
    		data: "no_faktur="+faktur,
    		success: function(html){
    			$('#load').html(html);
    		}
    	});
    }
    function hapus(id){
    	$.ajax({
    		url: "<?= base_url();?>index.php/penjualan/hapus",
    		data: "id_pengadaan="+id,
    		success: function(html){
    			load();
    		}
    	});
    }
</script>
<script type="text/javascript">
	$(document).ready(function(){
		load();
	});
</script>
