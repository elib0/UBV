<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

class Home extends Secure_Area {

	public function __construct()
	{
		parent::__construct('home');
		$this->load->model('Student');
		$this->load->model('Request');

		$data['title'] = 'Inicio';
		$this->load->vars($data);
	}

	public function index()
	{
		$data['notifications']['students']['title'] = 'Bachilleres registardos';
		$data['notifications']['students']['count'] = $this->Student->get_all_info()->num_rows();
		$data['notifications']['students']['url'] = 'students';

		$data['notifications']['requests']['title'] = 'Solicitudes no procesadas';
		$data['notifications']['requests']['count'] = $this->Request->get_all()->num_rows();
		$data['notifications']['requests']['url'] = 'requests';
		$this->load->view('home', $data);
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */