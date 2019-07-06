<div class="content-wrapper">
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PENGADAAN OBAT ALKES BHP</h3>
            </div>   
                <table class='table table-bordered'> 
                    <tr>
                        <td width='200'>No. Faktur</td>
                        <td><?php echo $no_faktur; ?></td>
                    </tr>       
                    <tr>
                        <td width='200'>Tanggal</td>
                        <td><?php echo $tanggal; ?></td>
                    </tr>
                    <tr>
                        <td width='200'>Kode Supplier</td>
                        <td><?php echo $kode_supplier; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <!--<input type="hidden" name="no_faktur" value="<?php echo $no_faktur; ?>" /> -->
                        <button type="button" class="btn btn-success" onclick="add()"><i class="fa fa-floppy-o"></i> Cetak Barang</button>
                        <a href="<?php echo site_url('pengadaan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td>
                    </tr>
                </table>        
        </div>
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">DAFTAR ITEM YANG DIBELI</h3>
            </div> 
            <div id="add">
                <table class='table table-bordered'> 
                    <tr>
                        <th>NO</th>
                        <th>NAMA BARANG</th>
                        <th>QTY</th>
                        <th>HARGA</th> 
                    </tr>
                <?php
                $list = $this->db->query($sql)->result();
                $no=1;
                foreach($list as $row){
                echo "<tr>
                        <td>$no</td>
                        <td>$row->nama_barang</td>
                        <td>$row->qty</td>
                        <td>$row->harga</td>
                    </tr>";
                $no++;
                }
                ?>
                </table>
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
        var faktur = $('#faktur').val();
        var barang = $('#barang').val();
        var harga  = $('#harga').val();
        var qty    = $('#qty').val();
        $.ajax({
            url: "<?= base_url();?>index.php/pengadaan/add_ajax",
            data: "barang="+barang+"&harga="+harga+"&qty="+qty+"&faktur="+faktur,
            success: function(html){
                alert('Berhasil');
                load();
            }
        });
    }
    function load(){
        var faktur = $('#faktur').val();
        $.ajax({
            url: "<?= base_url();?>index.php/pengadaan/load_ajax",
            data: "no_faktur="+faktur,
            success: function(html){
                $('#load').html(html);
            }
        });
    }
    function hapus(id){
        $.ajax({
            url: "<?= base_url();?>index.php/pengadaan/hapus",
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