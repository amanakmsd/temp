<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Package_model extends CI_Model {

	private $table = "packages";
 
	public function create($data = [])
	{
		unset($data['package_id']);
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		return $this->db->select("packages.*, department.name department_name")
			->from($this->table)
			->join('department','department.dprt_id = packages.department_id','left')
			->where('packages.created_by', $this->session->userdata('user_id'))
			->order_by('packages.package_id','desc')
			->get()
			->result();
	}

	public function package_subscribed()
	{
		return $this->db->select("*")
			->from($this->table)
			->where('created_by', $this->session->userdata('user_id'))
			->order_by('package_id','desc')
			->get()
			->result();
	}
 
	public function read_by_id($package_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('package_id',$package_id)
			->get()
			->row();
	}
 
	public function update($data = [])
	{
		return $this->db->where('package_id',$data['package_id'])
			->update($this->table,$data); 
	} 
 
	public function delete($package_id = null)
	{
		$this->db->where('package_id',$package_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}
}
