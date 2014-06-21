<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Requests extends Secure_Area {

	private $default_title = 'Solicitud de ';

	public function __construct()
	{
		parent::__construct('requests');
		$this->load->model('Request');
		$this->load->model('Student');
		$this->load->model('University');
	}

	public function index(){
		$data['nota'] = array();
		$data['traslado'] = array();
		$data['constancia'] = array();

		$data['title'] = 'Procesar Solicitudes';
		$solicitudes = $this->Request->get_all();
		foreach ($solicitudes->result() as $solicitud) {
			$data[$solicitud->tipo][] = $solicitud;
		}
		// echo "<pre>";
		// var_dump($solicitudes);
		// echo "</pre>";
		$this->load->view('requests/manage', $data);
	}
	
	public function printing(){
		$this->load->view('prints/request');
	}

	public function notes(){
		$data['title'] = $this->default_title.'Notas';
		$data['type'] = 'notas';
		$this->load->view('requests/form',$data);
	}

	public function transfer(){
		$data['title'] = $this->default_title.'Traslado';
		$data['type'] = 'traslado';
		$this->load->view('requests/form', $data);
	}

	public function constancy(){
		$data['title'] = $this->default_title.'Constancia de Culminación';
		$data['type'] = 'constancia';
		$this->load->view('requests/form', $data);
	}

	public function save($request_id = false){
		$response = array('status'=>false, 'messagge'=>'Hubo un problema con la solicitud, Porfavor Inténtelo de nuevo!');

		$request_data['tipo'] = $this->input->post('tipo');
		$request_data['matricula'] = $this->Student->get_info($this->input->post('cedula'))->matricula;
		$request_data['fecha_solicitud'] = date('Y-m-d H:i:s');
		$request_data['semestre_solicitado'] = $this->input->post('semestre');
		$request_data['aldea_nueva'] = $this->input->post('aldea_nueva');
		$request_data['comentarios'] = $this->input->post('comentarios');
		if (@$result = $this->Request->save($request_data,$request_id)) {
			if (is_bool($result)) {
				if ($result) {
					$response = array('status'=>true, 'messagge'=>'Se ha actualizado la solicitud!');
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