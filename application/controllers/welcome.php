<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if(!($this->session->userdata('logged_in') == 'true')){
			$data['content'] = 'welcome_message';
			$this->load->view('layout/master', $data);
		}
		else
			redirect('racuni');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
