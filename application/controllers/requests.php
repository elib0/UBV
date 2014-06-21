<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Requests extends Secure_Area {

	private $default_title = 'Solicitud de ';
	private $request_types = array('nota', 'traslado', 'constancia');

	public function __construct()
	{
		parent::__construct('requests');
		$this->load->model('Request');
		$this->load->model('Student');
		$this->load->model('University');
	}

	public function index(){
		//Inicializacion de Arreglos por tipo de solicitud
		foreach ($this->request_types as $value) {
			$data[$value] = array();
		}

		$data['title'] = 'Procesar Solicitudes';
		$solicitudes = $this->Request->get_all();
		$data['num_solicitudes'] = $solicitudes->num_rows();
		foreach ($solicitudes->result() as $solicitud) {
			$data[$solicitud->tipo][] = $solicitud;
		}
		$this->load->view('requests/manage', $data);
	}

	public function notes(){
		$data['title'] = $this->default_title.'Notas';
		$data['type'] = $this->request_types[0];
		$this->load->view('requests/form',$data);
	}

	public function transfer(){
		$data['title'] = $this->default_title.ucwords($this->request_types[1]);
		$data['type'] = $this->request_types[1];
		$this->load->view('requests/form', $data);
	}

	public function constancy(){
		$data['title'] = $this->default_title.ucwords($this->request_types[2]).' de Culminación';
		$data['type'] = $this->request_types[2];
		$this->load->view('requests/form', $data);
	}

	public function view($request_id = 0){
		$this->load->helper('date');
		$data['service'] = $this->Request->get_info($request_id);
		$this->load->view('requests/detail', $data);
	}

	public function process($request_id = 0){
		$response = array('status'=>false, 'messagge'=>'Imposible procesar la solicitud!');

		if ($this->input->is_ajax_request()) {
			$request_data = array('status'=>1, 'fecha_retiro'=>date('Y-m-d H:i:s'));
			if ($result = $this->Request->save($request_data,$request_id)) {
				$response = array('status'=>true, 'messagge'=>'Su solicitud fue procesada!', 'id'=>$request_id);
			}
		}

		echo json_encode($response);
	}

	public function printing($request_id = 0){
		$view_to_load = '';
		$data['solicitud'] = $this->Request->get_info($request_id, TRUE);
		switch ($data['service']->tipo) {
			case 'note':case 'traslado':
				$view_to_load = 'request';
			case 'constancia':
				$view_to_load = 'constancy';
				break;
		}

		$this->load->view('prints/'.$view_to_load, $data);
	}

	public function save(){
		$response = array('status'=>FALSE, 'messagge'=>'Hubo un problema con la solicitud, Porfavor Inténtelo de nuevo!');

		$request_data['tipo'] = $this->input->post('tipo');
		$request_data['matricula'] = $this->Student->get_info($this->input->post('cedula'))->matricula;
		$request_data['fecha_solicitud'] = date('Y-m-d H:i:s');
		$request_data['semestre_solicitado'] = $this->input->post('semestre');
		$request_data['aldea_nueva'] = $this->input->post('aldea_nueva');
		$request_data['comentarios'] = $this->input->post('comentarios');
		if (@$result = $this->Request->save($request_data,$request_id)) {
			if (is_bool($result)) {
				if ($result) {
					$response = array('status'=>TRUE, 'messagge'=>'Se ha actualizado la solicitud!');
				}
			}elseif ($result > 0) {
				$response = array('status'=>TRUE, 'messagge'=>'Su solicitud a sido procesada satisfactoriamente!');
			}
		}

		echo json_encode($response);
	}

}

/* End of file requests.php */
/* Location: ./application/controllers/requests.php */