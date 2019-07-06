<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pendaftaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_pendaftaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $cara_masuk_url = $this->uri->segment(3);
        if($cara_masuk_url == 'ralan'){
            $cara_masuk = 'RAWAT JALAN';
        } else {
            $cara_masuk = 'RAWAT INAP';
        }
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . '.php/c_url/index?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/pendaftaran/index?q=' . urlencode($q);
        } else {
            $config['base_url']  = base_url() . 'index.php/pendaftaran/index/';
            $config['first_url'] = base_url() . 'index.php/pendaftaran/index/';
        }

        $config['per_page']          = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows']        = $this->Tbl_pendaftaran_model->total_rows($q);
        $pendaftaran                 = $this->Tbl_pendaftaran_model->get_limit_data($config['per_page'], $start, $q, $cara_masuk);
        $config['full_tag_open']     = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close']    = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pendaftaran_data' => $pendaftaran,
            'q'                => $q,
            'pagination'       => $this->pagination->create_links(),
            'total_rows'       => $config['total_rows'],
            'start'            => $start,
        );
        $this->template->load('template','pendaftaran/tbl_pendaftaran_list', $data);
    }

    function autocomplate_dokter(){
        $this->db->like('nama_dokter', $_GET['term']);
        $this->db->select('nama_dokter');
        $dataDokter         = $this->db->get('tbl_dokter')->result();
        foreach ($dataDokter as $dokter) {
            $return_arr[]   = $dokter->nama_dokter;
        }

        echo json_encode($return_arr);
    }

    function autocomplate_no_rekamedis(){
        $this->db->like('no_rekamedis', $_GET['term']);
        $this->db->select('no_rekamedis');
        $dataPasien       = $this->db->get('tbl_pasien')->result();
        foreach ($dataPasien as $pasien) {
            $return_arr[] = $pasien->no_rekamedis;
        }

        echo json_encode($return_arr);
    }

    public function detail(){
        $no_rawat       = substr($this->uri->uri_string(3),19);
        $sql_daftar     = "SELECT td.no_rawat, td.no_rekamedis, tp.nama_pasien
                           FROM tbl_pendaftaran as td, tbl_pasien as tp
                           WHERE td.no_rekamedis = tp.no_rekamedis and td.no_rawat='$no_rawat'";
        $sql_tindakan   = "SELECT tt.*, tr.hasil_periksa, tr.perkembangan, tr.tanggal
                           FROM tbl_riwayat_tindakan as tr, tbl_tindakan as tt
                           WHERE tr.kode_tindakan = tt.kode_tindakan and tr.no_rawat='$no_rawat'";
        $sql_obat       = "SELECT ta.nama_barang, tr.tanggal, ta.harga, tr.jumlah
                           FROM tbl_riwayat_pemberian_obat as tr, tbl_obat_alkes_bhp as ta
                           WHERE tr.kode_barang = ta.kode_barang and tr.no_rawat='$no_rawat'";
        $sql_labor      = "SELECT tp.*, tr.tanggal, tr.id_riwayat
                           FROM tbl_riwayat_pemeriksaan_laboratorium as tr, tbl_pemeriksaan_laboratorium as tp
                           WHERE tr.kode_periksa = tp.kode_periksa and tr.no_rawat='$no_rawat'";
        $data['pendaftaran'] = $this->db->query($sql_daftar)->row_array();
        $data['rawat']       = $no_rawat;
        $data['tindakan']    = $this->db->query($sql_tindakan)->result();
        $data['obat']        = $this->db->query($sql_obat)->result();
        $data['labor']       = $this->db->query($sql_labor)->result();
        $this->template->load('template', 'pendaftaran/detail', $data);
    }

    public function read($id) 
    {
        $row = $this->Tbl_pendaftaran_model->get_by_id($id);
        if ($row) {
            $data = array(
        		'no_registrasi'                    => $row->no_registrasi,
        		'no_rawat'                         => $row->no_rawat,
        		'no_rekamedis'                     => $row->no_rekamedis,
        		'cara_masuk'                       => $row->cara_masuk,
        		'tanggal_daftar'                   => $row->tanggal_daftar,
        		'kode_dokter_penanggung_jawab'     => $row->kode_dokter_penanggung_jawab,
        		'id_poli'                          => $row->id_poli,
        		'nama_penanggung_jawab'            => $row->nama_penanggung_jawab,
        		'hubungan_dengan_penanggung_jawab' => $row->hubungan_dengan_penanggung_jawab,
        		'alamat_penanggung_jawab'          => $row->alamat_penanggung_jawab,
        		'id_jenis_bayar'                   => $row->id_jenis_bayar,
        		'asal_rujukan'                     => $row->asal_rujukan
	       );
            $this->template->load('template','pendaftaran/tbl_pendaftaran_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pendaftaran'));
        }
    }

    public function create() 
    {
        $data = array(
            'button'                           => 'Create',
            'action'                           => site_url('pendaftaran/create_action'),
    	    'no_registrasi'                    => set_value('no_registrasi'),
    	    'no_rawat'                         => set_value('no_rawat'),
    	    'no_rekamedis'                     => set_value('no_rekamedis'),
    	    'cara_masuk'                       => set_value('cara_masuk'),
    	    'tanggal_daftar'                   => set_value('tanggal_daftar'),
    	    'kode_dokter_penanggung_jawab'     => set_value('kode_dokter_penanggung_jawab'),
    	    'id_poli'                          => set_value('id_poli'),
    	    'nama_penanggung_jawab'            => set_value('nama_penanggung_jawab'),
    	    'hubungan_dengan_penanggung_jawab' => set_value('hubungan_dengan_penanggung_jawab'),
    	    'alamat_penanggung_jawab'          => set_value('alamat_penanggung_jawab'),
    	    'id_jenis_bayar'                   => set_value('id_jenis_bayar'),
    	    'asal_rujukan'                     => set_value('asal_rujukan')
	   );
        $this->template->load('template','pendaftaran/tbl_pendaftaran_form', $data);
    }

    function get_nama_dokter($nama_dokter){
        $this->db->where('nama_dokter', $nama_dokter);
        $dokter = $this->db->get('tbl_dokter')->row_array();
        return $dokter['kode_dokter'];
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
    		'no_registrasi'                    => $this->input->post('no_registrasi',TRUE),
            'no_rawat'                         => $this->input->post('no_rawat',TRUE),
    		'no_rekamedis'                     => $this->input->post('no_rekamedis',TRUE),
    		'cara_masuk'                       => $this->input->post('cara_masuk',TRUE),
    		'tanggal_daftar'                   => $this->input->post('tanggal_daftar',TRUE),
    		'kode_dokter_penanggung_jawab'     => $this->get_nama_dokter($this->input->post('kode_dokter_penanggung_jawab',TRUE)),
    		'id_poli'                          => $this->input->post('id_poli',TRUE),
    		'nama_penanggung_jawab'            => $this->input->post('nama_penanggung_jawab',TRUE),
    		'hubungan_dengan_penanggung_jawab' => $this->input->post('hubungan_dengan_penanggung_jawab',TRUE),
    		'alamat_penanggung_jawab'          => $this->input->post('alamat_penanggung_jawab',TRUE),
    		'id_jenis_bayar'                   => $this->input->post('id_jenis_bayar',TRUE),
    		'asal_rujukan'                     => $this->input->post('asal_rujukan',TRUE)
	    );
            $caraMasuk = $this->input->post('cara_masuk',TRUE);
            if($caraMasuk == 'RAWAT INAP'){
                $dataRawat = array(
                    'no_rawat'          => $this->input->post('no_rawat',TRUE),
                    'tanggal_masuk'     => $this->input->post('tanggal_daftar',TRUE),
                    'tanggal_keluar'    => 0000-00-00,
                    'kode_tempat_tidur' => $this->input->post('ruang_rawat',TRUE)
                );
                $this->db->insert('tbl_rawat_inap', $dataRawat);
                $this->db->where('kode_tempat_tidur', $this->input->post('ruang_rawat',TRUE));
                $this->db->update('tbl_tempat_tidur', array('status' => 'diisi'));
            }
            $this->Tbl_pendaftaran_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('pendaftaran'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_pendaftaran_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'                           => 'Update',
                'action'                           => site_url('pendaftaran/update_action'),
        		'no_registrasi'                    => set_value('no_registrasi', $row->no_registrasi),
        		'no_rawat'                         => set_value('no_rawat', $row->no_rawat),
        		'no_rekamedis'                     => set_value('no_rekamedis', $row->no_rekamedis),
        		'cara_masuk'                       => set_value('cara_masuk', $row->cara_masuk),
        		'tanggal_daftar'                   => set_value('tanggal_daftar', $row->tanggal_daftar),
        		'kode_dokter_penanggung_jawab'     => set_value('kode_dokter_penanggung_jawab', $row->kode_dokter_penanggung_jawab),
        		'id_poli'                          => set_value('id_poli', $row->id_poli),
        		'nama_penanggung_jawab'            => set_value('nama_penanggung_jawab', $row->nama_penanggung_jawab),
        		'hubungan_dengan_penanggung_jawab' => set_value('hubungan_dengan_penanggung_jawab', $row->hubungan_dengan_penanggung_jawab),
        		'alamat_penanggung_jawab'          => set_value('alamat_penanggung_jawab', $row->alamat_penanggung_jawab),
        		'id_jenis_bayar'                   => set_value('id_jenis_bayar', $row->id_jenis_bayar),
        		'asal_rujukan'                     => set_value('asal_rujukan', $row->asal_rujukan)
	    );
            $this->template->load('template','pendaftaran/tbl_pendaftaran_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pendaftaran'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('no_rawat', TRUE));
        } else {
            $data = array(
        		'no_registrasi'                    => $this->input->post('no_registrasi',TRUE),
        		'no_rekamedis'                     => $this->input->post('no_rekamedis',TRUE),
        		'cara_masuk'                       => $this->input->post('cara_masuk',TRUE),
        		'tanggal_daftar'                   => $this->input->post('tanggal_daftar',TRUE),
        		'kode_dokter_penanggung_jawab'     => $this->input->post('kode_dokter_penanggung_jawab',TRUE),
        		'id_poli'                          => $this->input->post('id_poli',TRUE),
        		'nama_penanggung_jawab'            => $this->input->post('nama_penanggung_jawab',TRUE),
        		'hubungan_dengan_penanggung_jawab' => $this->input->post('hubungan_dengan_penanggung_jawab',TRUE),
        		'alamat_penanggung_jawab'          => $this->input->post('alamat_penanggung_jawab',TRUE),
        		'id_jenis_bayar'                   => $this->input->post('id_jenis_bayar',TRUE),
        		'asal_rujukan'                     => $this->input->post('asal_rujukan',TRUE)
	       );

            $this->Tbl_pendaftaran_model->update($this->input->post('no_rawat', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pendaftaran'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_pendaftaran_model->get_by_id($id);

        if ($row) {
            $this->Tbl_pendaftaran_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pendaftaran'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pendaftaran'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_registrasi', 'no registrasi', 'trim|required');
	$this->form_validation->set_rules('no_rekamedis', 'no rekamedis', 'trim|required');
	$this->form_validation->set_rules('cara_masuk', 'cara masuk', 'trim|required');
	$this->form_validation->set_rules('tanggal_daftar', 'tanggal daftar', 'trim|required');
	$this->form_validation->set_rules('kode_dokter_penanggung_jawab', 'kode dokter penanggung jawab', 'trim|required');
	$this->form_validation->set_rules('id_poli', 'id poli', 'trim|required');
	$this->form_validation->set_rules('nama_penanggung_jawab', 'nama penanggung jawab', 'trim|required');
	$this->form_validation->set_rules('hubungan_dengan_penanggung_jawab', 'hubungan dengan penanggung jawab', 'trim|required');
	$this->form_validation->set_rules('alamat_penanggung_jawab', 'alamat penanggung jawab', 'trim|required');
	$this->form_validation->set_rules('id_jenis_bayar', 'id jenis bayar', 'trim|required');
	$this->form_validation->set_rules('asal_rujukan', 'asal rujukan', 'trim|required');

	$this->form_validation->set_rules('no_rawat', 'no_rawat', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_pendaftaran.xls";
        $judul = "tbl_pendaftaran";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
    	xlsWriteLabel($tablehead, $kolomhead++, "No Registrasi");
    	xlsWriteLabel($tablehead, $kolomhead++, "No Rekamedis");
    	xlsWriteLabel($tablehead, $kolomhead++, "Cara Masuk");
    	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Daftar");
    	xlsWriteLabel($tablehead, $kolomhead++, "Kode Dokter Penanggung Jawab");
    	xlsWriteLabel($tablehead, $kolomhead++, "Id Poli");
    	xlsWriteLabel($tablehead, $kolomhead++, "Nama Penanggung Jawab");
    	xlsWriteLabel($tablehead, $kolomhead++, "Hubungan Dengan Penanggung Jawab");
    	xlsWriteLabel($tablehead, $kolomhead++, "Alamat Penanggung Jawab");
    	xlsWriteLabel($tablehead, $kolomhead++, "Id Jenis Bayar");
    	xlsWriteLabel($tablehead, $kolomhead++, "Asal Rujukan");

	foreach ($this->Tbl_pendaftaran_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->no_registrasi);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->no_rekamedis);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->cara_masuk);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_daftar);
    	    xlsWriteNumber($tablebody, $kolombody++, $data->kode_dokter_penanggung_jawab);
    	    xlsWriteNumber($tablebody, $kolombody++, $data->id_poli);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_penanggung_jawab);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->hubungan_dengan_penanggung_jawab);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat_penanggung_jawab);
    	    xlsWriteNumber($tablebody, $kolombody++, $data->id_jenis_bayar);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->asal_rujukan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_pendaftaran.doc");

        $data = array(
            'tbl_pendaftaran_data' => $this->Tbl_pendaftaran_model->get_all(),
            'start'                => 0
        );
        
        $this->load->view('pendaftaran/tbl_pendaftaran_doc',$data);
    }

    function tindakan_ajax(){
        $tindakan_oleh = $this->input->get('tindakan_oleh');
        echo "<table class='table table-bordered'>";
        if($tindakan_oleh == 'dokter'){
            echo "<tr>
                      <td width='200'>Nama Dokter</td>
                      <td><input type='text' onkeyup='autocomplete_dokter()' class='form-control' name='nama_dokter' id='txt_input_dokter' placeholder='Nama Dokter' value='' />
                      </td>
                </tr>";
        } elseif($tindakan_oleh == 'petugas'){
            echo "<tr>
                      <td width='200'>Nama Petugas</td>
                      <td><input type='text' onkeyup='autocomplete_petugas()' class='form-control' name='nama_petugas' id='txt_input_petugas' placeholder='Nama Petugas' value='' />
                      </td>
                </tr>";
        } elseif($tindakan_oleh == 'pilih'){
            echo "<tr></tr>";
        }else {
            echo "<tr>
                      <td width='200'>Nama Dokter</td>
                      <td><input type='text' onkeyup='autocomplete_dokter()' class='form-control' name='nama_dokter' id='txt_input_dokter' placeholder='Nama Dokter' value='' />
                      </td>
                </tr>
                <tr>
                     <td width='200'>Nama Petugas</td>
                     <td><input type='text' onkeyup='autocomplete_petugas()' class='form-control' name='nama_petugas' id='txt_input_petugas' placeholder='Nama Petugas' value='' />
                     </td>
                </tr>";
        }
        echo "</table>";
    }

    function riwayat_tindakan(){
        $nama_tindakan = $this->db->get_where('tbl_tindakan',array('nama_tindakan' => $this->input->post('nama_tindakan')))->row_array();
        $no_rawat      = $this->input->post('no_rawat');
        $data = array(
            'kode_tindakan'     => $nama_tindakan['kode_tindakan'],
            'no_rawat'          => $no_rawat,
            'hasil_periksa'     => $this->input->post('hasil_periksa'),
            'perkembangan'      => $this->input->post('perkembangan'),
            'tanggal'           => date('Y-m-d')
        );
        $this->db->insert('tbl_riwayat_tindakan', $data);
        $id_riwayat_tindakan = $this->db->insert_id();
        $tindakan_oleh = $this->input->post('tindakan_oleh');
        if($tindakan_oleh == 'dokter'){
            $kode_dokter     = $this->db->get_where('tbl_dokter', array('nama_dokter' => $this->input->post('nama_dokter')))->row_array();
            $data = array(
                'id_riwayat_tindakan'   => $id_riwayat_tindakan,
                'kode_pj'               => $kode_dokter['kode_dokter'],
                'keterangan'            => 'dokter'
            );
            $this->db->insert('tbl_pj_riwayat_tindakan', $data);
        } elseif($tindakan_oleh == 'petugas'){
            $nik            = $this->db->get_where('tbl_pegawai', array('nama_pegawai' => $this->input->post('nama_petugas')))->row_array();
            $data = array(
                'id_riwayat_tindakan'   => $id_riwayat_tindakan,
                'kode_pj'               => $nik['nik'],
                'keterangan'            => 'petugas'
            );
            $this->db->insert('tbl_pj_riwayat_tindakan', $data);
        } else {
            $kode_dokter  = $this->db->get_where('tbl_dokter', array('nama_dokter' => $this->input->post('nama_dokter')))->row_array();
            $data_dokter  = array(
                'id_riwayat_tindakan'   => $id_riwayat_tindakan,
                'kode_pj'               => $kode_dokter['kode_dokter'],
                'keterangan'            => 'dokter'
            );
            $this->db->insert('tbl_pj_riwayat_tindakan', $data_dokter);

            $nik          = $this->db->get_where('tbl_pegawai', array('nama_pegawai' => $this->input->post('nama_petugas')))->row_array();
            $data_pegawai = array(
                'id_riwayat_tindakan'   => $id_riwayat_tindakan,
                'kode_pj'               => $nik['nik'],
                'keterangan'            => 'petugas'
            );
            $this->db->insert('tbl_pj_riwayat_tindakan', $data_pegawai);
        }
        redirect('pendaftaran/detail/'.$no_rawat);
    }

    function beriobat_action(){
        $barang    = $this->db->get_where('tbl_obat_alkes_bhp', array('nama_barang' => $this->input->post('nama_barang')))->row_array();
        $no_rawat  = $this->input->post('no_rawat');
        $data = array(
            'no_rawat'      => $this->input->post('no_rawat'),
            'tanggal'       => date('Y-m-d'),
            'kode_barang'   => $barang['kode_barang'],
            'jumlah'        => $this->input->post('qty')
        );
        $this->db->insert('tbl_riwayat_pemberian_obat', $data);
        redirect('pendaftaran/detail/'.$no_rawat);
    }

    function sub_periksa_labor(){
        $nama_periksa = $this->input->get('nama_periksa');
        $periksa      = $this->db->get_where('tbl_pemeriksaan_laboratorium', array('nama_periksa' => $nama_periksa))->row_array();
        $kode_periksa = $periksa['kode_periksa'];
        echo "<table class='table table-bordered'>
                <tr>
                    <th>Nama Pemeriksaan</th>
                    <th>Satuan</th>
                    <th>Nilai Rujukan</th>
                    <th>Hasil</th>
                    <th>Keterangan</th>
                </tr>";
        $this->db->where('kode_periksa', $kode_periksa);
        $labor = $this->db->get('tbl_sub_pemeriksaan_laboratoirum')->result();
        foreach($labor as $row){
        echo "<tr>  
                <td>$row->nama_pemeriksaan</td>
                <td>$row->satuan</td>
                <td>$row->nilai_rujukan</td>
                <td><input class='form-control' name='hasil-$row->kode_sub_periksa' placeholder='Hasil'></td>
                <td><input class='form-control' name='keterangan-$row->kode_sub_periksa' placeholder='Keterangan'></td>
            </tr>";
        }
        echo "</table>";
    }

    function periksa_labor_action(){
        $nama_periksa = $this->input->post('nama_periksa');
        $periksa      = $this->db->get_where('tbl_pemeriksaan_laboratorium', array('nama_periksa' => $nama_periksa))->row_array();
        $kode_periksa = $periksa['kode_periksa'];
        $no_rawat     = $this->input->post('no_rawat');

        $riwayat_labor = array(
            'no_rawat'      => $this->input->post('no_rawat'),
            'tanggal'       => date('Y-m-d'),
            'kode_periksa'  => $kode_periksa
        );
        $this->db->insert('tbl_riwayat_pemeriksaan_laboratorium', $riwayat_labor);

        $id_rawat    = $this->db->insert_id();
        $this->db->where('kode_periksa', $kode_periksa);
        $laborat = $this->db->get('tbl_sub_pemeriksaan_laboratoirum')->result();
        foreach($laborat as $row){
            $hasil            = $this->input->post('hasil-'.$row->kode_sub_periksa);
            $keterangan       = $this->input->post('keterangan-'.$row->kode_sub_periksa);
            $kode_sub_periksa = $row->kode_sub_periksa;
        
            $data = array(
                'id_rawat'          => $id_rawat,
                'kode_sub_periksa'  => $kode_sub_periksa,
                'hasil'             => $hasil,
                'keterangan'        => $keterangan
            );

            $this->db->insert('tbl_riwayat_pemeriksaan_laboratorium_detail', $data);
        }
        redirect('pendaftaran/detail/'.$no_rawat);
    }

    function cetak_labor(){
        $no_rawat       = substr($this->uri->uri_string(3),24);
        $sql_daftar     = "SELECT td.no_rawat, td.no_rekamedis, tp.nama_pasien, tr.nama_dokter, tp.jenis_kelamin, 
                           tp.alamat, td.no_rawat, tk.nama_poliklinik
                           FROM tbl_pendaftaran as td, tbl_pasien as tp, tbl_dokter as tr, tbl_poliklinik as tk
                           WHERE td.no_rekamedis = tp.no_rekamedis and td.kode_dokter_penanggung_jawab = tr.kode_dokter 
                           and td.id_poli = tk.id_poliklinik and td.no_rawat='$no_rawat'";
        $sql_labor      = "SELECT tp.*, tr.tanggal, tr.id_riwayat
                           FROM tbl_riwayat_pemeriksaan_laboratorium as tr, tbl_pemeriksaan_laboratorium as tp
                           WHERE tr.kode_periksa = tp.kode_periksa and tr.no_rawat='$no_rawat'";

        $this->load->library('pdf');
        $pdf = new FPDF('P', 'mm', 'A4');

        // membuat halaman baru
        $pdf->AddPage();

        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 14);
        // $pdf->image('http://localhost/simrs/assets/foto_profil/atomix_user31.png',25,4,20,20);

        // mencetak string 
        $pdf->Cell(190, 6,getInfoRS('nama_rumah_sakit'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(190, 4,getInfoRS('alamat'), 0, 1, 'C');
        $pdf->Cell(190, 4,'Telp.'.getInfoRS('no_telpon').' Email. rsdrsoedirman@gmail.com', 0, 1, 'C');
        $pdf->Cell(190, 4,getInfoRS('kabupaten').' - '.getInfoRS('propinsi'), 0, 1, 'C');
        $pdf->Line(10, 29, 220-20, 29);
        $pdf->Line(10, 30, 220-20, 30);
        $pdf->Cell(8, 4, '', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(190, 3, 'HASIL PEMERIKSAAN LABORATORIUM', 0, 1, 'C');
        $pdf->Cell(8, 3, '', 0, 1, 'C');

        //data pasien
        $pendaftaran  = $this->db->query($sql_daftar)->row_array();
        $laboratorium = $this->db->query($sql_labor )->row_array();

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 5, 'No. RM', 0, 0, 'L');
        $pdf->Cell(70, 5, ': '.$pendaftaran['no_rekamedis'], 0, 0, 'L');
        $pdf->Cell(50, 5, 'Penanggung Jawab', 0, 0, 'L');
        $pdf->Cell(50, 5, ': '.$pendaftaran['nama_dokter'], 0, 1, 'L');

        $pdf->Cell(30, 5, 'Nama Pasien', 0, 0, 'L');
        $pdf->Cell(70, 5, ': '.$pendaftaran['nama_pasien'], 0, 0, 'L');
        $pdf->Cell(50, 5, 'Dokter Pengirim', 0, 0, 'L');
        $pdf->Cell(50, 5, ': -------------------------------', 0, 1, 'L');

        $pdf->Cell(30, 5, 'JK / umur', 0, 0, 'L');
        $pdf->Cell(70, 5, ': '.$pendaftaran['jenis_kelamin'], 0, 0, 'L');
        $pdf->Cell(50, 5, 'Tgl. Pemeriksaan', 0, 0, 'L');
        $pdf->Cell(50, 5, ': '.$laboratorium['tanggal'], 0, 1, 'L');

        $pdf->Cell(30, 5, 'Alamat', 0, 0, 'L');
        $pdf->Cell(70, 5, ': '.$pendaftaran['alamat'], 0, 0, 'L');
        $pdf->Cell(50, 5, 'Jam Pemeriksaan', 0, 0, 'L');
        $pdf->Cell(50, 5, ': -------------------------------', 0, 1, 'L');

        $pdf->Cell(30, 5, 'No. Periksa', 0, 0, 'L');
        $pdf->Cell(70, 5, ': '.$pendaftaran['no_rawat'], 0, 0, 'L');
        $pdf->Cell(50, 5, 'Poli', 0, 0, 'L');
        $pdf->Cell(50, 5, ': '.$pendaftaran['nama_poliklinik'], 0, 1, 'L');
        $pdf->Cell(8, 3, '', 0, 1, 'C');

        //tabel hasil
        $pdf->Cell(8, 7, 'NO', 1, 0, 'C');
        $pdf->Cell(40, 7, 'PEMERIKSAAN', 1, 0, 'C');
        $pdf->Cell(30, 7, 'HASIL', 1, 0, 'C');
        $pdf->Cell(30, 7, 'SATUAN', 1, 0, 'C');
        $pdf->Cell(40, 7, 'NILAI RUJUKAN', 1, 0, 'C');
        $pdf->Cell(40, 7, 'KETERANGAN', 1, 1, 'C');

        $labor = $this->db->query($sql_labor )->result();
        $no=1;
        foreach($labor as $l){
            $pdf->Cell(8, 7, $no, 1, 0, 'C');
            $pdf->Cell(40, 7, $l->nama_periksa, 0, 0, 'L');
            $pdf->Cell(30, 7, '', 0, 0, 'L');
            $pdf->Cell(30, 7, '', 0, 0, 'L');
            $pdf->Cell(40, 7, '', 0, 0, 'L');
            $pdf->Cell(40, 7, '', 1, 1, 'L'); 

            $riwayat_detail_sql = "SELECT ts.nama_pemeriksaan, tr.hasil, tr.keterangan, ts.satuan, ts.nilai_rujukan
                                   FROM tbl_riwayat_pemeriksaan_laboratorium_detail as tr, tbl_sub_pemeriksaan_laboratoirum as ts 
                                   WHERE tr.kode_sub_periksa = ts.kode_sub_periksa and tr.id_rawat='$l->id_riwayat'";
            $riwayat_detail     = $this->db->query($riwayat_detail_sql)->result();
            foreach($riwayat_detail as $rd){
                $pdf->Cell(8, 7,'', 1, 0, 'L');
                $pdf->Cell(40, 7,' - '.$rd->nama_pemeriksaan, 1, 0, 'L');
                $pdf->Cell(30, 7,$rd->hasil, 1, 0, 'C');
                $pdf->Cell(30, 7,$rd->satuan, 1, 0, 'C');
                $pdf->Cell(40, 7,$rd->nilai_rujukan, 1, 0, 'C');
                $pdf->Cell(40, 7,$rd->keterangan, 1, 1, 'C'); 
            } 
        $no++;
        }
        $pdf->Cell(8, 3, '', 0, 1, 'C');

        $pdf->Cell(280, 3, 'Tanggal Cetak. '.date('Y-m-d H:i:s'), 0, 1, 'C');
        $pdf->Cell(280, 7, 'Petugas Laboratorium', 0, 1, 'C');
        $pdf->Cell(280, 27, '--------------------', 0, 1, 'C');
        $pdf->Cell(8, 3, '', 0, 1, 'C');

        //footnote
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 3, 'Catatan :', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(30, 3, 'Jika keragu-raguan dalam hasil pemeriksaan', 0, 1, 'L');
        $pdf->Cell(30, 2, 'diharapkan segera menghubungi laboratorium', 0, 1, 'L');
        
        $pdf->Output();
    }

    function cetak_rekamedis(){
        $no_rawat       = substr($this->uri->uri_string(3),28);
        $sql_daftar     = "SELECT td.no_rawat, td.no_rekamedis, tp.nama_pasien, tr.nama_dokter, tp.jenis_kelamin, 
                           tp.alamat, td.no_rawat, tk.nama_poliklinik, tb.jenis_bayar, td.nama_penanggung_jawab, 
                           td.alamat_penanggung_jawab
                           FROM tbl_pendaftaran as td, tbl_pasien as tp, tbl_dokter as tr, tbl_poliklinik as tk, tbl_jenis_bayar as tb
                           WHERE td.no_rekamedis = tp.no_rekamedis and td.kode_dokter_penanggung_jawab = tr.kode_dokter 
                           and td.id_poli = tk.id_poliklinik and td.id_jenis_bayar = tb.id_jenis_bayar and td.no_rawat='$no_rawat'";
        $daftar_pasien  = $this->db->query($sql_daftar)->row_array();
        $no_rekamedis   = $daftar_pasien['no_rekamedis'];
        $sql_agama      = "SELECT tp.*, ta.agama, ts.status_menikah, tp.jenis_kelamin, tj.nama_pekerjaan, tp.alamat
                           FROM tbl_pasien as tp, tbl_agama as ta, tbl_status_menikah as ts, tbl_pekerjaan as tj
                           WHERE tp.id_agama = ta.id_agama and tp.status_menikah = ts.id_status_menikah and tp.id_pekerjaan = tj.id_pekerjaan and tp.no_rekamedis='$no_rekamedis'";

        $this->load->library('pdf');
        $pdf = new FPDF('P', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(130, 7, '', 0, 0);
        $daftar = $this->db->query($sql_daftar)->row_array();

        $pdf->Cell(30, 7, 'Cara bayar : '.$daftar['jenis_bayar'], 0, 1);

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 30, '', 1, 1);
        $pdf->Text(50, 24,getInfoRS('nama_rumah_sakit'));
        $pdf->SetFont('Arial', '', 11);
        $pdf->Text(50, 31,getInfoRS('alamat'));
        $pdf->Text(50, 37,'Telp.'.getInfoRS('no_telpon').' Email. rsdrsoedirman@gmail.com');
        $pdf->Text(50, 41,getInfoRS('kabupaten').' - '.getInfoRS('propinsi'));

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 7, 'IDENTITAS PASIEN', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 13);
        $pdf->Cell(60, 14, 'NOMOR REKAM MEDIK', 1, 0, 'L');
        $pdf->SetFont('Arial', 'B', 22);
        $pdf->Cell(130, 14,$daftar['no_rekamedis'], 1, 1, 'C');

        $pasien          = $this->db->query($sql_agama)->row_array();
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(190, 7, 'NAMA PASIEN      : '.$daftar['nama_pasien'].
                                 '           NAMA IBU    : '.$pasien['nama_ibu'], 1, 1, 'L');
        $pdf->Cell(130, 7, 'No. Identitas          : 1234567891234567', 1, 0, 'L');
        $pdf->Cell(60, 7, 'KTP/SIM/PASPOR', 1, 1, 'L');

        
        $pdf->Cell(130, 7, 'Agama                   : '.$pasien['agama'], 1, 0, 'L');
        $pdf->Cell(60, 7, 'Tanggal Lahir : '.$pasien['tanggal_lahir'], 1, 1, 'L');
        $pdf->Cell(130, 7, 'Status                    : '.$pasien['status_menikah'], 1, 0, 'L');
        $pdf->Cell(60, 7, 'Janis Kelamin : '.$pasien['jenis_kelamin'], 1, 1, 'L');
        $pdf->Cell(130, 7, 'Pekerjaan              : '.$pasien['nama_pekerjaan'], 1, 0, 'L');
        $pdf->Cell(60, 7, 'Pendidikan     : S2', 1, 1, 'L');
        $pdf->Cell(190, 7, 'Alamat                   : '.$pasien['alamat'], 1, 1, 'L');
        $pdf->Cell(40, 14, 'Bila Ada Sesuatu', 1, 0, 'L');
        $pdf->Cell(150, 7, 'Nama      : '.$daftar['nama_penanggung_jawab'], 1, 1, 'L');
        $pdf->Cell(40, 7, '', 0, 0);
        $pdf->Cell(150, 7, 'Alamat    : '.$daftar['alamat_penanggung_jawab'], 1, 1, 'L');
        $pdf->Cell(190, 7, '*) Lingkari yang sesuai', 1, 1);

        //tabel hasil
        $pdf->Cell(18, 7, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(32, 7, 'Poliklinik Tujuan', 1, 0, 'C');
        $pdf->Cell(58, 7, 'Riwayat penyakit / Pemeriksaan', 1, 0, 'C');
        $pdf->Cell(27, 7, 'Diagnosa', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Obat Terapi', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Paraf', 1, 1, 'C');

        $pdf->Cell(18, 50, '', 1, 0, 'C');
        $pdf->Cell(32, 50, '', 1, 0, 'C');
        $pdf->Cell(58, 50, '', 1, 0, 'C');
        $pdf->Cell(27, 50, '', 1, 0, 'C');
        $pdf->Cell(30, 50, '', 1, 0, 'C');
        $pdf->Cell(25, 50, '', 1, 1, 'C');

        $pdf->Output();
    }

}

/* End of file Pendaftaran.php */
/* Location: ./application/controllers/Pendaftaran.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-02-05 09:01:18 */
/* http://harviacode.com */