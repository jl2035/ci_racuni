<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Racuni extends CI_Controller {

	private $s_id = -1;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->s_id = $this->User_model->get_subscriber_id($this->session->userdata('uid'));
	}

	public function index()
	{
		$racuni = $this->db->get_where('racun', array('narocnik_id' => $this->s_id))->result();
		//$racuni = $this->db->query("select racun.id, racun.datum, racun.predracun, racun.narocnik_id, stranka.id, stranka.naziv from racun join stranka on stranka.id = racun.stranka_id")->result();
		$racuni_obj = array();
		foreach($racuni as $r)
		{
			$postavke = $this->db->query("SELECT postavka.id, postavka.kolicina, postavka.storitev_id, storitev.cena, storitev.ddv, storitev.naziv FROM postavka JOIN storitev ON storitev.id = postavka.storitev_id WHERE postavka.racun_id = ".$r->id)->result();
			$temp = array();
			$temp['id'] = $r->id;
			$temp['datum'] = $r->datum;
			$temp['st_racuna'] = $r->st_racuna;
			$temp['narocnik_id'] = $r->narocnik_id;
			$temp['predracun'] = $r->predracun;
			$temp['postavke'] = $postavke;
			$stranka_name = $this->db->query("SELECT naziv, id FROM stranka WHERE id=".$r->stranka_id)->result();
			$temp['stranka'] = $stranka_name[0]->naziv;
			$racuni_obj[] = $temp;
		}
		$data['racuni'] = $racuni_obj;
		$data['content'] = 'view_racuni';
		$this->load->view('layout/master', $data);
	}
	
	public function dodaj()
	{
		$data['sid'] = $this->s_id;
		$data['content'] = 'dodaj_racun';
		$data['storitve_q'] = $this->db->get_where('storitev', array('narocnik_id' => $this->s_id));
		$data['stranke_q'] = $this->db->get_where('stranka', array('narocnik_id' => $this->s_id));
		$this->load->view('layout/master', $data);
	}
	
	public function insert()
	{
		$this->form_validation->set_rules('stors', 'Storitve', 'required');
		$this->form_validation->set_rules('st_racuna', 'Št. računa', 'required');
		//$this->form_validation->set_rules('cena', 'Cena', 'required|numeric');
		if(($this->form_validation->run() == FALSE))
		{
			$data['content'] = 'dodaj_racun';
			$this->load->view('layout/master', $data);
		}
		else
		{
			$stranka_post = $this->input->post('stranka');
			if($stranka_post == -1)
			{	
				$stranka_item = array('naziv' => $this->input->post('str_naziv'), 'naslov' => $this->input->post('str_naslov'), 'narocnik_id' => $this->s_id, 'posta' => $this->input->post('str_posta'), 'telefon' => $this->input->post('telefon'), 'email' => $this->input->post('email'));
				$this->db->insert('stranka', $stranka_item);
				$stranka_id = $this->db->insert_id();
			}
			else
			{
				$stranka_id = $stranka_post;
			}
			$racun_item = array('datum' =>  time(), 'predracun' => ($this->input->post('predracun') == 'on' ? 1 : 0), 'narocnik_id' => $this->s_id, 'stranka_id' => $stranka_id, 'st_racuna' => $this->input->post('st_racuna'));
			$this->db->insert('racun', $racun_item);
			$racun_id = $this->db->insert_id();
			$stors = $this->input->post('stors');
			$stors_arr = explode('|', $stors);
			foreach($stors_arr as $sitem)
			{
				$postavkaJS = explode(';', $sitem);
				$postavka = array('storitev_id' => $postavkaJS[0], 'racun_id' => $racun_id, 'kolicina' => $postavkaJS[1]);
				$this->db->insert('postavka', $postavka);
			}
			redirect('racuni');
		}
	}
	
	
	public function remove()
	{
		$rac_id = $this->input->get('rac_id');
		$this->db->delete('racun', array('id' => $rac_id));
		redirect('racuni');
	}
	
	public function show_single($rac_id=null)
	{
		if($rac_id == null)
			echo "Error! Prosimo kontaktirajte Jakata :)";
		else
		{
			$data['racun_id'] = $rac_id;
			$racuni = $this->db->get_where('racun', array('id' => $rac_id))->result();
		    $r = $racuni[0];
			if($r)
			{
				$postavke = $this->db->query("SELECT postavka.id, postavka.kolicina, postavka.storitev_id, storitev.cena, storitev.ddv, storitev.naziv FROM postavka JOIN storitev ON storitev.id = postavka.storitev_id WHERE postavka.racun_id = ".$r->id)->result();
				$temp = array();
				$temp['id'] = $r->id;
				$temp['st_racuna'] = $r->st_racuna;
				$temp['datum'] = $r->datum;
				$temp['narocnik_id'] = $r->narocnik_id;
				$narocniki = $this->db->get_where('narocnik', array('id' => $r->narocnik_id))->result();  //$this->db->query("SELECT * FROM narocnik WHERE id=".$r->narocnik_id)->result();
				$temp['narocnik'] = $narocniki[0];
				$temp['predracun'] = $r->predracun;
				$temp['postavke'] = $postavke;
				$stranke = $this->db->get_where('stranka', array('id' => $r->stranka_id))->result(); //$this->db->query("SELECT * FROM stranka WHERE id=".$r->stranka_id)->result();
				$temp['stranka'] = $stranke[0];
				$data['racun'] = $temp;
			}
			$this->load->library('tcpdf');
			$this->load->view('racun_single', $data);
		}
		
	}
}


