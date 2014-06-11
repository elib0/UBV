<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Requests extends Secure_Area {

	private $aldeas = array();

	public function __construct()
	{
		parent::__construct('requests');
		// $this->load->model('Request');
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
		$data['title'] = 'Notas';
		$this->load->view('requests/form',$data);
	}

	public function transfer(){
		if ($this->aldeas) {
			foreach ($this->aldeas->result() as $aldea) {
				$data['aldeas'][$aldea->cod_aldea] = $aldea->nombre;
			}
		}
		$data['title'] = 'Traslado';
		$this->load->view('requests/form', $data);
	}

	public function save(){
		$data['stundet_matricula'] = $this->Student->get_info($this->input->post('cedula'))->matricula;
		$data['tipo'] = $this->input->post('tipo');
		$data['semestre_solicitado'] = $this->input->post('semestre');
		$data['anterior'] = $this->input->post('anterior');
		$data['comentarios'] = $this->input->post('comentarios');
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
	}

}

/* End of file requests.php */
/* Location: ./application/controllers/requests.php */