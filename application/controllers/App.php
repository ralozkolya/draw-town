<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	private $data = array();

	public function index() {

		$link_image_id = $this->facebook->get_link_image_id();

		if($link_image_id) {
			$this->data['link_image'] = $this->Image->get_image($link_image_id);
		}

		$this->data['first_time'] = $this->facebook->first_time();

		$this->load->view('start', $this->data);
	}

	public function gallery($offset = 0) {

		$this->data['images'] = $this->Image->get_images();

		$result = array(
			'status' => 'ok',
			'body' => $this->load->view('gallery', $this->data, TRUE)
		);

		echo json_encode($result);
	}

	public function upload() {

		$this->load->model('User');

		$user = $this->facebook->get_user();
		$result = array();

		if(!$user) {
			$result['status'] = 'error';
			echo json_encode($result);
			return;
		}

		$decoded_user = $user->getDecodedBody();

		$user = $this->User->get_user($decoded_user);

		$config = array(
			'upload_path' => 'uploads',
			'allowed_types' => 'png|jpg|jpeg',
			'max_size' => '1024'
		);

		$this->load->library('upload', $config);

		if(!$this->upload->do_upload()) {
			$result['status'] = 'invalid_file';
			$result['message'] = $this->upload->display_errors();
			echo json_encode($result);
			return;
		}

		$upload_data = $this->upload->data();

		$config = array(
			'source_image' => 'uploads/'.$upload_data['file_name'],
			'new_image' => 'uploads/thumbs/'.$upload_data['file_name'],
			'width' => 200,
			'height' => 150,
			'maintain_ratio' => TRUE
		);

		$this->load->library('image_lib', $config);

		if(!$this->image_lib->resize()) {
			$result['status'] = 'error';
			$result['message'] = $this->image_lib->display_errors();
			echo json_encode($result);
			return;
		}

		$data = array(
			'name' => $upload_data['file_name'],
			'user_id' => $user
		);

		$this->Image->add_image($data);

		$result['status'] = 'ok';

		echo json_encode($result);
	}

	public function my_pic() {
		$this->load->model('User');

		$user = $this->facebook->get_user();
		$result = array();

		if(!$user) {
			$result['status'] = 'no_pic';
			echo json_encode($result);
			return;
		}

		$decoded_user = $user->getDecodedBody();

		$user = $this->User->get_user($decoded_user);

		$image = $this->Image->get_image_for_user($user);

		if(!$image) {
			$result['status'] = 'no_pic';
			echo json_encode($result);
			return;
		}

		$result['status'] = 'ok';
		$result['body'] = $image;

		echo json_encode($result);
	}

	public function privacy_policy() {
		$this->load->view('privacy');
	}

	public function redirect($id = 0) {

		if($id !== 0) {

			$image = $this->Image->get_image($id);

			if($image) {
				$this->data['image'] = $image;
				$this->load->view('redirect', $this->data);
				return;
			}

			
		}

		$this->data['image'] = NULL;
		$this->load->view('redirect', $this->data);
	}

	public function test() {
		var_dump(getimagesize('http://indiestudio.ge/fbapp/uploads/thumbs/poto.jpg')[0]);
	}
}