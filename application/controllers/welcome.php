<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		if(!($this->session->userdata('logged_in') == 'true'))
			$this->load->view('welcome_message');
		else
			redirect('storitve');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
