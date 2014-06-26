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
		$data['univercities'] = $this->University->get_all_aldeas();
		$this->load->view('universities/manage', $data);
	}

	public function view($cod_univercity = false){
		$data['municipios'] = array();
		$data['pfgs'] = '';
		if ($cod_univercity) {
			$data['univercity'] =  $this->University->get_aldea_info($cod_univercity);
			$pfgs = $this->University->get_aldea_pfgs($cod_univercity);
			foreach ($pfgs->result() as $pfg) {
				$data['pfgs'] .= $pfg->nombre.',';
			}
			$data['pfgs'] = trim($data['pfgs'],',');
		}else{
			$data['univercity'] = (Object)array('nombre'=>'','direccion'=>'','cedula_coordinador'=>'', 'cod_municipio'=>'', 'pfgs'=>'');
		}
		if ($query = $this->University->get_all_municipios()) {
			foreach ($query->result() as $municipio) {
				$data['municipios'][$municipio->cod_municipio] = $municipio->nombre_municipio;
			}
		}
		$this->load->view('universities/form', $data);
	}

	public function suggest(){
		$universities = $this->University->search($this->input->get('term'));
		$result = array();

		if ($universities) {
			foreach ($universities->result() as $row) {
				$result[] = array('id'=>$row->cod_aldea, 'text'=>'Municipio:'.$row->nombre_municipio.':'.$row->nombre, 'aldea'=>$row->nombre);
			}
		}

		die(json_encode($result));
	}

	public function suggest_pfg(){
		$pfgs = $this->University->search_pfg($this->input->get('term'));
		$result = array();

		if ($pfgs) {
			foreach ($pfgs->result() as $row) {
				$result[] = array('id'=>$row->cod_pfg, 'text'=>$row->nombre, 'aldea'=>$row->nombre_aldea);
			}
		}

		die(json_encode($result));
	}

	public function save($type='aldea'){
		$response = array('status'=>FALSE,'messagge' => 'Imposible registrar la aldea! Por favor inténtalo de nuevo');

		$data_aldea['nombre'] = $this->input->post('nombre');
		$data_aldea['direccion'] = $this->input->post('direccion');
		$data_aldea['cod_municipio'] = $this->input->post('municipio');
		$data_aldea['cedula_coordinador'] = $this->input->post('coordinador');
		$pfgs = explode(',', $this->input->post('pfgs'));
		if (@$cod_aldea = $this->University->save_aldea($data_aldea)) {
			$response = array('status'=>TRUE,'messagge' => 'Aldea Registrada Correctamente!');
			foreach ($pfgs as $pfg) {
				$data_pfg['nombre'] = $pfg;
				$data_pfg['cod_aldea'] = $cod_aldea;
				$this->University->save_pfg($data_pfg);
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