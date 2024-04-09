<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_model extends CI_Model {

	private $table = "schedule";
 
	public function create($data = [])
	{	 
		unset($data['schedule_id']);
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		$all_uids = $this->get_user_ids();
		$date_sql = date('Y-m-d');

		return $this->db->select("schedule.*, user.firstname, user.lastname, department.name")
			->from($this->table)
			->join('user','user.user_id = schedule.doctor_id','left')
			->join('department','department.dprt_id = user.department_id','left')
			->where("schedule.end_date >=", "$date_sql")
			->where_in('schedule.created_by',$all_uids)
			->order_by('schedule.schedule_id','desc')
			->get()
			->result();
		//echo $this->db->last_query();exit;
	} 
  

	public function read_by_id($schedule_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('schedule_id',$schedule_id)
			->get()
			->row();
	} 
 
 
	public function update($data = [])
	{
		return $this->db->where('schedule_id',$data['schedule_id'])
			->update($this->table,$data); 
	} 
 
	public function delete($schedule_id = null)
	{
		$this->db->where('schedule_id',$schedule_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
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
