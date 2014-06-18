<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Datos HTML para vistas
		$data['title'] = 'Login';
		$data['config_title'] = $this->Configapp->get_config()->name;
		$data['show_menu'] = false;
		$data['system_message'] = '';
		$data['class'] = 'login';
		$this->load->vars($data);
	}

	public function index()
	{
		$this->load->model('Employee');
		if ($this->input->post('submit')) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if ($employee = $this->Employee->login($username, $password)) {
				redirect('home');
			}else{
				$data['system_message'] = 'Nombre de usuario o contraseña Invalido!';
				$this->load->view('login', $data);
			}
		}else{
			if ($this->Employee->is_logged_in()) {
				redirect('home');
			}else{
				$this->load->view('login');
			}
			
		}
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */