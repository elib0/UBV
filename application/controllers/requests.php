<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Requests extends Secure_Area {

	public function __construct()
	{
		parent::__construct('requests');
		$this->load->model('Request');
	}

	public function index($type='notes')
	{
		
	}

	public function notes(){
		echo 'Solicitud de notas';
	}

	public function transfer(){
		echo 'Solicitud de Traslado';
	}

}

/* End of file requests.php */
/* Location: ./application/controllers/requests.php */