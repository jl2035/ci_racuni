<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stranke extends CI_Controller {

	private $s_id = -1;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->s_id = $this->User_model->get_subscriber_id($this->session->userdata('uid'));
	}

	public function index()
	{
		$stranke = $this->db->get('stranka');
		$data['stranke'] = $stranke;
		$data['content'] = 'view_stranke';
		$this->load->view('layout/master', $data);
	}
	
	public function dodaj()
	{
		$data['sid'] = $this->s_id;
		$data['content'] = 'dodaj_stranko';
		//$data['storitve_q'] = $this->db->get_where('storitev', array('narocnik_id' => $this->s_id));
		$this->load->view('layout/master', $data);
	}
	
	public function insert()
	{
		$str = array();
		$str['naziv'] = $this->input->post('naziv');
		$str['narocnik_id'] = $this->input->post('sid');
		$str['naslov'] = $this->input->post('naslov');
		$str['posta'] = $this->input->post('posta');
		$str['telefon'] = $this->input->post('telefon');
		$str['email'] = $this->input->post('email');
		$this->db->insert('stranka', $str);
		redirect('stranke');
	}
	
	
	public function remove()
	{
		$str_id = $this->input->get('st_id');
		$res = $this->db->get_where('racun', 'stranka_id = '.$str_id)->result();
		if(count($res) > 0)
		{
			$data['j_error'] = "Najprej pobriši  vse račune, ki pripadajo tej stranki!";
			$this->load->view('layout/error', $data);
		}
		else{
			$this->db->delete('stranka', array('id' => $str_id));
			redirect('stranke');
		}
	}
}


