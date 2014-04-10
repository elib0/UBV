<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function login($username, $password){
		$this->db->from('empleado');
		$this->db->join('persona', 'empleado.cedula = persona.cedula');
		$this->db->where('apodo', $username);
		$this->db->where('contrasena', md5($password));

		$query = $this->db->get();
		if ($query->num_rows == 1) {
			$this->session->set_userdata('employee', $query->row());
			return $query->row();
		}

		return false;
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

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$modules_allowed = explode(',', $query->row()->modulos);
		}

		return in_array($module_id, $modules_allowed);
	}

}

/* End of file employee.php */
/* Location: ./application/models/employee.php */