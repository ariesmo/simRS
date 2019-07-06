<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Tbl_pendaftaran Read</h2>
        <table class="table">
	    <tr><td>No Registrasi</td><td><?php echo $no_registrasi; ?></td></tr>
	    <tr><td>No Rekamedis</td><td><?php echo $no_rekamedis; ?></td></tr>
	    <tr><td>Cara Masuk</td><td><?php echo $cara_masuk; ?></td></tr>
	    <tr><td>Tanggal Daftar</td><td><?php echo $tanggal_daftar; ?></td></tr>
	    <tr><td>Kode Dokter Penanggung Jawab</td><td><?php echo $kode_dokter_penanggung_jawab; ?></td></tr>
	    <tr><td>Id Poli</td><td><?php echo $id_poli; ?></td></tr>
	    <tr><td>Nama Penanggung Jawab</td><td><?php echo $nama_penanggung_jawab; ?></td></tr>
	    <tr><td>Hubungan Dengan Penanggung Jawab</td><td><?php echo $hubungan_dengan_penanggung_jawab; ?></td></tr>
	    <tr><td>Alamat Penanggung Jawab</td><td><?php echo $alamat_penanggung_jawab; ?></td></tr>
	    <tr><td>Id Jenis Bayar</td><td><?php echo $id_jenis_bayar; ?></td></tr>
	    <tr><td>Asal Rujukan</td><td><?php echo $asal_rujukan; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('pendaftaran') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>