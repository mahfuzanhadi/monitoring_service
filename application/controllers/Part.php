<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Part extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Part_model');

        if ($this->session->userdata('masuk') != TRUE) {
            $url = base_url();
            redirect($url);
        }
    }

    public function index()
    {
        $data['title'] = 'Part';

        if ($this->session->userdata('akses') == '1') {
            $this->load->view('templates/header', $data);
            $this->load->view('part/readonly', $data);
            $this->load->view('templates/footer');
        } else if ($this->session->userdata('akses') == '2') {
            $this->load->view('templates/header', $data);
            $this->load->view('part/index', $data);
            $this->load->view('templates/footer');
        } else {
            $previous_url = $this->session->userdata('previous_url');
            redirect($previous_url);
        }
        $this->session->set_userdata('previous_url', current_url());
    }

    public function fetch_data()
    {
        $list = $this->Part_model->make_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $part) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $part->nama_part;
            $row[] = $part->kode_part;
            $row[] = $part->jenis_part;
            $row[] = $part->harga;
            $row[] = $part->stok;
            $row[] = '<a href="part/edit/' . $part->id_part . ' " style="color: green; margin-left: 0.5rem"><i class="fas fa-pen"></i></a>&nbsp<a name="delete" onclick="delete_data(' . $part->id_part . ')"><i class="fas fa-trash" style="cursor: pointer; margin-left: 0.5rem; color: #d9232d"></i></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST["draw"],
            "recordsTotal" => $this->Part_model->get_all_data(),
            "recordsFiltered" => $this->Part_model->get_filtered_data(),
            "data" => $data
        );

        //output to json format
        echo json_encode($output);
    }

    public function add()
    {
        $data['title'] = 'Tambah Data Part';

        if ($this->session->userdata('akses') == '2') {
            $this->load->view('templates/header', $data);
            $this->load->view('part/add_data', $data);
            $this->load->view('templates/footer');
        } else {
            $previous_url = $this->session->userdata('previous_url');
            redirect($previous_url);
        }
        $this->session->set_userdata('previous_url', current_url());
    }

    public function insert()
    {
        $data = [
            'nama_part' => $this->input->post('nama_part'),
            'kode_part' => $this->input->post('kode_part'),
            'jenis_part' => $this->input->post('jenis_part'),
            'harga' => $this->input->post('harga'),
            'stok' => $this->input->post('stok')
        ];

        $this->Part_model->add_data($data);
        $this->session->set_flashdata('flash', 'ditambahkan');
        redirect('part');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Data Jasa Service';
        $data['part'] = $this->Part_model->getById($id);

        if ($this->session->userdata('akses') == '2') {
            $this->load->view('templates/header', $data);
            $this->load->view('part/edit_data', $data);
            $this->load->view('templates/footer');
        } else {
            $previous_url = $this->session->userdata('previous_url');
            redirect($previous_url);
        }
        $this->session->set_userdata('previous_url', current_url());
    }

    public function update()
    {
        $data = [
            'nama_part' => $this->input->post('nama_part'),
            'kode_part' => $this->input->post('kode_part'),
            'jenis_part' => $this->input->post('jenis_part'),
            'harga' => $this->input->post('harga'),
            'stok' => $this->input->post('stok')
        ];

        $this->Part_model->edit_data(array('id_part' => $this->input->post('id')), $data);
        $this->session->set_flashdata('flash', 'diubah');
        redirect('part');
    }

    public function delete($id)
    {
        $this->Part_model->delete_data($id);
        echo json_encode(array("status" => true));
    }
}
