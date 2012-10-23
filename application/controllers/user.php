<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
	}

	public function index()
	{
		if(!($this->session->userdata('logged_in') == 'true'))
			$this->load->view('view_login');
		else
			$this->load->view('view_storitve');
	}
	
	public function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[100]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|max_length[100]|xss_clean');
		if($this->form_validation->run() == FALSE)
		{
			$this->load_view('view_login');
		}
		else
		{
			$usr = $this->input->post('username');
			$pswd = $this->input->post('password');
			$u_id = $this->User_model->check_login($usr, $pswd);
			if(!$u_id) //Login failed
			{
				$this->load->view('view_login');
			}
			else
			{
				$this->session->set_userdata('logged_in', 'true');
				$this->session->set_userdata('uid', $u_id);
				//echo "User: ".$usr."<br>ID: ".$u_id."<br>Pass: ".$pswd;
				//$this->load->view('view_storitve');
				redirect('storitve');
			}
		}
	}
	
}
