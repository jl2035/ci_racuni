
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
		$racuni = $this->db->get('racun')->result();
		$racuni_obj = array();
		foreach($racuni as $r)
		{
			$postavke = $this->db->query("SELECT postavka.id, postavka.kolicina, postavka.storitev_id, storitev.cena, storitev.naziv FROM postavka JOIN storitev ON storitev.id = postavka.storitev_id WHERE postavka.racun_id = ".$r->id)->result();
			$temp = array();
			$temp['id'] = $r->id;
			$temp['datum'] = $r->datum;
			$temp['narocnik_id'] = $r->narocnik_id;
			$temp['predracun'] = $r->predracun;
			$temp['postavke'] = $postavke;
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
		$this->load->view('layout/master', $data);
	}
	
	public function insert()
	{
		$racun_item = array('datum' =>  time(), 'predracun' => $this->input->post('predracun'), 'narocnik_id' => $this->s_id);
		$this->db->insert('racun', $racun_item);
		$racun_id = $this->db->insert_id();
		//echo $racun_id;
		$stors = $this->input->post('stors');
		//array split ( string $pattern , string $string [, int $limit = -1 ] )
		$stors_arr = explode('|', $stors);
		foreach($stors_arr as $sitem)
		{
			$postavkaJS = explode(';', $sitem);
			$postavka = array('storitev_id' => $postavkaJS[0], 'racun_id' => $racun_id, 'kolicina' => $postavkaJS[1]);
			$this->db->insert('postavka', $postavka);
		}
		redirect('racuni');
	}
	
	
	public function remove()
	{
		$rac_id = $this->input->get('rac_id');
		$this->db->delete('racun', array('id' => $rac_id));
		redirect('racuni');
	}
}


