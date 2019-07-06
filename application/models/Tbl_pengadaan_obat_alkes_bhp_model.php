<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_pengadaan_obat_alkes_bhp_model extends CI_Model
{

    public $table = 'tbl_pengadaan_obat_alkes_bhp';
    public $id    = 'no_faktur';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('no_faktur', $q);
    	$this->db->or_like('tanggal', $q);
    	$this->db->or_like('kode_supplier', $q);
    	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('tbl_pengadaan_obat_alkes_bhp.no_faktur', $q);
    	$this->db->or_like('tbl_pengadaan_obat_alkes_bhp.tanggal', $q);
    	$this->db->or_like('tbl_pengadaan_obat_alkes_bhp.kode_supplier', $q);
    	$this->db->limit($limit, $start);
        $this->db->join('tbl_supplier', 'tbl_supplier.kode_supplier = tbl_pengadaan_obat_alkes_bhp.kode_supplier');
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Tbl_pengadaan_obat_alkes_bhp_model.php */
/* Location: ./application/models/Tbl_pengadaan_obat_alkes_bhp_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-02-06 09:46:51 */
/* http://harviacode.com */