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
	
	public function test()
	{
		$this->load->model('Racun_model');
		$nr1 = $this->Racun_model->get_znesek(24);
		$nr2 = $this->Racun_model->get_znesek(24, 1, 1);
		$nr3 = $this->Racun_model->get_znesek(24, 1, 0);
		$nr4 = $this->Racun_model->get_znesek(24, 0, 0);
		$nr5 = $this->Racun_model->get_znesek(24, 0, 1);
		echo "vse: $nr1<br>t, t: $nr2<br>t, f: $nr3<br>f, f: $nr4<br>f, t: $nr5";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
