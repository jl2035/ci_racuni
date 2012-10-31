<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Storitve extends CI_Controller {

	public $s_id = -1;

	public function __construct()
	{
		
		parent::__construct();
		$this->load->helper('form');
		//$this->load->database();
		$this->s_id = $this->User_model->get_subscriber_id($this->session->userdata('uid'));
	}

	public function index()
	{
		//$query = $this->db->get_where('mytable', array('id' => $id), $limit, $offset);
		$data['query'] = $this->db->get_where('storitev', array('narocnik_id' => $this->s_id));
		$data['content'] = 'view_storitve';
		$this->load->view('layout/master', $data);
	}

	public function addnew()
	{
		$data['sid'] = $this->s_id;
		$data['content'] = 'dodaj_storitev';
		$this->load->view('layout/master', $data);
	}

	public function insert()
	{
		$data['sid'] = $this->s_id;
		$this->form_validation->set_rules('naziv', 'Naziv', 'required|trim|max_length[500]|xss_clean');
		$this->form_validation->set_rules('cena', 'Cena', 'required|numeric');
		$this->form_validation->set_rules('ddv', 'DDV', 'required|numeric');
		if(($this->form_validation->run() == FALSE))
		{
			$data['content'] = 'dodaj_storitev';
			$this->load->view('layout/master', $data);
		}
		else
		{
			$stor_item = array('naziv' => $this->input->post('naziv'), 'cena' => $this->input->post('cena'), 'narocnik_id' => $data['sid'], 'ddv' => $this->input->post('ddv'));
			$this->db->insert('storitev', $stor_item);
			redirect('storitve');
		}
	}

	public function remove()
	{
		$stor_id = $this->input->get('stor_id');
		$this->db->delete('storitev', array('id' => $stor_id));
		redirect('storitve');
	}

}
