<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once ("person.php");
class Employee extends Person {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function login($username, $password){
		$this->db->from('empleado');
		$this->db->join('persona', 'empleado.cedula = persona.cedula');
		$this->db->where('apodo', $username);
		$this->db->where('contrasena', md5($password));
		$this->db->where('eliminado', 0);

		$query = $this->db->get();
		if ($query->num_rows == 1) {
			$this->session->set_userdata('employee', $query->row());
			return $query->row();
		}

		return false;
	}

	public function logout(){
		$this->session->sess_destroy();
	}

	function is_logged_in()
	{
		return $this->session->userdata('employee')!=false;
	}

	function exists($employee_cod)
	{
		$this->db->from('empleado');
		$this->db->join('persona', 'empleado.cedula = persona.cedula');
		$this->db->where('empleado.cod_empleado',$employee_cod);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function get_logged_in_employee_info(){
		return $this->session->userdata('employee');
	}

	function get_allowed_modules($employee_cod = 0){
		$modules_allowed = array();
		$result = array();
		$this->db->select('nivel.modulos');
		$this->db->from('nivel');
		$this->db->join('empleado', 'empleado.cod_nivel = nivel.cod_nivel');
		$this->db->where('empleado.cod_empleado',$employee_cod);
		$this->db->where('empleado.eliminado', 0);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$modules_allowed = explode(',', $query->row()->modulos);
		}

		return $modules_allowed;
	}

	function has_permission($module_id, $employee_cod){
		$modules_allowed = array();
		$this->db->select('nivel.modulos');
		$this->db->from('nivel');
		$this->db->join('empleado', 'empleado.cod_nivel = nivel.cod_nivel');
		$this->db->where('empleado.cod_empleado',$employee_cod);
		$this->db->where('empleado.eliminado', 0);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$modules_allowed = explode(',', $query->row()->modulos);
			foreach ($modules_allowed as $key => $value) {
				//Fixed Modulos uni control
				$modules_allowed[$key] = (strpos($value, '-') !== FALSE) ? substr($value, 0,strpos($value, '-')): $value;
			}
		}

		return in_array($module_id, $modules_allowed);
	}

	function get_all_info(){
		$this->db->select('empleado.*, persona.*, nivel.nombre AS nivel');
		$this->db->from('empleado');
		$this->db->join('persona', 'persona.cedula = empleado.cedula');
		$this->db->join('nivel', 'empleado.cod_nivel = nivel.cod_nivel');
		$this->db->where('eliminado', 0);
		return $this->db->get();
	}

	function get_info($employee_id)
	{
		$this->db->from('empleado');
		$this->db->join('persona', 'persona.cedula = empleado.cedula');
		$this->db->where('empleado.cedula',$employee_id);
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $employee_id is NOT an employee
			$person_obj=parent::get_info(-1);

			//Get all the fields from employee table
			$fields = $this->db->list_fields('empleado');

			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$person_obj->$field='';
			}

			return $person_obj;
		}
	}

	function get_multiple_info($cod_empleado = null){
		if ( is_string($module_id) ) {
			$this->db->where('cod_empleado', $cod_empleado);
		}elseif( is_array($module_id) ){
			$this->db->where_in('cod_empleado', $cod_empleado);
			$this->db->order_by('orden', 'asc');
		}

		$query = $this->db->get();

		if ( $query->num_rows == 1) {
			return $query->row();
		}
		
		return $query;
	}

	function save(&$person_data, &$employee_data,$employee_id=0)
	{
		$success=FALSE;

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		if($idaux = parent::save($person_data,$employee_id))
		{
			if ( !$employee_id || !$this->exists($employee_id) )
			{
				if( $this->db->insert('empleado',$employee_data) ) {
					$success = $idaux;
				}
			}else{
				$this->db->where('cedula', $employee_id);
				if ($this->db->update('empleado',$employee_data)) {
					$success = TRUE;
				}
			}
		}

		$this->db->trans_complete();
		return $success;
	}

	function delete($person_id)
	{
		$success=false;

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		$this->db->where('cedula', $person_id);
		$this->db->where('empleado.eliminado', 0);
		$success = $this->db->update('empleado', array('eliminado' => 1));

		$this->db->trans_complete();
		return $success;
	}

	function search($cedula){
		$this->db->select('empleado.*, persona.*, nivel.nombre AS nivel');
		$this->db->from('empleado');
		$this->db->join('persona', 'persona.cedula = empleado.cedula');
		$this->db->join('nivel', 'empleado.cod_nivel = nivel.cod_nivel');
		$this->db->like("CONCAT(empleado.cedula, ' ', persona.nombre, ' ', persona.apellido)", $cedula);
		$result = $this->db->get();

		if ($result->num_rows()>0) {
			return $result;
		}

		return FALSE;
	}

}

/* End of file employee.php */
/* Location: ./application/models/employee.php */