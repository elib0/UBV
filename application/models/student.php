<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends Person {

	public $con;

	public function __construct()
	{
		parent::__construct();
		
	}

	function exists($student_id)
	{
		$this->db->from('estudiante');
		$this->db->join('persona', 'estudiante.cedula = persona.cedula');
		$this->db->where('estudiante.cedula',$student_id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function get_all_info(){
		$this->db->from('estudiante');
		$this->db->join('persona', 'persona.cedula = estudiante.cedula');
		return $this->db->get();
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

	function search($cedula){
		$this->db->from('estudiante');
		$this->db->join('persona', 'estudiante.cedula = persona.cedula');
		$this->db->like('estudiante.cedula', $cedula);
		$result = $this->db->get();

		if ($result->num_rows()>0) {
			return $result;
		}

		return false;
	}

	function save(&$person_data, &$student_data,$student_id=false)
	{
		$success=false;

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		if($idaux = parent::save($person_data,$student_id))
		{
			if (!$student_id or !$this->exists($student_id))
			{
				$student_data['person_id'] = $student_id = $person_data['person_id'];
				if( $this->db->insert('estudiante',$student_data) ) $success = $student_data['person_id'];
			}
			else
			{
				$this->db->where('person_id', $student_id);
				$success = $this->db->update('estudiante',$student_data);
			}
		}

		$this->db->trans_complete();
		return $success;
	}

}

/* End of file student.php */
/* Location: ./application/models/student.php */