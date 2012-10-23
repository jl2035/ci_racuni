<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Storitve extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		$this->load->helper('form');
		//$this->load->database();
		
	}

	public function index()
	{
		$data['query'] = $this->db->get('storitev');
		$data['content'] = 'view_storitve';
		$this->load->view('layout/master', $data);
	}

	public function addnew()
	{
		$data['sid'] = $this->User_model->get_subscriber_id($this->session->userdata('uid'));
		$data['content'] = 'dodaj_storitev';
		$this->load->view('layout/master', $data);
	}

	public function insert()
	{
		$data['sid'] = $this->User_model->get_subscriber_id($this->session->userdata('uid'));
		$this->form_validation->set_rules('naziv', 'Naziv', 'required|trim|max_length[500]|xss_clean');
		$this->form_validation->set_rules('cena', 'Cena', 'required|numeric');
		if(($this->form_validation->run() == FALSE))
		{
			$data['content'] = 'dodaj_storitev';
			$this->load->view('layout/master', $data);
		}
		else
		{
			$stor_item = array('naziv' => $this->input->post('naziv'), 'cena' => $this->input->post('cena'), 'narocnik_id' => $data['sid']);
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
