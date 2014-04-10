<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	function get_modules_info($module_id = null){
		$this->db->from('modulo');

		if ( is_string($module_id) ) {
			$this->db->where('modulo_id', $module_id);
		}elseif( is_array($module_id) ){
			$this->db->where_in('modulo_id', $module_id);
			$this->db->order_by('orden', 'asc');
		}
		
		$query = $this->db->get();

		if ( $query->num_rows == 1) {
			return $query->row();
		}
		
		return $query;
	}

	function get_module_name($module_id=''){
		$this->db->select('nombre');
		$this->db->from('modulo');
		$this->db->where('modulo_id', $module_id);
		$query = $this->db->get();

		if ( $query->num_rows == 1) {
			return $query->row()->nombre;
		}

		return false;

	}

}

/* End of file module.php */
/* Location: ./application/models/module.php */