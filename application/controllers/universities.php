<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Universities extends Secure_Area {

	public function __construct()
	{
		parent::__construct('universities');
		$this->load->model('University');
	}

	public function index()
	{
		echo 'Info de las universidades';
	}

	public function pfg()
	{
		echo 'Materia';
	}

}

/* End of file universities.php */
/* Location: ./application/controllers/universities.php */