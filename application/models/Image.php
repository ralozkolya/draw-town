<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Model {

	public function add_image($data) {

		$this->delete_image_by_user_id($data['user_id']);

		$data['modified'] = date('Y-m-d H:i:s');

		$this->db->insert('images', $data);
	}

	public function delete_image_by_id($id) {
		$this->db->where(array('id' => $id));
		$r = $this->db->get('images');

		if($r->num_rows() > 0) {
			$this->delete_image($r->row_array());
		}
	}

	public function delete_image_by_user_id($user_id) {
		$this->db->where(array('user_id' => $user_id));
		$r = $this->db->get('images');

		if($r->num_rows() > 0) {
			$this->delete_image($r->row_array());
		}
	}

	public function delete_image($image) {

		$name = $image['name'];

		$path = 'uploads/' . $name;

		if(file_exists($path)) {
			unlink($path);
		}

		$path = 'uploads/thumbs/' . $name;

		if(file_exists($path)) {
			unlink($path);
		}

		$this->db->where(array('user_id' => $image['user_id']));
		$this->db->delete('images');
	}

	public function get_image($id) {
		$this->db->select(array(
			'images.id as id',
			'users.id as user_id',
			'images.name',
			'users.first_name',
			'users.last_name'
		));
		$this->db->where(array('images.id' => $id));
		$this->db->join('users', 'users.id = images.user_id');
		
		$r = $this->db->get('images');

		if($r->num_rows() === 1) {
			return $r->row_array();
		}

		return FALSE;
	}

	public function get_image_for_user($user_id) {

		$this->db->select(array(
			'name', 'id', 'approved'
		));
		$this->db->where(array('user_id' => $user_id));
		$r = $this->db->get('images');

		if($r->num_rows() > 0) {
			if($r->row_array()['approved'] == '1') {
				return $r->row_array();
			}

			else {
				return 'not_approved';
			}
		}

		return FALSE;
	}

	public function get_images($only_approved = TRUE) {
		$this->db->select(array(
			'images.id',
			'images.name',
			'images.modified',
			'images.approved',
			'users.first_name',
			'users.last_name',
			'users.user_id'
		));

		if($only_approved) {
			$this->db->where(array('approved' => 1));
		}

		$this->db->join('users', 'users.id = images.user_id');
		return $this->db->get('images')->result_array();
	}

	public function approve($id) {
		$this->db->where(array('id' => $id));
		return $this->db->update('images', array('approved' => 1));
	}
}