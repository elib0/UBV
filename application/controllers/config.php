<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

class Config extends Secure_Area {

	public function __construct()
	{
		parent::__construct('config');
		$this->load->model('Configapp');

		$data['title'] = 'Configuracion del Sistema';
		$this->load->vars($data);
	}

	public function index()
	{
		$config_data = $this->Configapp->get_config();
		$data['sede'] = $config_data->name;
		$data['admin_email'] = $config_data->admin_email;
		$this->load->view('config', $data);
	}

	function save(){
		$response = array('status'=>FALSE,'messagge' => 'Imposible guardar los datos! Por favor inténtalo de nuevo');

		$data['name'] = $this->input->post('sede');
		$data['admin_email'] = $this->input->post('email');

		if ($this->Configapp->save($data)) {
			$response = array('status'=>TRUE,'messagge' => 'Informacion guardada correctamente!');
		}

		die(json_encode($response));
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
		$response = array('status'=>FALSE,'messagge' => 'Error en la carga del archivo!');
		$config['upload_path'] = 'temp/';
		$config['allowed_types'] = '*';
		$config['max_size']	= '2048';
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);

		if ( $this->upload->do_upload('backup') ){
			$this->load->helper('file'); // Cargamos helper de archivos

			$file_data = $this->upload->data();
			$sting = read_file($config['upload_path'].$file_data['orig_name']);

			//A continuacion limpiamos la cadena sql y la separamos a un arreglo
			$sting=preg_replace("/;\s*$/","", $sting);
			$sting=preg_replace("/;\r?\n/", ";#;;;", $sting);
			$querys=explode('#;;;',$sting);

			foreach ($querys as $query) {
				if ($query!=''){
					$this->Configapp->con->query($query);
				}
			}
			$response = array('status'=>TRUE,'messagge' => $file_data);
		}else{
			$response['messagge'] = $this->upload->display_errors();
		}

		die(json_encode($response));
	}

}

/* End of file config.php */
/* Location: ./application/controllers/config.php */