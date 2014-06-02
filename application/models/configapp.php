<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configapp extends CI_Model {

	public $con;

	public function __construct()
	{
		parent::__construct();
		$this->con = $this->db;
	}

	public function get_config(){
		$result = $this->con->get_where('configuracion', array('id' => 1), 1);
		if ($result->num_rows() == 1) {
			return $result->row();
		}

		return (object) array('name'=>'','admin_email'=>'');
	}

	public function save($config_data){
		return $this->con->update('configuracion', $config_data, "id = 1");
	}

}

/* End of file config.php */
/* Location: ./application/models/config.php */