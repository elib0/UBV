<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('Employee');
		$this->Employee->logout();
		redirect('login');
	}

}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */