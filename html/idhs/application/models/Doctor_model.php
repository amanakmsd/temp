<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor_model extends CI_Model {

	private $table = "user";
 
	public function create($data = [])
	{	 
		unset($data['user_id']);
		return $this->db->insert($this->table,$data);
	}
 
	public function read($department_id = null)
	{
		$where = "1=1 ";

		if($department_id) {
			/*$where = array(
				'user.user_role' => 3,
				'user.department_id'   => $department_id
			);*/
			$where .= " AND user.user_role = 3 AND user.department_id = ".$department_id."";
		} else {
			/*$where = array(
				'user.user_role' => 3
			);*/
			$where .= " AND user.user_role = 3";
		}

		if($this->session->userdata('user_role') != 1) {
			$all_uids = implode(',',$this->get_user_ids());
			//print '<pre>';print_r($all_uids);exit;
			//$where['user.created_by'] = $this->session->userdata('user_id');
			$where .= " AND user.created_by IN (".$all_uids.")";
		}
		//echo $where;exit;

		return $this->db->select("user.*,department.name department_name, string_agg(schedule.schedule_id::character varying, ',') as schedule_ids")
			->from("user")
			->join('department','department.dprt_id = user.department_id','left')
			->join('schedule','schedule.doctor_id = user.user_id','left')
			->where($where)
			->group_by("user.user_id")
			->group_by("department.name")
			->order_by('user.user_id','desc')
			->get()
			->result();
	}
 
	public function read_by_id($user_id = null)
	{
		$curent_date = date('Y-m-d');
		return $this->db->select("user.*,department.name department_name")
			->from($this->table)
			->join('department','department.dprt_id = user.department_id','left')
			->where('user.user_id',$user_id)
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
  

	public function doctor_list()
	{
		$result = $this->db->select("*")
			->from($this->table)
			->where('user_role',3)
			->where('status',1)
			->get()
			->result();

		$list[''] = 'Select Doctor';
		if (!empty($result)) {
			foreach ($result as $value) {
				$list[$value->user_id] = $value->firstname.' '.$value->lastname; 
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
