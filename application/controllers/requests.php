<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Requests extends Secure_Area {

	private $default_title = 'Solicitud de ';
	private $request_types = array('nota', 'traslado', 'constancia');
	private $transfer_reasons = array('CAMBIO DE RESIDENCIA', 'NUEVO EMPLEO', 'MOTIVO PERSONAL');
	private $constancy_reasons = array('CONTINUAR ESTUDIOS SUPERIORES', 'ASCENSO LABORAL', 'INSERCION LABORAL');

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
		$data['reasons'] = array();
		$data['title'] = $this->default_title.'Notas';
		$data['type'] = $this->request_types[0];
		$this->load->view('requests/form',$data);
	}

	public function transfer(){
		$data['reasons'] = array('CAMBIO DE RESIDENCIA', 'NUEVO EMPLEO', 'MOTIVO PERSONAL');
		$data['title'] = $this->default_title.ucwords($this->request_types[1]);
		$data['type'] = $this->request_types[1];
		$this->load->view('requests/form', $data);
	}

	public function constancy(){
		$data['reasons'] = $this->constancy_reasons;
		$data['title'] = $this->default_title.ucwords($this->request_types[2]).' de Culminación';
		$data['type'] = $this->request_types[2];
		$this->load->view('requests/form', $data);
	}

	public function view($request_id = 0){
		$this->load->helper('date');
		$data['request'] = $this->Request->get_info($request_id);
		$this->load->view('requests/detail', $data);
	}

	public function process($request_id = 0){
		$response = array('status'=>false, 'messagge'=>'Imposible procesar la solicitud!');
		

		if ($this->input->is_ajax_request()) {
			$request_data = array('status'=>1, 'fecha_retiro'=>date('Y-m-d H:i:s'));
			if ($result = $this->Request->save($request_data,$request_id)) {
				$request = $this->Request->get_info($request_id);

				//Cambios Especiales de solicitudes
				if ($request->tipo == 'traslado') {
					$student_data = array('cod_pfg'=>$request->aldea_nueva);
				}			

				$response = array('status'=>true, 'messagge'=>'Su solicitud fue procesada!', 'id'=>$request_id);
			}
		}

		echo json_encode($response);
	}

	public function printing($request_id = 0){
		$this->load->helper('date');
		$view_to_load = '';
		$data['request'] = $this->Request->get_info($request_id, TRUE);
		switch ($data['request']->tipo) {
			case 'nota':case 'traslado':
				$view_to_load = 'request';
				break;
			case 'constancia':
				$view_to_load = 'constancy';
				break;
		}

		$this->load->view('prints/'.$view_to_load, $data);
	}

	public function save(){
		$response = array('status'=>FALSE, 'messagge'=>'Hubo un problema con la solicitud, Porfavor Inténtelo de nuevo!');

		$student_data = $this->Student->get_info($this->input->post('cedula'));

		$request_data['tipo'] = $this->input->post('tipo');
		$request_data['matricula'] = $student_data->matricula;
		$request_data['fecha_solicitud'] = date('Y-m-d H:i:s');
		$request_data['semestre_solicitado'] = $this->input->post('semestre');
		if ($request_data['tipo'] == 'traslado') {
			$request_data['aldea_anterior'] = $student_data->cod_pfg;
			$request_data['aldea_nueva'] = $this->input->post('aldea_nueva');
		}
		if ( $this->input->post('razon') ) {
			$request_data['razon'] = $this->input->post('razon');
		}
		$request_data['comentarios'] = $this->input->post('comentarios');
		if (@$result = $this->Request->save($request_data,$request_id)) {
			if (is_bool($result)) {
				if ($result) {
					$response = array('status'=>TRUE, 'messagge'=>'Se ha actualizado la solicitud!');
				}
			}elseif ($result > 0) {
				$response = array('status'=>TRUE, 'messagge'=>'Su solicitud a sido procesada satisfactoriamente!', 'request_id'=>$result);
			}
		}

		echo json_encode($response);
	}

	public function search(){
		$student_id = $this->input->get('matricula');
		$data = array();
		foreach ($this->request_types as $value) {
			$data[$value] = '';
		}
		$requests = $this->Request->search($student_id);

		if ($requests->num_rows() > 0) {
			foreach ($requests->result() as $request) {
				$tr = '<tr>'.'<td class="number-format">'.$request->id.'</td>'.
				'<td>'.$request->nombre.'</td>'.
				'<td class="number-format">'.$request->fecha_solicitud.'</td>'; 
				if ($request->tipo == 'traslado') {
					$tr .= '<td>'.$request->aldea_anterior.'</td>'.
					'<td>'.$request->aldea_nueva.'</td>';
				}
				$tr .= '<td id="td-'.$request->id.'" class="number-format">'.$request->status.'</td>';
				//Botones
				$tr .= '<td class="number-format">'.
				anchor('requests/view/'.$request->id.'?height=350&width=530', 'Detalles', 'class="fancybox btn btn-info btn-xs"').
				anchor_popup('requests/printing/'.$request->id, 'Imprimir', array('class'=>'btn btn-warning btn-xs')).
				anchor('requests/process/'.$request->id, 'Procesar', 'id="btn-process-request" id="btn-process-request" class="btn btn-success btn-xs"').
				'</td></tr>';
				//FIN Botones
				$data[$request->tipo][] = $tr;
			}
		}
		die(json_encode($data));
	}

}

/* End of file requests.php */
/* Location: ./application/controllers/requests.php */