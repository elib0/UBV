<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Reports extends Secure_Area {

	public function __construct()
	{
		parent::__construct('reports');
	}

	public function index()
	{
		$this->load->view('reports/list');
	}

	public function request($type='notes'){
		$this->load->view('requests/request', $data);
	}

	public function documents(){
		$this->load->view('requests/documents', $data);	
	}

	public function constancy(){
		$this->load->view('requests/request', $data);
	}
}

/* End of file reports.php */
/* Location: ./application/controllers/reports.php */