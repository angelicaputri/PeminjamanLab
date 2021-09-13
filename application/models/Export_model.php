<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Inventory model
*
*/
class Export_model extends CI_Model{
	function __construct(){
		parent::__construct();

		$this->datas_table      = 'inv_datas';
		$this->locations_table  = 'inv_locations';
		$this->status_table     = 'inv_status';
		$this->users_table      = 'users';
		$this->loggedinuser     = $this->ion_auth->user()->row();
	}

	public function get_inventory($id='',$limit='', $start='')
	{
		$this->db->select(
			$this->datas_table.".id, ".
			$this->datas_table.".code, ".
			$this->datas_table.".brand, ".
			$this->datas_table.".model, ".
			$this->datas_table.".serial_number, ".
			$this->datas_table.".photo, ".
			$this->datas_table.".description, ".
			$this->datas_table.".hari, ".
			$this->datas_table.".tanggal, ".
			$this->datas_table.".mulai, ".
			$this->datas_table.".keterangan, ".
			$this->datas_table.".deleted, ".
			$this->datas_table.".location_id, ".
			$this->locations_table.".name AS location_name, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->datas_table);


		// join locations table
		$this->db->join(
			$this->locations_table,
			$this->datas_table.'.location_id = '.$this->locations_table.'.id',
			'left');

		// join user table
		$this->db->join(
			$this->users_table,
			$this->datas_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->datas_table.'.deleted', '0');

		// if ID provided
		if ($id!='') {
			$this->db->where($this->datas_table.'.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		$this->db->order_by($this->datas_table.'.id', 'asc');
		$datas = $this->db->get();
		return $datas;
	}
}