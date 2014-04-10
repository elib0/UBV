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
		$nombre_archivo .= '.gz';
		// Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup(); 

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file('/path/to/'.$nombre_archivo, $backup); 

		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($nombre_archivo, $backup);
	}

}

/* End of file config.php */
/* Location: ./application/controllers/config.php */