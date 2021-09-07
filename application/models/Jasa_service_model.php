<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jasa_service_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    var $table = 'jasa_service';
    var $select_column = array('id_jasa_service', 'nama_service', 'jenis_service', 'harga');
    var $order_column = array(null, 'nama_service', 'jenis_service', 'harga'); //set column field database for datatable orderable
    var $order = array('id_jasa_service' => 'asc'); // default order 

    public function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST["search"]["value"])) {
            $this->db->like('nama_service', $_POST["search"]["value"]);
            $this->db->or_like('jenis_service', $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("id_jasa_service", "ASC");
        }
    }

    public function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getById($id)
    {
        return $this->db->get_where('jasa_service', ["id_jasa_service" => $id])->row_array();
    }

    public function add_data($data)
    {
        $this->db->insert('jasa_service', $data);
    }

    function edit_data($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    function delete_data($id)
    {
        $this->db->where('id_jasa_service', $id);
        $this->db->delete($this->table);
    }
}
