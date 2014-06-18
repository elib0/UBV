<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Documents extends Secure_Area {

	public function __construct()
	{
		parent::__construct('documents');
		$this->load->model('Document');
		$this->load->model('Student');

		$data['title'] = 'Consignacion de Recaudos';
		$this->load->vars($data);
	}

	public function index()
	{
		$data['documents'] = array(
			'Verificación Académica',
			'Carta o Constancia de Culminación del Trayecto Inicial',
			'Constancia del cumplimiento del Servicio Comunitario',
			'Constancia de Presentación del Trabajo Especial de Grado',
			'Comprobante de Consignación de recaudos',
			'Una Fotografía de frente tamaño carnet',
			'Copia de Cédula de Identidad tamaño carta  legible',
			'Partida de Nacimiento o Datos filiatorios',
			'Copia simple del Título de Bachiller',
			'Fondo Negro del Título de Bachiller',
			'Autenticidad del Título de Bachiller',
			'Notas de 1ero a 5to año'
		);
		$this->load->view('documents/manage', $data);
	}

	public function view(){
		$student = $this->Student->get_info( $this->input->post('cedula') );
		$result = $this->Document->get_info($student->matricula);

		die(json_encode($result));
	}

	public function save(){
		
	}

}

/* End of file documents.php */
/* Location: ./application/controllers/documents.php */