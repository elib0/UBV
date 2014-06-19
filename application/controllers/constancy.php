<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Constancy extends Secure_Area {

	public function __construct()
	{
		parent::__construct('constancy');

		$data['title'] = 'Contsancia de Culminacion';
		$this->load->vars($data);
	}

	public function index()
	{
		$this->load->view('constancies/form');
	}

	public function printing(){
		$this->load->view('prints/constancy');
	}

}

/* End of file constancy.php */
/* Location: ./application/controllers/constancy.php */