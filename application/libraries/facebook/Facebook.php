<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'vendor/autoload.php');

use Facebook\Helpers\FacebookRedirectLoginHelper;
use Facebook\Exceptions\FacebookSDKException;

class Facebook {

	private $ci;
	private $fb;

	public function __construct() {

		$this->ci =& get_instance();

		$this->fb = new Facebook\Facebook($this->ci->config->item('facebook'));
	}

	public function get_user() {

		$helper = $this->fb->getJavaScriptHelper();

		if(!$this->ci->session->userdata('fb_access_token')) {
			$access_token = $helper->getAccessToken();
			$this->ci->session->set_userdata('fb_access_token', $access_token);
		}

		else {
			$access_token = $this->ci->session->userdata('fb_access_token');
		}

		try {
			$user = $this->fb->get('/me?fields=id,name,first_name,last_name', $access_token);
		}

		catch(Exception $ex) {}

		if(isset($user)) {
			return $user;
		}

		$this->ci->session->unset_userdata('fb_access_token');
		return FALSE;
	}

	public function get_link_image_id() {

		try {
			$sr = $this->fb->getPageTabHelper()->getSignedRequest();

			if($sr) {
				$pl = $sr->getPayload();
				if(isset($pl['app_data'])) {
					return $pl['app_data'];
				}
			}

			return FALSE;
		}

		catch(Exception $e) {
			return FALSE;
		}
	}

	public function first_time() {
		try {
			$helper = $this->fb->getPageTabHelper();
			$access_token = $helper->getAccessToken();

			if($access_token) {
				return FALSE;
			}
		}

		catch(Exception $e) {}

		return TRUE;
	}
}