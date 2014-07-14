<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request extends CI_Model {

	public $con;

	public function __construct()
	{
		parent::__construct();
	}

	function exists($request_id)
	{
		$this->db->from('solicitud');
		$this->db->where('id',$request_id);
		$this->db->limit(1);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	public function save(&$request_data, $request_id = 0){
		$success=FALSE;

		if ( !$request_id || !$this->exists($request_id) )
		{
			if( $this->db->insert('solicitud',$request_data) ) {
				$success = $this->db->insert_id();
			}
		}else{
			$this->db->where('id', $request_id);
			$success = $this->db->update('solicitud',$request_data);
		}

		return $success;
	}

	public function count_all(){
		$this->db->from('solicitud');
		$this->db->where('fecha_retiro', null);
		$this->db->where('status <=', 0);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_all($limit = 30){
		$this->db->select("solicitud.*, CONCAT(nombre, ' ', apellido ) AS nombre", FALSE);
		$this->db->from('solicitud');
		$this->db->join('estudiante', 'solicitud.matricula = estudiante.matricula');
		$this->db->join('persona', 'persona.cedula = estudiante.cedula');
		$this->db->where('fecha_retiro', null);
		$this->db->where('status <=', 0);
		$this->db->order_by('fecha_solicitud', 'desc');
		$this->db->limit($limit);
		return $this->db->get();
	}

	public function search($student_id = 0){
		$this->db->select("solicitud.*, CONCAT(nombre, ' ', apellido ) AS nombre", FALSE);
		$this->db->from('solicitud');
		$this->db->join('estudiante', 'solicitud.matricula = estudiante.matricula');
		$this->db->join('persona', 'persona.cedula = estudiante.cedula');
		$this->db->where('solicitud.matricula', $student_id);
		$this->db->order_by('fecha_solicitud', 'desc');
		return $this->db->get();
	}

	public function get_info($request_id = 0, $extend_data=FALSE){
		$select = ($extend_data) ? ',pfg.nombre AS nombre_pfg, aldea.nombre AS nombre_aldea' : '' ;
		$this->db->select("solicitud.*,estudiante.*, CONCAT(persona.nombre, ' ', persona.apellido ) AS nombre_estudiante, telefono, email".$select, FALSE);
		$this->db->from('solicitud');
		$this->db->join('estudiante', 'solicitud.matricula = estudiante.matricula');
		$this->db->join('persona', 'persona.cedula = estudiante.cedula');
		if ($extend_data) {
			$this->db->join('pfg', 'pfg.cod_pfg = estudiante.cod_pfg');
			$this->db->join('aldea', 'pfg.cod_aldea = aldea.cod_aldea');
		}
		$this->db->where('solicitud.id', $request_id)->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		}

		return FALSE;
	}

}

/* End of file request.php */
/* Location: ./application/models/request.php */