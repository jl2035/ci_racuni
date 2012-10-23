<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function check_login($usr, $pass)
	{
		$qr_str = "select id from uporabnik where upor_ime = ? and geslo = ?";
		$result = $this->db->query($qr_str, array($usr, hash('sha256', $pass)));
		if($result->num_rows() == 1)
			return $result->row(0)->id;
		else
			return false;
	}
	
	public function get_subscriber_id($usr)
	{
		$qr_str = "select id from narocnik where id = (select narocnik_id from uporabnik where id = ?)";
		$result = $this->db->query($qr_str, array($usr));
		if($result->num_rows() > 0)
			return $result->row(0)->id;
		else
			return false;
	}
}
