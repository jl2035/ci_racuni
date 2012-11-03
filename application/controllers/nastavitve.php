<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nastavitve extends CI_Controller {

	private $s_id = -1;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->s_id = $this->User_model->get_subscriber_id($this->session->userdata('uid'));
	}

	public function index()
	{
		$sub_data = $this->db->get_where('narocnik', array('id' => $this->s_id))->result();
		if(count($sub_data) > 0)
		{
			$data['naziv'] = $sub_data[0]->naziv;
			$data['naslov'] = $sub_data[0]->naslov;
			$data['posta'] = $sub_data[0]->posta;
			$data['telefon'] = $sub_data[0]->telefon;
			$data['email'] = $sub_data[0]->email;
			$data['trr'] = $sub_data[0]->trr;
			$data['banka'] = $sub_data[0]->banka;
			$data['content'] = 'view_nastavitve';
			$this->load->view('layout/master', $data);
		}
	}
	
	public function update()
	{
		$me = array();
		$me['id'] = $this->s_id;
		$me['naziv'] = $this->input->post('naziv');
		$me['naslov'] = $this->input->post('naslov');
		$me['posta'] = $this->input->post('posta');
		$me['email'] = $this->input->post('email');
		$me['telefon'] = $this->input->post('telefon');
		$me['trr'] = $this->input->post('trr');
		$me['banka'] = $this->input->post('banka');
		$this->db->where('id', $this->s_id);
		$this->db->update('narocnik', $me);
		redirect('racuni');
	}
}

