<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">BIODATA PASIEN</h3>
                    </div>
                    <div class="box-body">
                         <table class="table table-bordered" style="margin-bottom: 10px">
                                <tr>
                                    <td>No. Rawat</td>
                                    <td><?= $pendaftaran['no_rawat'];?></td>
                                </tr>
                                <tr>
                                    <td>No. Rekamedis</td>
                                    <td><?= $pendaftaran['no_rekamedis'];?></td>
                                </tr>
                                <tr>
                                    <td>Nama pasien</td>
                                    <td><?= $pendaftaran['nama_pasien'];?></td>
                                </tr>
                                <tr>
                                    <td width="350px">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Input Tindakan</button>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#obatModal">Input Obat</button>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#laborModal">Periksa Labor</button>
                                    </td>
                                    <td>
                                        <?= anchor('pendaftaran/cetak_labor/'.$pendaftaran['no_rawat'],'Cetak Hasil Labor', "class='btn btn-danger' target='new'");?>
                                        <?= anchor('pendaftaran/cetak_rekamedis/'.$pendaftaran['no_rawat'],'Cetak Hasil Rekamedis', "class='btn btn-danger' target='new'");?>
                                        <?= anchor('pendaftaran/index/ralan','Kembali', "class='btn btn-primary'");?>  
                                    </td>
                                </tr>
                        </table>
                    </div>
                    <div class="box-body">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Input Tindakan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <?= form_open('pendaftaran/riwayat_tindakan');?>
                                        <table class='table table-bordered'>
                                            <tr>
                                                <input type="hidden" name="no_rawat" value="<?= $rawat;?>">
                                            </tr>        
                                            <tr>
                                                <td width='200'>Dilakukan Oleh <?php echo form_error('tindakan_oleh') ?></td>
                                                <td>
                                                    <?= form_dropdown('tindakan_oleh', array('pilih' => 'Pilih..', 'dokter' => 'Dokter', 'petugas' => 'Petugas', 'dokter_dan_petugas' => 'Dokter dan Petugas'), null, array('class' => 'form-control', 'id' => 'tindakan_oleh', 'onchange' => 'pemberi_tindakan()'));?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width='200'>Nama Tindakan <?php echo form_error('nama_tindakan') ?></td>
                                                <td><input type="text" class="form-control" name="nama_tindakan" id="nama_tindakan" placeholder="Nama Tindakan" value="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width='200'>Hasil Periksa <?php echo form_error('hasil_periksa') ?></td>
                                                <td><input type="text" class="form-control" name="hasil_periksa" id="hasil_periksa" placeholder="Hasil Periksa" value="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width='200'>Perkembangan <?php echo form_error('perkembangan') ?></td>
                                                <td><input type="text" class="form-control" name="perkembangan" id="perkembangan" placeholder="Perkembangan" value="" />
                                                </td>
                                            </tr>
                                        </table>
                                            <div class="tindakan_by">
                                                
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="obatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Input Obat</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <?= form_open('pendaftaran/beriobat_action');?>
                                        <table class='table table-bordered'>
                                            <tr>
                                                <input type="hidden" name="no_rawat" value="<?= $rawat;?>">
                                            </tr>
                                            <tr>
                                                <td width='200'>Nama Obat <?php echo form_error('nama_barang') ?></td>
                                                <td><input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Obat" value="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width='200'>Qty <?php echo form_error('qty') ?></td>
                                                <td><input type="text" class="form-control" name="qty" id="qty" placeholder="Quantity" value="" />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan Obat</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="laborModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Pemeriksaan Laboratorium</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <?= form_open('pendaftaran/periksa_labor_action');?>
                                        <table class='table table-bordered'>
                                            <tr>
                                                <input type="hidden" name="no_rawat" value="<?= $rawat;?>">
                                            </tr>
                                            <tr>
                                                <td width='200'>Pemeriksaan <?php echo form_error('nama_periksa') ?></td>
                                                <td><input type="text" class="form-control" name="nama_periksa" id="nama_periksa" onkeyup="periksa_labor()" placeholder="Nama Periksa" value="" />
                                                </td>
                                            </tr> 
                                        </table>
                                        <div class="periksa_by">
                                                
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan Periksa</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">RIWAYAT TINDAKAN</h3>
                    </div>
                    <div class="box-body">
                         <table class="table table-bordered" style="margin-bottom: 10px">
                              <tr>
                                  <th>No</th>
                                  <th>Tindakan</th>
                                  <th>Hasil Periksa</th>
                                  <th>Perkembangan</th>
                                  <th>Tanggal</th>
                                  <th>Tarif</th>
                              </tr> 
                              <?php
                              $total=0;
                              $no=1;
                              foreach($tindakan as $t){
                                echo "<tr>
                                        <td>$no</td>
                                        <td>$t->nama_tindakan</td>
                                        <td>$t->hasil_periksa</td>
                                        <td>$t->perkembangan</td>
                                        <td>$t->tanggal</td>
                                        <td>$t->tarif</td>
                                     </tr>";
                              $no++;
                              $total += $t->tarif;
                              }
                              ?>
                              <tr>
                                    <td colspan="4"></td>
                                    <td align="left"><b>TOTAL</b></td>
                                    <td><b><?= $total;?></b></td>
                              </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">RIWAYAT PEMBERIAN OBAT</h3>
                    </div>
                    <div class="box-body">
                         <table class="table table-bordered" style="margin-bottom: 10px">
                              <tr>
                                  <th>No</th>
                                  <th>Nama Obat dan Alkes</th>
                                  <th>Tanggal</th>
                                  <th>Jumlah</th>
                                  <th>Harga</th>
                                  <th>Subtotal</th>
                              </tr> 
                              <?php
                              $total=0;
                              $no=1;
                              foreach($obat as $o){
                                echo "<tr>
                                        <td>$no</td>
                                        <td>$o->nama_barang</td>
                                        <td>$o->tanggal</td>
                                        <td>$o->jumlah</td>
                                        <td>$o->harga</td>
                                        <td>".$o->jumlah*$o->harga."</td>
                                     </tr>";
                              $no++;
                              $total += ($o->jumlah*$o->harga);
                              }
                              ?>
                              <tr>
                                    <td colspan="4"></td>
                                    <td align="left"><b>TOTAL</b></td>
                                    <td><b><?= $total;?></b></td>
                              </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">RIWAYAT PEMERIKSAAN LABORATORIUM</h3>
                    </div>
                    <div class="box-body">
                         <table class="table table-bordered" style="margin-bottom: 10px">
                              <tr>
                                  <th>No</th>
                                  <th>Nama Pemeriksaan</th>
                                  <th>Satuan</th>
                                  <th>Hasil</th>
                                  <th>Keterangan</th>
                                  <th>Biaya</th>
                              </tr> 
                              <?php
                              $total=0;
                              $no=1;
                              foreach($labor as $l){
                                echo "<tr>
                                        <td>$no</td>
                                        <td>$l->nama_periksa</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>$l->tarif</td>
                                     </tr>";
                              $riwayat_detail_sql = "SELECT ts.nama_pemeriksaan, tr.hasil, tr.keterangan, ts.satuan
                                                    FROM tbl_riwayat_pemeriksaan_laboratorium_detail as tr, tbl_sub_pemeriksaan_laboratoirum as ts 
                                                    WHERE tr.kode_sub_periksa = ts.kode_sub_periksa and tr.id_rawat='$l->id_riwayat'";
                              $riwayat_detail     = $this->db->query($riwayat_detail_sql)->result();
                              foreach($riwayat_detail as $rd){
                                echo "<tr>
                                        <td></td>
                                        <td>$rd->nama_pemeriksaan</td>
                                        <td>$rd->satuan</td>
                                        <td>$rd->hasil</td>
                                        <td>$rd->keterangan</td>
                                        <td></td>
                                     </tr>";
                              }
                              $no++;
                              $total += ($o->jumlah*$o->harga);
                              }
                              ?>
                              <tr>
                                    <td colspan="4"></td>
                                    <td align="left"><b>TOTAL</b></td>
                                    <td><b><?= $total;?></b></td>
                              </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script type="text/javascript">
    function pemberi_tindakan(){
        var tindakan_oleh = $('#tindakan_oleh').val();
        $.ajax({
            url: "<?= base_url();?>index.php/pendaftaran/tindakan_ajax",
            data: "tindakan_oleh="+tindakan_oleh,
            success: function(html){
                $('.tindakan_by').html(html);
            }
        });
    }

    $(function() {
        //autocomplete
        $("#nama_tindakan").autocomplete({
            source: "<?php echo base_url();?>index.php/data_tindakan/autocomplete",
            minLength: 1
        });             
    });

    function autocomplete_dokter(){
        $("#txt_input_dokter").autocomplete({
            source: "<?php echo base_url();?>index.php/dokter/autocomplete",
            minLength: 1
        }); 
    }

    function autocomplete_petugas(){
        $("#txt_input_petugas").autocomplete({
            source: "<?php echo base_url();?>index.php/pegawai/autocomplete",
            minLength: 1
        }); 
    }

    $(function() {
        //autocomplete
        $("#nama_barang").autocomplete({
            source: "<?php echo base_url();?>index.php/dataobat/autocomplate_barang",
            minLength: 1
        });             
    });

    function periksa_labor() {
        //autocomplete
        $("#nama_periksa").autocomplete({
            source: "<?php echo base_url();?>index.php/periksalabor/autocomplate_periksa",
            minLength: 1
        }); 
        pemeriksa_labor();            
    }

    function pemeriksa_labor(){
        var nama_periksa = $('#nama_periksa').val();
        $.ajax({
            url: "<?= base_url();?>index.php/pendaftaran/sub_periksa_labor",
            data: "nama_periksa="+nama_periksa,
            success: function(html){
                $('.periksa_by').html(html);
            }
        });
    }

</script>