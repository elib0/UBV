<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Person extends CI_Model {

	public $con;

	public function __construct()
	{
		parent::__construct();
		$this->con = $this->db;
		
	}

	function exists($person_id)
	{
		$this->con->from('persona');
		$this->con->where('persona.cedula',$person_id);
		$query = $this->con->get();

		return ($query->num_rows()==1);
	}

	function get_info($person_id)
	{
		$query = $this->con->get_where('persona', array('cedula' => $person_id), 1);

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//create object with empty properties.
			$fields = $this->con->list_fields('persona');
			$person_obj = new stdClass;

			foreach ($fields as $field)
			{
				$person_obj->$field='';
			}

			return $person_obj;
		}
	}

	function save(&$person_data,$person_id=false)
	{
		if (!$person_id or !$this->exists($person_id))
		{
			if ($this->con->insert('persona',$person_data))
			{
				$person_data['cedula']=$this->con->insert_id();
				return $this->con->insert_id();
			}

			return false;
		}

		$this->con->where('cedula', $person_id);
		return $this->con->update('persona',$person_data);
	}

}

/* End of file people.php */
/* Location: ./application/models/people.php */