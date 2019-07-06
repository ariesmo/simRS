<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_penjualan_obat_alkes_bhp_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        
        if ($q <> '') {
            $config['base_url']  = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/penjualan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url']  = base_url() . 'index.php/penjualan/index/';
            $config['first_url'] = base_url() . 'index.php/penjualan/index/';
        }

        $config['per_page']          = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows']        = $this->Tbl_penjualan_obat_alkes_bhp_model->total_rows($q);
        $penjualan                   = $this->Tbl_penjualan_obat_alkes_bhp_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open']     = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close']    = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'penjualan_data' => $penjualan,
            'q'              => $q,
            'pagination'     => $this->pagination->create_links(),
            'total_rows'     => $config['total_rows'],
            'start'          => $start
        );
        $this->template->load('template','penjualan/tbl_penjualan_obat_alkes_bhp_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Tbl_penjualan_obat_alkes_bhp_model->get_by_id($id);
        if ($row) {
            $data = array(
		      'no_faktur'    => $row->no_faktur,
		      'tanggal'      => $row->tanggal,
		      'nama_pembeli' => $row->nama_pembeli
	    );
            $data['sql'] = "SELECT pd.id_penjualan, oa.kode_barang, oa.nama_barang, pd.qty
                            FROM tbl_penjualan_detail as pd, tbl_obat_alkes_bhp as oa
                            WHERE pd.kode_barang = oa.kode_barang and pd.no_faktur='$id'";
            $this->template->load('template','penjualan/tbl_penjualan_obat_alkes_bhp_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button'       => 'Create',
            'action'       => site_url('penjualan/create_action'),
    	    'no_faktur'    => set_value('no_faktur'),
    	    'tanggal'      => set_value('tanggal'),
    	    'nama_pembeli' => set_value('nama_pembeli')
	);
        $this->template->load('template','penjualan/tbl_penjualan_obat_alkes_bhp_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'no_faktur'    => $this->input->post('no_faktur',TRUE),
        		'tanggal'      => $this->input->post('tanggal',TRUE),
        		'nama_pembeli' => $this->input->post('nama_pembeli',TRUE)
	    );

            $this->Tbl_penjualan_obat_alkes_bhp_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('penjualan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_penjualan_obat_alkes_bhp_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'       => 'Update',
                'action'       => site_url('penjualan/update_action'),
        		'no_faktur'    => set_value('no_faktur', $row->no_faktur),
        		'tanggal'      => set_value('tanggal', $row->tanggal),
        		'nama_pembeli' => set_value('nama_pembeli', $row->nama_pembeli)
	    );
            $this->template->load('template','penjualan/tbl_penjualan_obat_alkes_bhp_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('no_faktur', TRUE));
        } else {
            $data = array(
        		'tanggal'      => $this->input->post('tanggal',TRUE),
        		'nama_pembeli' => $this->input->post('nama_pembeli',TRUE)
	    );

            $this->Tbl_penjualan_obat_alkes_bhp_model->update($this->input->post('no_faktur', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('penjualan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_penjualan_obat_alkes_bhp_model->get_by_id($id);

        if ($row) {
            $this->Tbl_penjualan_obat_alkes_bhp_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('penjualan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
	$this->form_validation->set_rules('nama_pembeli', 'nama pembeli', 'trim|required');

	$this->form_validation->set_rules('no_faktur', 'no_faktur', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function add_ajax(){
        $faktur = $this->input->get('faktur');
        $barang = $this->input->get('barang');
        $qty    = $this->input->get('qty');
        $namaBarang = $this->db->get_where('tbl_obat_alkes_bhp', array('nama_barang' => $barang))->row_array();
        $data = array(
            'kode_barang' => $namaBarang['kode_barang'],
            'qty'         => $qty,
            'no_faktur'   => $faktur

        );
        $this->db->insert('tbl_penjualan_detail', $data);
    }

    function load_ajax(){
        $faktur = $this->input->get('no_faktur');
        echo "<table class='table table-bordered'> 
                    <tr>
                        <th>NO</th>
                        <th>NAMA BARANG</th>
                        <th>QTY</th>
                        <th>AKSI</th>  
                    </tr>";
        $sql = "SELECT pd.id_penjualan, oa.kode_barang, oa.nama_barang, pd.qty
                FROM tbl_penjualan_detail as pd, tbl_obat_alkes_bhp as oa
                WHERE pd.kode_barang = oa.kode_barang and pd.no_faktur='$faktur'";
        $list = $this->db->query($sql)->result();
        $no=1;
        foreach($list as $row){
            echo "<tr>
                    <td>$no</td>
                    <td>$row->nama_barang</td>
                    <td>$row->qty</td>
                    <td width='100'><button class='btn btn-danger' onclick='hapus($row->id_penjualan)'>Hapus</button></td>
                </tr>";
        $no++;
        }
        echo "</table>  ";
    }
    function hapus(){
        $id_pengadaan = $this->input->get('id_pengadaan');
        $this->db->where('id_pengadaan', $id_pengadaan);
        $this->db->delete('tbl_pengadaan_detail');
    }

}

/* End of file Penjualan.php */
/* Location: ./application/controllers/Penjualan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-02-07 13:05:14 */
/* http://harviacode.com */