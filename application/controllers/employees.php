<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");
class Employees extends Secure_Area {

	public function __construct()
	{
		parent::__construct('employees');
		$this->load->model('Employee');

		$data['title'] = 'Administrar Empleados';
		$this->load->vars($data);
	}

	public function index()
	{
		$cedula = $this->input->post('cedula');

		if (!$cedula) {
			$data['employees'] = $this->Employee->get_all_info();
		}else{
			$data['employees'] = $this->Employee->search($cedula);
		}
		$this->load->view('employees/manage', $data);
	}

	public function view($person_id = 0){
		//Si es editar
		$data['employee'] = $this->Employee->get_info($person_id);
		$data['levels'] = array();

		foreach ($this->Configapp->get_all_levels() as $level) {
			$data['levels'][$level->cod_nivel] = $level->nombre;
		}

		$this->load->view('employees/form', $data);
	}

	public function save($person_id = false){
		$response = array('status'=>false, 'messagge'=>'Error al registrar al empleado');

		$person_data['cedula'] = $this->input->post('cedula');
		$person_data['nombre'] = $this->input->post('nombre');
		$person_data['apellido'] = $this->input->post('apellido');
		$person_data['telefono'] = $this->input->post('telefono');
		$person_data['email'] = $this->input->post('correo');
		$person_data['direccion'] = $this->input->post('direccion');

		$employee_data['apodo'] = $this->input->post('apodo');
		$employee_data['contrasena'] = md5($this->input->post('contrasena'));
		$employee_data['cod_nivel'] = $this->input->post('nivel');
		$employee_data['cedula'] = $person_data['cedula'];
		$employee_data['eliminado'] = ( $this->input->post('estado') ) ? '0' : '1';

		if (@$result = $this->Employee->save($person_data, $employee_data,$person_id)) {
			if (is_bool($result)) {
				if ($result) {
					$response = array('status'=>true, 'messagge'=>'Se han actualizado los datos del empleado satisfactoriamente!');
				}
			}elseif ($result > 0) {
				$response = array('status'=>true, 'messagge'=>'El empleado se a registrado satisfactoriamente!');
			}
		}

		echo json_encode($response);
	}

	public function delete($person_id=''){
		$response = array('status'=>false, 'messagge'=>'Imposible deshabilitar al usuario. Contacte al administrador del sistema!');
		if ($response['status'] = $this->Employee->delete($person_id)) {
			$response['messagge'] = 'Se a deshabilitado el usuario correctamente!';
		}

		die(json_encode( $response ));
	}

	public function suggest(){
		$employees = $this->Employee->search($this->input->get('term'));
		$result = array();

		if ($employees) {
			foreach ($employees->result() as $row) {
				$result[] = array('id'=>$row->cedula, 'text'=>$row->apellido.' '.$row->nombre);
			}
		}

		die(json_encode($result));
	}

}

/* End of file students.php */
/* Location: ./application/controllers/students.php */