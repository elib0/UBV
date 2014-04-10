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
				redirect('home');
			}else{
				$this->load->view('login');
			}
		}else{
			if ($this->Employee->is_logged_in()) {
				redirect('home');
			}else{
				$this->load->view('login', array('msg'=>''));
			}
			
		}
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */