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
		$this->db->select('aldea.cod_aldea, aldea.nombre, 
							municipio.nombre AS nombre_municipio,
							pfg.cod_pfg, pfg.nombre AS pfg_nombre');
		$this->con->from('aldea');
		$this->con->join('pfg', 'aldea.cod_aldea = pfg.cod_aldea');
		$this->db->where('cod_aldea', $aldea_cod);
		return $this->db->get();

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
		$this->db->select('aldea.*, municipio.nombre AS nombre_municipio');
		$this->db->from('aldea');
		$this->con->join('municipio', 'aldea.cod_municipio = municipio.cod_municipio');
		$this->db->like("CONCAT(aldea.nombre, ' ', municipio.nombre)", $seacrh);
		$result = $this->db->get();

		if ($result->num_rows()>0) {
			return $result;
		}

		return FALSE;
	}

	public function search_pfg($seacrh = ''){
		$this->db->select('pfg.*, aldea.nombre AS nombre_aldea');
		$this->db->from('pfg');
		$this->con->join('aldea', 'aldea.cod_aldea = pfg.cod_aldea');
		$this->db->like("CONCAT('aldea', aldea.nombre, ' ')", $seacrh);
		$result = $this->db->get();

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

}

/* End of file university.php */
/* Location: ./application/models/university.php */