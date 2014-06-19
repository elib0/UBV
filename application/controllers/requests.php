<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Requests extends Secure_Area {

	private $aldeas = array();
	private $default_title = 'Solicitud de ';

	public function __construct()
	{
		parent::__construct('requests');
		$this->load->model('Request');
		$this->load->model('Student');
		$this->load->model('University');
		$this->aldeas = $this->University->get_all_aldeas();
	}

	// public function index($type='notes')
	// {
		
	// }

	public function notes(){
		if ($this->aldeas) {
			foreach ($this->aldeas->result() as $aldea) {
				$data['aldeas'][$aldea->cod_aldea] = $aldea->nombre;
			}
		}
		$data['title'] = $this->default_title.'Notas';
		$this->load->view('requests/form',$data);
	}

	public function transfer(){
		if ($this->aldeas) {
			foreach ($this->aldeas->result() as $aldea) {
				$data['aldeas'][$aldea->cod_aldea] = $aldea->nombre;
			}
		}
		$data['title'] = $this->default_title.'Traslado';
		$this->load->view('requests/form', $data);
	}

	public function save($request_id = false){
		$response = array('status'=>false, 'messagge'=>'Hubo un problema con la solicitud, Porfavor Inténtelo de nuevo!');

		$request_data['tipo'] = $this->input->post('tipo');
		$request_data['matricula'] = $this->Student->get_info($this->input->post('cedula'))->matricula;
		$request_data['fecha_solicitud'] = date('Y-m-d H:i:s');
		$request_data['semestre_solicitado'] = $this->input->post('semestre');
		// $request_data['anterior'] = $this->input->post('anterior');
		$request_data['comentarios'] = $this->input->post('comentarios');
		if ($result = $this->Request->save($request_data,$request_id)) {
			if (is_bool($result)) {
				if ($result) {
					$response = array('status'=>true, 'messagge'=>'Se han actualizado los datos del empleado satisfactoriamente!');
				}
			}elseif ($result > 0) {
				$response = array('status'=>true, 'messagge'=>'Su solicitud a sido procesada satisfactoriamente!');
			}
		}

		echo json_encode($response);
	}

}

/* End of file requests.php */
/* Location: ./application/controllers/requests.php */