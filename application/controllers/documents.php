<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Documents extends Secure_Area {

	public function __construct()
	{
		parent::__construct('documents');
		$this->load->model('Document');
		$this->load->model('Student');

		$data['title'] = 'Administrar Usuarios';
		$data['config_title'] = $this->Configapp->get_config()->name;
		$data['show_menu'] = true;
		$data['system_message'] = '';
		$this->load->vars($data);
	}

	public function index()
	{
		$this->load->view('documents/manage');
	}

	public function view(){
		$student = $this->Student->get_info( $this->input->post('cedula') );
		$result = $this->Document->get_info($student->matricula);

		die(json_encode($result));
	}

	public function save(){
		
	}

}

/* End of file documents.php */
/* Location: ./application/controllers/documents.php */