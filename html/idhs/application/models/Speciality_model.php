<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Speciality_model extends CI_Model {

	private $table = "specialities";
 	
 	public function create($data = [])
	{
		unset($data['speciality_id']);
		return $this->db->insert($this->table,$data);
	}

	public function read_by_id($speciality_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('speciality_id',$speciality_id)
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
		return $this->db->where('speciality_id',$data['speciality_id'])
			->update($this->table,$data); 
	}

	public function delete($speciality_id = null)
	{
		$this->db->where('speciality_id',$speciality_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function speciality_list()
	{
		$result = $this->db->select("*")
			->from($this->table)
			->get()
			->result();

		//$list[''] = display('select_department');
		$list = array();
		if (!empty($result)) {
			foreach ($result as $value) {
				$list[$value->speciality_id] = $value->name; 
			}
			return $list;
		} else {
			return false;
		}
	}
}
