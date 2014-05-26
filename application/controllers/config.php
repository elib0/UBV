<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

class Config extends Secure_Area {

	public function __construct()
	{
		parent::__construct('config');
	}

	public function index()
	{
		$this->load->view('config');
	}

	function save(){

	}

	function backup(){
		$nombre_archivo = date('d-m-Y');
		$nombre_archivo .= '.sql';

		//Cargo utilidad de base de datos
		$this->load->dbutil();

		$backup =& $this->dbutil->backup(array('format'=>'sql')); 

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file('/backups/'.$nombre_archivo, $backup); 

		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($nombre_archivo, $backup);
	}

	function restore(){

	}

}

/* End of file config.php */
/* Location: ./application/controllers/config.php */