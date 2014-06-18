<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Universities extends Secure_Area {

	public function __construct()
	{
		parent::__construct('universities');
		$this->load->model('University');

		$data['title'] = 'Administracion de aldeas';
		$this->load->vars($data);
	}

	public function index()
	{
		$data['municipios'] = array();
		$data['aldeas'] = array();
		if ($query = $this->University->get_all_municipios()) {
			foreach ($query->result() as $municipio) {
				$data['municipios'][$municipio->cod_municipio] = $municipio->nombre_municipio;
			}
		}
		if ($query = $this->University->get_all_aldeas()) {
			foreach ($query->result() as $aldea) {
				$data['aldeas'][$aldea->cod_aldea] = $aldea->nombre;
			}
		}
		$this->load->view('universities/manage', $data);
	}

	public function save($type='aldea'){
		$response = array('status'=>FALSE,'messagge' => 'Imposible guardar los datos! Por favor inténtalo de nuevo');

		$data['nombre'] = $this->input->post('nombre');
		if ($type === 'aldea') {
			$data['direccion'] = $this->input->post('direccion');
			$data['cod_municipio'] = $this->input->post('municipio');
			if ($this->University->save_aldea($data)) {
				$response = array('status'=>TRUE,'messagge' => 'Aldea Registrada Correctamente!');
			}
		}elseif($type === 'pfg'){
			$data['descripcion'] = $this->input->post('descripcion');
			$data['cod_aldea'] = $this->input->post('aldea');
			if ($this->University->save_pfg($data)) {
				$response = array('status'=>TRUE,'messagge' => 'Pfg Registrada en la aldea: '.$data['cod_aldea'].' Correctamente!');
			}
		}

		die(json_encode($response));

	}

	public function pfg()
	{
		echo 'Materia';
	}

}

/* End of file universities.php */
/* Location: ./application/controllers/universities.php */