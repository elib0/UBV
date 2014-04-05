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
		$this->con->from('empleado');
		$this->db->join('persona', 'empleado.cedula = persona.cedula');
		$this->con->where('empleado.cod_empleado',$employee_cod);
		$query = $this->con->get();

		return ($query->num_rows()==1);
	}

}

/* End of file employee.php */
/* Location: ./application/models/employee.php */