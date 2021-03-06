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

	public function list_grade(){
		$this->db->select("
			estudiante.matricula,
			CONCAT(nombre, ' ', apellido) AS nombre,
			SUM(verificacion_academica+contancia_culminacion+
			trabajo_grado+
			consignacion_recaudos+
			fotografia+
			copia_cedula+
			partida_nacimiento+
			titulo_bachiller+
			fondo_negro+
			autenticidad_titulo+
			notas_bachillerato) AS total", FALSE
		);
		$this->db->from('documentos');
		$this->db->join('estudiante', 'estudiante.matricula = documentos.matricula');
		$this->db->join('persona', 'estudiante.cedula = persona.cedula');
		$this->db->group_by('estudiante.matricula');
		$this->db->having('total = 11');
		return $this->db->get();
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