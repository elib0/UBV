<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Cohort extends Secure_Area {

	public function __construct()
	{
		parent::__construct('cohort');
	}

	public function index()
	{
		
	}

	public function view(){
		$this->load->view('cohorts/form.php');
	}

}

/* End of file cohort.php */
/* Location: ./application/controllers/cohort.php */