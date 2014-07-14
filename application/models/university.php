<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class University extends CI_Model {

	public $con;

	public function __construct()
	{
		parent::__construct();
		$this->con = $this->db;
	}

	public function save_aldea($aldea_data, $cod_aldea = -1){
		if ($this->con->insert('aldea',$aldea_data)) {
			return $this->con->insert_id();
		}
		return FALSE;
	}

	public function save_pfg($pfg_aldea, $cod_pfg = -1){
		if ($this->con->insert('pfg',$pfg_aldea)) {
			return $this->con->insert_id();
		}
		return FALSE;
	}

	public function get_aldea_info($aldea_cod = 0){
		$this->con->from('aldea');
		$this->con->where('cod_aldea', $aldea_cod);
		$this->con->limit(1);
		$query = $this->con->get();
		if ($query->num_rows() == 1) {
			return $query->row();
		}
		return false;

	}

	public function get_aldea_info_by_pfg($pfg_cod = 0){
		$this->con->select('aldea.*');
		$this->con->from('aldea');
		$this->con->join('pfg', 'aldea.cod_aldea = pfg.cod_aldea');
		$this->con->where('cod_pfg', $pfg_cod);
		$this->con->limit(1);
		$query = $this->con->get();
		if ($query->num_rows() == 1) {
			return $query->row();
		}
		return false;
	}

	public function get_all_municipios(){
		$this->con->select('municipio.cod_municipio,
						   municipio.nombre AS nombre_municipio,
						   municipio.cod_entidad_federal, 
						   entidad_federal.nombre AS nombre_entidad_federal');

		$this->con->from('municipio');
		$this->con->join('entidad_federal', 'municipio.cod_entidad_federal = entidad_federal.cod_entidad_federal');
		return $this->con->get();

	}

	public function get_all_aldeas($for_dropdown=false){
		$result = array();
		$this->con->select('aldea.*,
						   municipio.nombre AS nombre_municipio');
		$this->con->from('aldea');
		$this->con->join('municipio', 'aldea.cod_municipio = municipio.cod_municipio');
		
		if ($for_dropdown) {
			if ($query = $this->con->get()) {
				foreach ($query->result() as $aldea) {
					$result[$aldea->cod_aldea] = $aldea->nombre;
				}
			}
		}else{
			return $this->con->get();
		}
	}

	public function search($seacrh = ''){
		$this->con->select('aldea.*, municipio.nombre AS nombre_municipio');
		$this->con->from('aldea');
		$this->con->join('municipio', 'aldea.cod_municipio = municipio.cod_municipio');
		$this->con->like("CONCAT(aldea.nombre, ' ', municipio.nombre)", $seacrh);
		$result = $this->con->get();

		if ($result->num_rows()>0) {
			return $result;
		}

		return FALSE;
	}

	public function search_pfg($search = '', $equal_to=false){
		$this->con->select('pfg.*, aldea.nombre AS nombre_aldea');
		$this->con->from('pfg');
		$this->con->join('aldea', 'aldea.cod_aldea = pfg.cod_aldea');
		if (!$equal_to) {
			$this->con->like("CONCAT('aldea', aldea.nombre, ' ', pfg.nombre, ' ', pfg.cod_pfg)", $search);
		}else{
			$this->con->where( $equal_to, $search);
		}

		$result = $this->con->get();

		if ($result->num_rows()>0) {
			return $result;
		}

		return FALSE;
	}

	public function get_all_pfg(){
		$this->con->select('pfg.cod_pfg,
						   pfg.nombre AS nombre_pfg,
						   pfg.descripcion, 
						   pfg.cod_aldea,
						   aldea.nombre AS nombre_aldea');
		$this->con->from('pfg');
		$this->con->join('aldea', 'aldea.cod_aldea = pfg.cod_aldea');
		return $this->con->get();
	}

	public function get_aldea_pfgs($cod_univercity = 0){
		$this->con->select('cod_pfg, nombre');
		$this->con->from('pfg');
		$this->con->where('cod_aldea', $cod_univercity);
		return $this->con->get();
	}

}

/* End of file university.php */
/* Location: ./application/models/university.php */