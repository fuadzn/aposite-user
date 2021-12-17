<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_obat extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_obat(){
		return $this->db->query("SELECT * FROM obat");
	}

	function insert_pembeli($data)
	{
		$this->db->insert('pembeli', $data);
		return true;
	}
}
