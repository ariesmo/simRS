<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_pasien_model extends CI_Model
{

    public $table = 'tbl_pasien';
    public $id    = 'no_rekamedis';
    public $order = 'ASC';

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
        $this->db->like('no_rekamedis', $q);
    	$this->db->or_like('nama_pasien', $q);
    	$this->db->or_like('jenis_kelamin', $q);
    	$this->db->or_like('golongan_darah', $q);
    	$this->db->or_like('tempat_lahir', $q);
    	$this->db->or_like('tanggal_lahir', $q);
    	$this->db->or_like('nama_ibu', $q);
    	$this->db->or_like('alamat', $q);
    	$this->db->or_like('id_agama', $q);
    	$this->db->or_like('status_menikah', $q);
    	$this->db->or_like('no_hp', $q);
    	$this->db->or_like('id_pekerjaan', $q);
    	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('tbl_pasien.no_rekamedis', $q);
    	$this->db->or_like('tbl_pasien.nama_pasien', $q);
    	$this->db->or_like('tbl_pasien.jenis_kelamin', $q);
    	$this->db->or_like('tbl_pasien.golongan_darah', $q);
    	$this->db->or_like('tbl_pasien.tempat_lahir', $q);
    	$this->db->or_like('tbl_pasien.tanggal_lahir', $q);
    	$this->db->or_like('tbl_pasien.nama_ibu', $q);
    	$this->db->or_like('tbl_pasien.alamat', $q);
    	$this->db->or_like('tbl_pasien.id_agama', $q);
    	$this->db->or_like('tbl_pasien.status_menikah', $q);
    	$this->db->or_like('tbl_pasien.no_hp', $q);
    	$this->db->or_like('tbl_pasien.id_pekerjaan', $q);
        $this->db->join('tbl_status_menikah', 'tbl_status_menikah.  id_status_menikah = tbl_pasien.status_menikah');
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

/* End of file Tbl_pasien_model.php */
/* Location: ./application/models/Tbl_pasien_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-02-03 12:45:35 */
/* http://harviacode.com */