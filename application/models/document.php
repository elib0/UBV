<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document extends CI_Model {

	public $con;

	public function __construct()
	{
		parent::__construct();
	}

	function exists($student_id)
	{
		$this->db->from('documentos');
		$this->db->where('matricula',$student_id);
		$this->db->limit(1);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	public function get_info($matricula = ''){
		$this->db->from('documentos');
		$this->db->where('matricula', $matricula);
		$this->db->limit(1);
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			$result = array();
			$fields = $this->db->list_fields('documentos');

			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$result[$field]=false;
			}

			return (Object)$result;
		}
	}

	function save(&$document_data,$student_id=0)
	{
		$success=FALSE;

		if ( !$this->exists($student_id) )
		{
			if( $this->db->insert('documentos',$document_data) ) {
				$success = 1;
			}
		}else{
			$this->db->set($document_data);
			$this->db->where('matricula', $student_id);
			if ($this->db->update('documentos')) {
				$success = TRUE;
			}
		}

		return $success;
	}

	function get_documents(){
		$fields = $this->db->list_fields('documentos');
		unset($fields[0]);
		return $fields;
	}

}

/* End of file document.php */
/* Location: ./application/models/document.php */