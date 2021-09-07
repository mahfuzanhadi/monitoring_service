<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service_order_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    var $table = 'service_order';
    var $select_column = array('no_order', 'nama_pemilik', 'nomor_plat', 'nomor_rangka', 'tipe_mobil', 'jasa_service.nama_service as nama_service', 'id_part', 'jumlah', 'harga', 'saran_approve', 'total');
    var $order_column = array(null, 'nama_pemilik', 'nomor_plat', 'nomor_rangka', 'tipe_mobil', 'jasa_service.nama_service as nama_service', 'id_part', 'jumlah', 'harga', 'saran_approve', 'total'); //set column field database for datatable orderable
    var $order = array('no_order' => 'asc'); // default order 

    public function make_query()
    {
        $this->db->select('service_order.no_order, service_order.nama_pemilik, service_order.nomor_plat, service_order.nomor_rangka, service_order.tipe_mobil, jasa_service.nama_service as nama_service, parts.nama_part as nama_part, service_order.jumlah, service_order.harga, service_order.saran_approve, service_order.total');
        $this->db->from($this->table);
        $this->db->join('jasa_service', 'jasa_service.id_jasa_service = service_order.id_jasa_service', 'left');
        $this->db->join('parts', 'parts.id_part = service_order.id_part', 'left');
        if (isset($_POST["search"]["value"])) {
            $this->db->like('nama_pemilik', $_POST["search"]["value"]);
            $this->db->or_like('nomor_plat', $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("no_order", "ASC");
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
        return $this->db->get_where('service_order', ["no_order" => $id])->row_array();
    }

    public function add_data($data)
    {
        $this->db->insert('service_order', $data);
    }

    public function edit_data($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_data($id)
    {
        $this->db->where('no_order', $id);
        $this->db->delete($this->table);
    }

    public function get_jasa_service()
    {
        $query = $this->db->query('SELECT * FROM jasa_service');
        return $query->result();
    }

    public function get_parts()
    {
        $query = $this->db->query('SELECT * FROM parts');
        return $query->result();
    }

    public function get_harga_jasa_service($id)
    {
        $this->db->select('harga');
        $this->db->from('jasa_service');
        $this->db->where('id_jasa_service', $id);
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->harga;
        }
    }

    public function get_data_part($id)
    {
        $this->db->select('*');
        $this->db->from('parts');
        $this->db->where('id_part', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function approve_saran($id)
    {
        $this->db->query("CALL approve_saran('" . $id . "')");

        $this->db->select('*');
        $this->db->from('service_order');
        $this->db->where('no_order', $id);
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            $total_sebelum = $row->total;
            $harga_part = $row->harga;
            $jumlah_part = $row->jumlah;
        }

        $total_sesudah = $total_sebelum + ($harga_part * $jumlah_part);

        $this->db->set('total', $total_sesudah);
        $this->db->where('no_order', $id);
        $this->db->update('service_order');
        return $this->db->affected_rows();
    }
}
