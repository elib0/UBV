<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

class Home extends Secure_Area {

	public function __construct()
	{
		parent::__construct('home');
	}

	public function index()
	{
		$this->load->view('home');
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */