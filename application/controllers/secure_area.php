<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Secure_Area extends CI_Controller {

	public function __construct($module_id=null)
	{
		parent::__construct();	
		$this->load->model('Employee');
		
		if(!$this->Employee->is_logged_in())
		{
			redirect('login');
		}

		if(!$this->Employee->has_permission($module_id,$this->Employee->get_logged_in_employee_info()->cod_empleado)){
			redirect('no_access/index/'.$module_id); //Redireccion si no tiene acceso
		}

		//Datos HTML para vistas
		$data['title'] = '';
		$data['config_title'] = $this->Configapp->get_config()->name;
		$data['show_menu'] = TRUE;
		$data['system_message'] = '';

		//Datos de usuario en sesion
		$data['user_info']=$this->Employee->get_logged_in_employee_info();

		//Modulos permitidos por el usuario
		$allowed_modules_ids = $this->Employee->get_allowed_modules($data['user_info']->cod_empleado);
		$data['allowed_modules']=$this->Module->get_modules_info($allowed_modules_ids);
		
		$this->load->vars($data);
	}

}

/* End of file secure_area.php */
/* Location: ./application/controllers/secure_area.php */