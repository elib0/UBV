<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Students extends Secure_Area {

	public function __construct()
	{
		parent::__construct('students');
		$this->load->model('Student');
		$this->load->model('University');

		$data['title'] = 'Administrar Estudiantes';
		$this->load->vars($data);
	}

	public function index()
	{
		$cedula = $this->input->post('cedula');
		$filtro = $this->input->post('request');

		if (!$cedula) {
			$data['students'] = $this->Student->get_all_info();
		}else{
			$data['students'] = $this->Student->search($cedula);
		}
		$this->load->view('student/manage', $data);
	}

	public function view($person_id = 0){
		$data['pfg'] = array();

		if ($query = $this->University->get_all_pfg()) {
			foreach ($query->result() as $pfg) {
				$data['pfg'][$pfg->cod_pfg] = $pfg->nombre_aldea.':'.$pfg->nombre_pfg;
			}
		}

		//Si es editar
		$data['student'] = $this->Student->get_info($person_id);

		$this->load->view('student/form', $data);
	}

	public function save($person_id = false){
		$response = array('status'=>false, 'messagge'=>'Error al registrar al estudiante');

		$person_data['cedula'] = $this->input->post('cedula');
		$person_data['nombre'] = $this->input->post('nombre');
		$person_data['apellido'] = $this->input->post('apellido');
		$person_data['telefono'] = $this->input->post('telefono');
		$person_data['email'] = $this->input->post('correo');
		$person_data['direccion'] = $this->input->post('direccion');

		// $student_data['aldea'] = $this->input->post('aldea');
		$student_data['matricula'] = date("dmhis");
		$student_data['cod_pfg'] = $this->input->post('pfg');
		$student_data['cedula'] = $person_data['cedula'];
		$student_data['cod_cohorte'] = 1;
		

		if (@$result = $this->Student->save($person_data, $student_data,$person_data['cedula'])) {
			if (is_bool($result)) {
				if ($result) {
					$response = array('status'=>true, 'messagge'=>'Se han actualizado los datos del estudiante satisfactoriamente!');
				}
			}elseif ($result > 0) {
				$response = array('status'=>true, 'messagge'=>'El estudiante se a registrado satisfactoriamente!');
			}
		}

		echo json_encode($response);
		// var_dump($student_data);
	}

	public function suggest(){
		$students = $this->Student->search($this->input->get('term'));
		$result = array();

		if ($students) {
			foreach ($students->result() as $row) {
				$result[] = array('id'=>$row->cedula, 'text'=>$row->apellido.' '.$row->nombre, 'student_cod'=>$row->matricula, 'pfg'=>$row->cod_pfg);
			}
		}

		die(json_encode($result));
	}

}

/* End of file students.php */
/* Location: ./application/controllers/students.php */