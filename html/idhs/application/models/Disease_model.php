<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Disease_model extends CI_Model {

	private $table = "diseases";
 	
 	public function create($data = [])
	{
		unset($data['disease_id']);
		return $this->db->insert($this->table,$data);
	}

	public function read_by_id($disease_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('disease_id',$disease_id)
			->get()
			->row();
	}

	public function read($disease_type = null)
	{
		$where = "1=1 ";
		if($disease_type) {
			$where .= " AND disease_type = ".$disease_type."";
		}

		if($this->session->userdata('user_role') == 2 && $this->session->userdata('organs_operated') == '') {
			return array();
		}

		if($this->session->userdata('user_role') == 2 && $this->session->userdata('organs_operated') != '') {
			$organs_operated = explode(',', $this->session->userdata('organs_operated'));
			//print '<pre>';print_r($organs_operated);exit;
			
			for ($i=0; $i < count($organs_operated) ; $i++) {
				if($i == 0) {
					$where .= " AND '".$organs_operated[$i]."' = any(string_to_array(organ_related, ','))";
				} else {
					$where .= " OR '".$organs_operated[$i]."' = any(string_to_array(organ_related, ','))";
				}	
			}
		}
		//echo $where;exit;
		
		return $this->db->select("*")
			->from($this->table)
			->where($where)
			->get()
			->result();
		//print_r($resultArray);exit;
	}
 
	public function update($data = [])
	{
		return $this->db->where('disease_id',$data['disease_id'])
			->update($this->table,$data); 
	}

	public function delete($disease_id = null)
	{
		$this->db->where('disease_id',$disease_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}
}
