<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Students extends Secure_Area {

	public function __construct()
	{
		parent::__construct('students');
		$this->load->model('Student');
	}

	public function index()
	{
		$data['students'] = $this->Student->get_all_info();
		$this->load->view('student/manage', $data);
	}

	public function view($person_id = 0){
		$data['aldeas'] = array('0'=>'prueba');
		$data['pfg'] = array('0'=>'Informatica');
		$this->load->view('student/form', $data);
	}

	public function save($person_id = 0){
		$response = array('status'=>false, 'messagge'=>'Error al registrar al estudiante');

		$person_data['cedula'] = $this->input->post('cedula');
		$person_data['nombre'] = $this->input->post('nombre');
		$person_data['apellido'] = $this->input->post('apellido');
		$person_data['telefono'] = $this->input->post('telefono');
		$person_data['email'] = $this->input->post('correo');
		$person_data['direccion'] = $this->input->post('direccion');

		// $student_data['aldea'] = $this->input->post('aldea');
		$student_data['cod_mencion'] = $this->input->post('pfg');
		$student_data['cedula'] = $person_data['cedula'];
		

		if ($result = $this->Student->save($person_data, $student_data)) {
			if ($result > 0) {
				$response = array('status'=>true, 'messagge'=>'El estudiante se a registrado satisfactoriamente!');
			}elseif ($result) {
				$response = array('status'=>true, 'messagge'=>'Se han actualizado los datos del estudiante satisfactoriamente!');
			}
		}

		echo json_encode($response);
	}

}

/* End of file students.php */
/* Location: ./application/controllers/students.php */