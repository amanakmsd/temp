<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Organ_model extends CI_Model {

	private $table = "organs";
 	
 	public function create($data = [])
	{
		unset($data['organ_id']);
		return $this->db->insert($this->table,$data);
	}

	public function read_by_id($organ_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('organ_id',$organ_id)
			->get()
			->row();
	}

	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->where('created_by', $this->session->userdata('user_id'))
			->get()
			->result();
	}
 
	public function update($data = [])
	{
		return $this->db->where('organ_id',$data['organ_id'])
			->update($this->table,$data); 
	}

	public function delete($organ_id = null)
	{
		$this->db->where('organ_id',$organ_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function organ_list()
	{
		$result = $this->db->select("*")
			->from($this->table)
			->get()
			->result();

		//$list[''] = display('select_department');
		$list = array();
		if (!empty($result)) {
			foreach ($result as $value) {
				$list[$value->organ_id] = $value->name; 
			}
			return $list;
		} else {
			return false;
		}
	}
}
