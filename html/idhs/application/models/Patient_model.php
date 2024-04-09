<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {

	private $table = "user";
 
	public function create($data = [])
	{
		unset($data['user_id']);
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		return $this->db->select("*")
			->from("user")
			->where('user_role', 5)
			->order_by('user_id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($user_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('user_id',$user_id)
			->get()
			->row();
	} 
 
	public function update($data = [])
	{	
		return $this->db->where('user_id',$data['user_id'])
			->update($this->table,$data); 
	} 
 
	public function delete($user_id = null)
	{
		$this->db->where('user_id',$user_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}
}
