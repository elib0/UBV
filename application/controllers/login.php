<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('Employee');
		if ($this->input->post('submit')) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if ($employee = $this->Employee->login($username, $password)) {
				$this->load->view('partial/header');
				$this->load->view('partial/main_menu');
				$this->load->view('main');
				$this->load->view('partial/footer');
			}else{
				$this->load->view('partial/header');
				$this->load->view('login');
				$this->load->view('partial/footer');
			}
		}else{
			if ($this->Employee->is_logged_in()) {
				redirect('main');
			}else{
				$this->load->view('partial/header');
				$this->load->view('login', array('msg'=>''));
				$this->load->view('partial/footer');
				//si va a loguear
			}
			
		}
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */