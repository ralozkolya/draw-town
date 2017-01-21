<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {

	private $CI;

	public function __construct() {

		$this->CI =& get_instance();

		$this->CI->load->library('session');
	}

	public function login($username, $password) {

		$this->CI->db->where(array(
			USERNAME => $username
		));

		$r = $this->CI->db->get(USERS);

		if($r->num_rows() === 1) {

			$user = $r->row_array();

			if(password_verify($password, $user[PASSWORD])) {
				unset($user[PASSWORD]);
				$this->CI->session->set_userdata(USER, $user);

				return TRUE;
			}
		}

		return FALSE;
	}

	public function logout() {

		$this->CI->session->unset_userdata(USER);
	}

	public function is_logged_in() {
		
		$user = $this->CI->session->userdata(USER);

		if($user) {
			$this->CI->db->where(array(ID => $user[ID], USERNAME => $user[USERNAME]));
			$r = $this->CI->db->get(USERS);

			if($r->num_rows() == 1) {
				return TRUE;
			}
		}

		$this->logout();

		return FALSE;
	}

	public function add_user($data) {

		$this->CI->db->where(array(USERNAME => $data[USERNAME]));
		$r = $this->CI->db->get(USERS);

		if($r->num_rows() != 0) {
			return FALSE;
		}

		$r = $this->CI->db->insert(USERS, array(
			USERNAME => $data[USERNAME],
			PASSWORD => $this->pass_hash($data[PASSWORD])
		));

		return $r;
	}

	public function change_current_password($password) {
		if($this->is_logged_in()) {
			$username = $this->CI->session->userdata(USER)[USERNAME];
			return $this->change_password($username, $password);
		}

		return FALSE;
	}

	public function change_password($username, $password) {
		$this->CI->db->where(array(USERNAME => $username));
		$r = $this->CI->db->update(USERS, array(PASSWORD => $this->pass_hash($password)));
		return $r;
	}

	private function pass_hash($password) {
		$p = password_hash($password, PASSWORD_BCRYPT);
		return $p;
	}

}


/*

	NEEDS TO BE DEFINED:
	
	define('ID', 'id');

	define('USERS', 'Users');
	define('USERNAME', 'username');
	define('PASSWORD', 'password');

	define('USER', 'user');


	DATABASE TABLE STRUCTURE:

	CREATE TABLE IF NOT EXISTS `Users` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `username` varchar(50) NOT NULL,
	  `password` varchar(64) NOT NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `username` (`username`)
	) ENGINE=InnoDB;

*/


/* End of file Auth.php */
/* Location: ./application/libraries/Auth.php */