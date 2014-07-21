<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Reports extends Secure_Area {

	public function __construct()
	{
		parent::__construct('reports');
		$this->load->model('Request');
		$this->load->model('University');
		$this->load->model('Document');
		$this->load->model('Report');
		$data['title'] = 'Reportes';
		$this->load->vars($data);
	}

	public function index()
	{
		$data['atts'] = array(
              'width'      => '1024',
              'height'     => '768',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
        );
		$this->load->view('reports/list', $data);
	}

	public function detail($type='nota'){
		$data['head_details'] = array();
		$data['data_details'] = array();
		$data['header_config'] = array('title'=>'Solicitudes de Notas');
		switch ($type) {
			case 'nota':
				$data['head_details'] = array('Semestre Solicitado');
				$data['data_details'] = array('semestre_solicitado');
				break;
			case 'traslado':
				$transfer_reasons = array('CAMBIO DE RESIDENCIA', 'NUEVO EMPLEO', 'MOTIVO PERSONAL');
				$data['head_details'] = array('Aldea Anterior', 'Aldea Nueva', 'Razon');
				$data['data_details'] = array('aldea_anterior', 'aldea_nueva', 'razon');
				$data['header_config']['title'] = 'Solicitudes de Traslados';
				break;
			case 'constancia':
				$constancy_reasons = array('CONTINUAR ESTUDIOS SUPERIORES', 'ASCENSO LABORAL', 'INSERCION LABORAL');
				$data['head_details'] = array('Razon');
				$data['data_details'] = array('razon');
				$data['header_config']['title'] = 'Solicitudes de Constancias de Notas';
				break;
			case 'grado':
				$data['header_config']['title'] = 'Lista de Grado';
				break;
		}

		if ($type != 'grado') {
			$data['requests'] = $this->Request->get_by_type($type);
			$this->load->view('reports/detail', $data);
		}else{
			$data['requests'] = $this->Document->list_grade(true);
			$this->load->view('reports/grade_list', $data);
		}
	}

	public function graphical(){
		$data['header_config']['main_title'] = 'Gráfico/Estadístico';
		$mod = $this->input->get('mod');
		switch ($type) {
			case '1':
				$data['header_config']['title'] = 'Solicitudes Generadas Vs Procesadas';
				break;
			case '3':
				$data['header_config']['title'] = 'Solicitudes por municipios';
				break;
		}
		$data['type'] = $mod;
		$this->load->view('reports/graphical', $data);
	}

	public function ajax_graphical(){
		if ($this->input->is_ajax_request()) {
			$type = $this->input->post('type');
			$chart_type = 'pie';
			$data = array();
			$colors = array(
				array('#F7464A','#FF5A5E'),
				array('#46BFBD','#5AD3D1'),
				array('#FDB45C','#FFC870'),
				array('#949FB1','#A8B3C5'),
				array('#4D5360','#616774'),
				array('#FF77FF','#FF99FF'),
				array('#FFFF77','#FFFFAA')
			);

			switch ($type) {
				case '1':
					$label = 'Sin Procesar';
					$color ='#46BFBD';
					$highlight ='#5AD3D1';
					$query = $this->Report->request_diff();
					foreach ($query->result() as $value) {
						if ($value->status == 1) {
							$label = 'Procesadas';
							$color = '#F7464A';
							$highlight ='#FF5A5E';
						}

						$data[] = array(
							'value'=>$value->cuenta,
							'color'=>$color,
							'highlight'=>$highlight,
							'label'=>$label
						);
					}
					break;
				case '2':
					# code...
					break;
				case '3':
					$query = $this->Report->request_by_univercity();
					foreach ($query->result() as $value) {
						$i = rand(1,count($colors));
						$data[] = array(
							'value'=>$value->cuenta,
							'color'=>$colors[$i][0],
							'highlight'=>$colors[$i][1],
							'label'=>$value->nombre.': solicitudes'
						);
					}
					break;
			}
			$response = array(
				'type'=>$chart_type,
				'data'=>$data
			);

			die( json_encode($response) );
		}

		redirect('home');
	}
}

/* End of file reports.php */
/* Location: ./application/controllers/reports.php */