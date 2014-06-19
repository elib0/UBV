<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Reports extends Secure_Area {

	public function __construct()
	{
		parent::__construct('reports');
		$data['title'] = 'Reportes';
		$this->load->vars($data);
	}

	public function index()
	{
		$this->load->view('reports/list');
	}
}

/* End of file reports.php */
/* Location: ./application/controllers/reports.php */