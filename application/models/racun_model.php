<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Racun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_postavke_arr($r_id)
	{
		$postavke = $this->db->query("SELECT postavka.id, postavka.kolicina, postavka.storitev_id, storitev.cena, 
		                             storitev.ddv, storitev.naziv 
		                             FROM postavka 
		                             JOIN storitev ON storitev.id = postavka.storitev_id WHERE postavka.racun_id = ".$r_id)->result_array();
		for($i=0; $i<count($postavke); $i++)                             
		//foreach($postavke as $post_avk)
		{
			$popusti = $this->db->get_where('popust', array('postavka_id' => $postavke[$i]['id']))->result_array();
			if(count($popusti) > 0)
				$postavke[$i]['popusti'] = $popusti;
			else
				$postavke[$i]['popusti'] = array();
		}
		return $postavke;
	}
	
	public function get_znesek($r_id, $DDV=true, $popust=true)
	{
		$znesek = 0;
		$postavke = $this->db->query("SELECT storitev.cena, storitev.ddv, postavka.kolicina, postavka.id FROM postavka JOIN storitev ON storitev.id = postavka.storitev_id WHERE postavka.racun_id = ?", array($r_id))->result();
		foreach($postavke as $p)
		{
			if(!$DDV)
				$znesekPostavke = $p->cena * $p->kolicina;
			else	
				$znesekPostavke = ($p->cena + ($p->cena * ($p->ddv / 100))) * $p->kolicina;
			if($popust)
			{
				$popusti = $this->db->get_where('popust', array('postavka_id' => $p->id))->result();
				foreach($popusti as $popust)
					$znesekPostavke = $znesekPostavke - ($znesekPostavke * ($popust->vrednost / 100));
			}
			$znesek += $znesekPostavke;
		}
		return number_format((float)$znesek, 2, '.', '');
		//return $znesek;
	}
}
