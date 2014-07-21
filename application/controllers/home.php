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
		$data['news']['students']['title'] = 'Bachilleres registardos';
		$data['news']['students']['count'] = $this->Student->get_all_info()->num_rows();
		$data['news']['students']['description'] = 'Cantidad de estudiantes registrados en el sistema(Click para ver mas detalles).';
		$data['news']['students']['url'] = 'students';

		$data['news']['requests']['title'] = 'Solicitudes no procesadas';
		$data['news']['requests']['count'] = $this->Request->get_all()->num_rows();
		$data['news']['requests']['description'] = 'Procesar Solicitudes pendientes o reimprimir solicitud(Notas, Traslados, Constancias de Culminacion, Consignacion de Recaudos).';
		$data['news']['requests']['url'] = 'requests';

		$data['news']['list_grade']['title'] = 'En lista de grado';
		$data['news']['list_grade']['count'] = $this->Document->list_grade()->num_rows();
		$data['news']['list_grade']['description'] = 'Posibles graduandos que tienes todos sus recaudos.';
		$data['news']['list_grade']['url'] = '';
		$this->load->view('home', $data);
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */