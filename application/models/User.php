<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

	public function get_user($user) {
		$this->db->where(array('user_id' => $user['id']));
		$r = $this->db->get('users');

		if($r->num_rows() > 0) {
			return $r->row_array()['id'];
		}

		$r = $this->db->insert('users', array(
			'user_id' => $user['id'],
			'first_name' => $user['first_name'],
			'last_name' => $user['last_name'],
			'modified' => date('Y-m-d H:i:s')
		));

		return $this->db->insert_id();
	}

	public function get_users() {
		return $this->db->get('users')->result_array();
	}
}