<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	private $data = array();

	public function __construct() {

		parent::__construct();

		$this->load->library('Auth');

		$this->load->helper('force_ssl');

		force_ssl();
	}

	public function test() {
		var_dump($_SERVER['HTTP_X_FORWARDED_PROTO']);
	}

	public function index()
	{
		if($this->auth->is_logged_in()) {
			$this->images();
		}

		else {
			$this->login();
		}
	}

	public function users() {
		$this->redirect();

		$this->load->model('User');

		$this->data['users'] = $this->User->get_users();
		$this->load->view('admin', $this->data);
	}

	public function images() {
		$this->redirect();

		$this->load->model('Image');

		$this->data['images'] = $this->Image->get_images(FALSE);
		$this->load->view('admin', $this->data);
	}

	public function approve_image($id) {
		$this->redirect();

		$this->load->model('Image');

		$this->Image->approve($id);

		redirect(base_url().'admin/images');
	}

	public function delete_image($id) {
		$this->redirect();

		$this->load->model('Image');

		$this->Image->delete_image_by_id($id);

		redirect(base_url().'admin/images');
	}

	public function login() {

		if($this->input->post()) {

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if($this->auth->login($username, $password)) {
				redirect(base_url().'admin/images');
				return;
			}

			$this->data['error_message'] = 'არასწორი მომხმარებელი/პაროლი';
		}

		$this->load->view('login', $this->data);
	}

	public function logout() {
		$this->auth->logout();

		redirect(base_url().'admin');
	}

	private function redirect() {
		if(!$this->auth->is_logged_in()) {
			redirect(base_url().'admin');
			exit;
		}
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */