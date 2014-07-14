<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("secure_area.php");

class Home extends Secure_Area {

	public function __construct()
	{
		parent::__construct('home');
		$this->load->model('Student');
		$this->load->model('Request');
		$this->load->model('Document');

		$data['title'] = 'Inicio';
		$this->load->vars($data);
	}

	public function index()
	{
		$data['notifications']['students']['title'] = 'Bachilleres registardos';
		$data['notifications']['students']['count'] = $this->Student->get_all_info()->num_rows();
		$data['notifications']['students']['description'] = 'Cantidad de estudiantes registrados en el sistema(Click para ver mas detalles).';
		$data['notifications']['students']['url'] = 'students';

		$data['notifications']['requests']['title'] = 'Solicitudes no procesadas';
		$data['notifications']['requests']['count'] = $this->Request->get_all()->num_rows();
		$data['notifications']['requests']['description'] = 'Procesar Solicitudes pendientes o reimprimir solicitud(Notas, Traslados, Constancias de Culminacion, Consignacion de Recaudos).';
		$data['notifications']['requests']['url'] = 'requests';

		$data['notifications']['list_grade']['title'] = 'En lista de grado';
		$data['notifications']['list_grade']['count'] = count($this->Document->list_grade());
		$data['notifications']['list_grade']['description'] = 'Posibles graduandos que tienes todos sus recaudos.';
		$data['notifications']['list_grade']['url'] = '';
		$this->load->view('home', $data);
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */