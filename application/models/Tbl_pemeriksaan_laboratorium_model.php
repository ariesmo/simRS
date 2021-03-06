<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_pemeriksaan_laboratorium_model extends CI_Model
{

    public $table = 'tbl_pemeriksaan_laboratorium';
    public $id    = 'kode_periksa';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('kode_periksa,nama_periksa,tarif');
        $this->datatables->from('tbl_pemeriksaan_laboratorium');
        //add this line for join
        //$this->datatables->join('table2', 'tbl_pemeriksaan_laboratorium.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('sub_periksa_labor/index/$1'),'<i class="fa fa-eye" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
            ".anchor(site_url('periksalabor/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('periksalabor/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kode_periksa');
        return $this->datatables->generate();
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
        $this->db->like('kode_periksa', $q);
    	$this->db->or_like('nama_periksa', $q);
    	$this->db->or_like('tarif', $q);
    	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kode_periksa', $q);
    	$this->db->or_like('nama_periksa', $q);
    	$this->db->or_like('tarif', $q);
    	$this->db->limit($limit, $start);
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

/* End of file Tbl_pemeriksaan_laboratorium_model.php */
/* Location: ./application/models/Tbl_pemeriksaan_laboratorium_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-02-08 14:24:12 */
/* http://harviacode.com */