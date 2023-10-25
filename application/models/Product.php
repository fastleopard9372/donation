<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Model{
	
	function __construct() {
        $this->proTable   = 'products';
		$this->transTable = 'payments';
    }
	
	/*
     * Fetch products data from the database
     * @param id returns a single record if specified, otherwise all records
     */
	public function getRows($id = ''){
		$this->db->select('*');
		$this->db->from($this->proTable);
		$this->db->where('status', '1');
		if($id){
			$this->db->where('id', $id);
			$query = $this->db->get();
			$result = $query->row_array();
		}else{
			$this->db->order_by('name', 'asc');
			$query = $this->db->get();
			$result = $query->result_array();
		}
		
		// return fetched data
		return !empty($result)?$result:false;
	}
	
	/*
     * Insert data in the database
     * @param data array
     */
	public function insertTransaction($data){
		$insert = $this->db->insert($this->transTable,$data);
		return $insert?true:false;
	}
	public function getDonate($id = ''){
		$this->db->select('*');
		$this->db->from($this->transTable);
		$this->db->order_by('payment_id', 'desc');
		$this->db->limit(5);
		$query = $this->db->get();
		$result = $query->result_array();
		return !empty($result)?$result:false;
	}
	public function getTotal(){
		$query = $this->db->query("select sum(amount) as value from ".$this->transTable);
		$row = $query->row();
		
		return !empty($row)?$row:-1;
	}
	public function getCount($id = ''){
		$query = $this->db->query("select count(*) as value from ".$this->transTable);
		$row = $query->row();
		return !empty($row)?$row:0;
	}
	
}