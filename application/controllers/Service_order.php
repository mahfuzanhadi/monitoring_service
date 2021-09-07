<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service_order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Service_order_model');

        if ($this->session->userdata('masuk') != TRUE) {
            $url = base_url();
            redirect($url);
        }
    }

    public function index()
    {
        $data['title'] = 'Service Order';

        if ($this->session->userdata('akses') == '1') {
            $this->load->view('templates/header', $data);
            $this->load->view('service_order/readonly', $data);
            $this->load->view('templates/footer');
        } else if ($this->session->userdata('akses') == '2') {
            $this->load->view('templates/header', $data);
            $this->load->view('service_order/index', $data);
            $this->load->view('templates/footer');
        } else {
            $previous_url = $this->session->userdata('previous_url');
            redirect($previous_url);
        }
        $this->session->set_userdata('previous_url', current_url());
    }

    public function fetch_data()
    {
        $list = $this->Service_order_model->make_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $service_order) {
            $row = array();
            $no++;
            $row[] = $service_order->no_order;
            $row[] = $service_order->nama_pemilik;
            $row[] = $service_order->nomor_plat;
            $row[] = $service_order->nomor_rangka;
            $row[] = $service_order->tipe_mobil;
            $row[] = $service_order->nama_service;
            $saran = $service_order->nama_part . " (" . $service_order->jumlah . ") @ " . $service_order->harga;
            $row[] = $saran;

            if ($this->session->userdata('akses') == 1) {
                if ($service_order->saran_approve == 1) {
                    $row[] = '<a class="btn btn-sm btn-success disabled" name="approve">Approved</a>';
                } else {
                    $row[] = '<button class="btn btn-sm btn-danger" name="approve" onclick="approve_saran(' . $service_order->no_order . ')">Not Approved</button>';
                }
            } else {
                if ($service_order->saran_approve == 1) {
                    $row[] = '<a class="btn btn-sm btn-success disabled">Approved</a>';
                } else {
                    $row[] = '<a class="btn btn-sm btn-danger disabled">Not Approved</a>';
                }
            }

            $row[] = $service_order->total;
            $row[] = '<a href="service_order/edit/' . $service_order->no_order . ' " style="color: green; margin-left: 0.5rem"><i class="fas fa-pen"></i></a>&nbsp<a name="delete" onclick="delete_data(' . $service_order->no_order . ')"><i class="fas fa-trash" style="cursor: pointer; margin-left: 0.5rem; color: #d9232d"></i></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST["draw"],
            "recordsTotal" => $this->Service_order_model->get_all_data(),
            "recordsFiltered" => $this->Service_order_model->get_filtered_data(),
            "data" => $data
        );

        //output to json format
        echo json_encode($output);
    }

    public function add()
    {
        $data['title'] = 'Tambah Service Order';

        $data['jasa_service'] = $this->Service_order_model->get_jasa_service();
        $data['parts'] = $this->Service_order_model->get_parts();

        if ($this->session->userdata('akses') == '2') {
            $this->load->view('templates/header', $data);
            $this->load->view('service_order/add_data', $data);
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
            'no_order' => $this->input->post('no_order'),
            'nama_pemilik' => $this->input->post('nama_pemilik'),
            'nomor_plat' => $this->input->post('nomor_plat'),
            'nomor_rangka' => $this->input->post('nomor_rangka'),
            'tipe_mobil' => $this->input->post('tipe_mobil'),
            'id_jasa_service' => $this->input->post('jasa_service'),
            'id_part' => $this->input->post('part'),
            'jumlah' => $this->input->post('jumlah'),
            'harga' => $this->input->post('harga'),
            'saran_approve' => 0,
            'total' => $this->input->post('total')
        ];

        $this->Service_order_model->add_data($data);
        $this->session->set_flashdata('flash', 'ditambahkan');
        redirect('service_order');
    }

    public function get_harga_jasa_service()
    {
        $id = $this->input->post('id', TRUE);
        $data = $this->Service_order_model->get_harga_jasa_service($id);
        echo json_encode($data);
    }

    public function get_data_part()
    {
        $id = $this->input->post('id', TRUE);
        $data = $this->Service_order_model->get_data_part($id);
        echo json_encode($data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Data Service Order';

        $data['service_order'] = $this->Service_order_model->getById($id);
        $data['jasa_service'] = $this->Service_order_model->get_jasa_service();
        $data['parts'] = $this->Service_order_model->get_parts();

        if ($this->session->userdata('akses') == '2') {
            $this->load->view('templates/header', $data);
            $this->load->view('service_order/edit_data', $data);
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
            'no_order' => $this->input->post('no_order'),
            'nama_pemilik' => $this->input->post('nama_pemilik'),
            'nomor_plat' => $this->input->post('nomor_plat'),
            'nomor_rangka' => $this->input->post('nomor_rangka'),
            'tipe_mobil' => $this->input->post('tipe_mobil'),
            'id_jasa_service' => $this->input->post('jasa_service'),
            'id_part' => $this->input->post('part'),
            'jumlah' => $this->input->post('jumlah'),
            'harga' => $this->input->post('harga'),
            'saran_approve' => $this->input->post('saran_approve'),
            'total' => $this->input->post('total')
        ];

        $this->Service_order_model->edit_data(array('no_order' => $this->input->post('no_order')), $data);
        $this->session->set_flashdata('flash', 'diubah');
        redirect('service_order');
    }

    public function delete($id)
    {
        $this->Service_order_model->delete_data($id);
        echo json_encode(array("status" => true));
    }

    public function approve_saran($id)
    {
        $this->Service_order_model->approve_saran($id);
        echo json_encode(array("status" => true));
    }
}
