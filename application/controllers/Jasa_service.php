<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jasa_service extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Jasa_service_model');

        if ($this->session->userdata('masuk') != TRUE) {
            $url = base_url();
            redirect($url);
        }
    }

    public function index()
    {
        $data['title'] = 'Jasa Service';

        if ($this->session->userdata('akses') == '1') {
            $this->load->view('templates/header', $data);
            $this->load->view('jasa_service/readonly', $data);
            $this->load->view('templates/footer');
        } else if ($this->session->userdata('akses') == '2') {
            $this->load->view('templates/header', $data);
            $this->load->view('jasa_service/index', $data);
            $this->load->view('templates/footer');
        } else {
            $previous_url = $this->session->userdata('previous_url');
            redirect($previous_url);
        }
        $this->session->set_userdata('previous_url', current_url());
    }

    public function fetch_data()
    {
        $list = $this->Jasa_service_model->make_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $jasa_service) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $jasa_service->nama_service;
            $row[] = $jasa_service->jenis_service;
            $row[] = $jasa_service->harga;
            $row[] = '<a href="jasa_service/edit/' . $jasa_service->id_jasa_service . ' " style="color: green; margin-left: 0.5rem"><i class="fas fa-pen"></i></a>&nbsp<a name="delete" onclick="delete_data(' . $jasa_service->id_jasa_service . ')"><i class="fas fa-trash" style="cursor: pointer; margin-left: 0.5rem; color: #d9232d"></i></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST["draw"],
            "recordsTotal" => $this->Jasa_service_model->get_all_data(),
            "recordsFiltered" => $this->Jasa_service_model->get_filtered_data(),
            "data" => $data
        );

        //output to json format
        echo json_encode($output);
    }

    public function add()
    {
        $data['title'] = 'Tambah Data Jasa Service';

        if ($this->session->userdata('akses') == '2') {
            $this->load->view('templates/header', $data);
            $this->load->view('jasa_service/add_data', $data);
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
            'nama_service' => $this->input->post('nama_service'),
            'jenis_service' => $this->input->post('jenis_service'),
            'harga' => $this->input->post('harga')
        ];

        $this->Jasa_service_model->add_data($data);
        $this->session->set_flashdata('flash', 'ditambahkan');
        redirect('jasa_service');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Data Jasa Service';
        $data['jasa_service'] = $this->Jasa_service_model->getById($id);

        if ($this->session->userdata('akses') == '2') {
            $this->load->view('templates/header', $data);
            $this->load->view('jasa_service/edit_data', $data);
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
            'nama_service' => $this->input->post('nama_service'),
            'jenis_service' => $this->input->post('jenis_service'),
            'harga' => $this->input->post('harga')
        ];

        $this->Jasa_service_model->edit_data(array('id_jasa_service' => $this->input->post('id')), $data);
        $this->session->set_flashdata('flash', 'diubah');
        redirect('jasa_service');
    }

    public function delete($id)
    {
        $this->Jasa_service_model->delete_data($id);
        echo json_encode(array("status" => true));
    }
}
