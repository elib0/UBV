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
		$response = array('status'=>FALSE,'messagge' => $this->upload->display_errors());
		$config['upload_path'] = 'temp/';
		$config['allowed_types'] = '*';
		$config['max_size']	= '2048';
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload('backup')){
			$this->load->helper('file'); // Cargamos helper de archivos

			$file_data = $this->upload->data();
			$sting = read_file($config['upload_path'].$file_data['orig_name']);

			//A continuacion limpiamos la cadena sql y la separamos a un arreglo
			$sting=preg_replace("/;\s*$/","", $sting);
			$sting=preg_replace("/;\r?\n/", ";#;;;", $sting);
			$querys=explode('#;;;',$sting);

			foreach ($querys as $query) {
				if ($query!=''){
					// $result = mysql_query($query,$conn); //Ejecuta 
				}
			}
			$response = array('status'=>TRUE,'messagge' => $file_data);
		}

		die(json_encode($response));
	}

}

/* End of file config.php */
/* Location: ./application/controllers/config.php */