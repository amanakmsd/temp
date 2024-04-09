<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Content_management_model extends CI_Model {

	private $table = "content_management";
 	
 	public function create($data = [])
	{	 
		unset($data['content_id']);
		return $this->db->insert($this->table,$data);
	}

	public function read_by_id($content_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('content_id',$content_id)
			->get()
			->row();
	}

	public function read($type = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('created_by', $this->session->userdata('user_id'))
			->where('type', $type)
			->get()
			->result();
	} 
 
	public function update($data = [])
	{	
		return $this->db->where('content_id',$data['content_id'])
			->update($this->table,$data); 
	}

	public function delete($content_id = null)
	{
		$this->db->where('content_id',$content_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}
}
