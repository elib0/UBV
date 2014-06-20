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

	public function get_all(){
		$this->db->from('solicitud');
		$this->db->where('fecha_retiro', null);
		$this->db->where('status <=', 0);
		return $this->db->get();
	}

}

/* End of file request.php */
/* Location: ./application/models/request.php */