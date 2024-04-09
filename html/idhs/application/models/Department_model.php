<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

	private $table = 'department';

	public function create($data = [])
	{	
		unset($data['dprt_id']);
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		$all_uids = $this->get_user_ids();

		return $this->db->select("*")
			->from($this->table)
			->where_in('created_by', $all_uids)
			->order_by('dprt_id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($dprt_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('dprt_id',$dprt_id)
			->get()
			->row();
	} 
 
	public function update($data = [])
	{
		return $this->db->where('dprt_id',$data['dprt_id'])
			->update($this->table,$data); 
	} 
 
	public function delete($dprt_id = null)
	{
		$this->db->where('dprt_id',$dprt_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function department_list()
	{
		if($this->session->userdata('user_role') == 1) {
			$all_uids[] = $this->session->userdata('user_id');
		} else {
			$all_uids = $this->get_user_ids();
		}

		
		$this->db->select("*")
			->from($this->table)
			->where('status',1);
			if(!empty($all_uids)) {
				$this->db->where_in('created_by', $all_uids);
			}
			
			$query = $this->db->get();
		$result = $query->result();

		//$list[''] = display('select_department');
		$list = array();
		if (!empty($result)) {
			foreach ($result as $value) {
				$list[$value->dprt_id] = $value->name; 
			}
			return $list;
		} else {
			return false;
		}
	}

	public function get_user_ids()
	{
		if($this->session->userdata('user_role') == 2) {
			$created_by = $this->session->userdata('user_id');
		} else {
			$created_by = $this->session->userdata('created_by');
		}
		//echo $created_by;exit;

		$result = $this->db->select("user_id")
			->from('user')
			->where('created_by',$created_by)
			->where('user_role', 4)
			->get()
			->result();

		$all_uids = array_column($result, 'user_id');
		//print_r($all_uids);exit;

		if(empty($all_uids)) {
			$all_uids = array();
			array_push($all_uids, $created_by);
		} else {
			array_push($all_uids, $created_by);
		}
		return $all_uids;
		//print_r($all_uids);exit;
	}
	
 }
