<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Model {

	public $con;

	public function __construct()
	{
		parent::__construct();
	}

	function request_diff(){
		$this->db->select('status, COUNT(status) AS cuenta');
		$this->db->from('solicitud');
		$this->db->group_by('status');
		return $this->db->get();
	}

	function request_by_univercity(){
		$this->db->select('aldea.nombre, COUNT(solicitud.id) AS cuenta');
		$this->db->from('solicitud');
		$this->db->join('estudiante', 'estudiante.matricula = solicitud.matricula');
		$this->db->join('pfg', 'estudiante.cod_pfg = pfg.cod_pfg ');
		$this->db->join('aldea', 'aldea.cod_aldea = pfg.cod_aldea');
		$this->db->group_by('aldea.cod_aldea');
		return $this->db->get();
	}

}

/* End of file report.php */
/* Location: ./application/models/report.php */