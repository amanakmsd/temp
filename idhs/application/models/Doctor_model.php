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
		if($department_id) {
			$where = array(
				'user.user_role' => 3,
				'user.department_id'   => $department_id
			);
		} else {
			$where = array(
				'user.user_role' => 3
			);
		}

		if($this->session->userdata('user_role') == 2) {
			$where['user.created_by'] = $this->session->userdata('user_id');
		}

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
		return $this->db->select("user.*,department.name department_name, schedule.start_date, schedule.end_date, schedule.start_time, schedule.end_time")
			->from($this->table)
			->join('department','department.dprt_id = user.department_id','left')
			->join('schedule','schedule.doctor_id = user.user_id','left')
			->group_start()
				->where('user_role',3)
			->group_end()
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
			->group_start() 
			->where('user_role',2)
			->group_end()
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
			->where('user_role',2)
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
}
