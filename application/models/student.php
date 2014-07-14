<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends Person {

	public $con;

	public function __construct()
	{
		parent::__construct();
		
	}

	function exists($person_id)
	{
		$this->db->from('estudiante');
		$this->db->where('cedula',$person_id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function get_all_info(){
		$this->db->from('estudiante');
		$this->db->join('persona', 'persona.cedula = estudiante.cedula');
		return $this->db->get();
	}

	function count_all(){
		$this->db->from('estudiante');
		$this->db->join('persona', 'persona.cedula = estudiante.cedula');
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_info($student_id)
	{
		$this->db->from('estudiante');
		$this->db->join('persona', 'persona.cedula = estudiante.cedula');
		$this->db->where('estudiante.cedula',$student_id);
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $student_id is NOT an employee
			$person_obj=parent::get_info(-1);

			//Get all the fields from employee table
			$fields = $this->db->list_fields('estudiante');

			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$person_obj->$field='';
			}

			return $person_obj;
		}
	}

	function get_student_requests($student_id){
		$this->db->from('solicitud');
		$this->db->join('estudiante', 'estudiante.matricula = solicitud.matricula');
		$this->db->where('estudiante.cedula',$student_id);
		return $this->db->get();
	}

	function search($cedula, $filtro = false){
		$this->db->select('estudiante.*, persona.*, pfg.nombre AS pfg, aldea.cod_aldea, aldea.nombre AS aldea');
		$this->db->from('estudiante');
		$this->db->join('persona', 'estudiante.cedula = persona.cedula');
		$this->db->join('pfg', 'estudiante.cod_pfg = pfg.cod_pfg');
		$this->db->join('aldea', 'pfg.cod_aldea = aldea.cod_aldea');
		if ($filtro) {
			$this->db->join('solicitud', 'estudiante.matricula = solicitud.matricula');
		}
		$this->db->like("CONCAT(persona.cedula, ' ', persona.nombre, ' ', persona.apellido)", $cedula);
		$result = $this->db->get();

		if ($result->num_rows()>0) {
			return $result;
		}

		return FALSE;
	}

	function can_transfer($student_id=false){
		$this->db->from('solicitud');
		$this->con->join('estudiante', 'estudiante.matricula = solicitud.matricula');
		$this->db->where('solicitud.tipo', 'nota');
		//$this->db->where('solicitud.status', 1);
		$this->db->where('estudiante.matricula', $student_id);
		$this->db->limit(1);
		$query = $this->db->get();

		return ($query->num_rows() > 0);
	}

	function save(&$person_data, &$student_data,$person_id=false)
	{
		$success=FALSE;

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		if($idaux = parent::save($person_data,$person_id))
		{
			if ( !$person_id || !$this->exists($person_id) )
			{
				if( $this->db->insert('estudiante',$student_data) ) {
					$success = $idaux;
				}
			}else{
				$this->db->where('cedula', $person_id);
				if ($this->db->update('estudiante',$student_data)) {
					$success = TRUE;
				}else{
					$success = FALSE;
				}
			}
		}

		$this->db->trans_complete();
		return $success;
	}

}

/* End of file student.php */
/* Location: ./application/models/student.php */