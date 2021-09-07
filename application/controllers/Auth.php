<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->session->set_userdata('previous_url', current_url());
	}

	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->session->userdata('masuk') != TRUE) {
			if ($this->form_validation->run() == false) {
				$data['title'] = 'Login Page';
				$this->load->view('auth/login', $data);
			} else {
				//validasi success
				$this->_login();
			}
		} else {
			redirect('service_order');
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->where('email', $email)->get('users')->row_array();

		if ($user) {
			//usernya ada
			// if (password_verify($password, $user['password'])) {
			if (md5($password) == $user['password']) {
				$data = [
					'id' => $user['id_user'],
					'nama' => $user['nama'],
					'email' => $user['email'],
					'role' => $user['role']
				];
				// $this->session->sess_expiration = 14400; // 4 Hours
				$this->session->set_userdata($data);
				$this->session->set_userdata('masuk', TRUE);
				if ($data['role'] == 1) {
					$this->session->set_userdata('akses', '1');
				} else if ($data['role'] == 2) {
					$this->session->set_userdata('akses', '2');
				} else {
					$this->session->set_userdata('akses', '3');
				}
				redirect('service_order');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah!</div>');
				redirect(base_url());
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User tidak terdaftar!</div>');
			redirect(base_url());
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('masuk');
		$this->session->unset_userdata('akses');
		$this->session->sess_destroy();
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
		redirect(base_url());
	}
}
