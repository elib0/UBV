<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class No_Access extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index($module_id='')
	{
		$this->load->model('Module');
		$data['module_name']=$this->Module->get_module_name($module_id);
		$this->load->view('no_access', $data);
	}

}

/* End of file no_access.php */
/* Location: ./application/controllers/no_access.php */