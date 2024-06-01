<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hospital_model extends CI_Model {

	private $table = "hospital";
 
	public function create($data = [])
	{
		$user_array = array('email' => $data['email'], 'password' => $data['password'], 'user_role' => $data['user_role'], 'created_by' => $data['created_by'], 'updated_by' => $data['updated_by'], 'create_date' => $data['create_date'], 'update_date' => $data['update_date']);
		$this->db->insert('user',$user_array);
		$user_id = $this->db->insert_id();


		$toRemove = ['hospital_id','email', 'password', 'user_role']; 
		foreach($toRemove as $key) {
		    unset($data[$key]);
		}

		$data['user_id'] = $user_id;
		return $this->db->insert($this->table,$data);
	}
 
	public function read()
	{
		return $this->db->select("hospital.*,user.status")
			->from("hospital")
			->join('user','user.user_id = hospital.user_id','left')
			->where('user.user_role', 2)
			->where('user.status !=', 0)
			->order_by('hospital_id','desc')
			->get()
			->result();
	} 
 
	public function read_by_id($hospital_id = null)
	{
		$where = array();
		if($this->session->userdata('user_role') == 2) {
			$where['hospital.user_id'] = $this->session->userdata('user_id');
		} else {
			$where['hospital.hospital_id'] = $hospital_id;
		}

		return $this->db->select("hospital.*, user.email, user.password")
			->from($this->table)
			->join('user','user.user_id = hospital.user_id','left')
			->where($where)
			->get()
			->row();
	}
 
	public function update($data = [])
	{
		$toRemove = ['user_id', 'email', 'password', 'user_role']; 
		foreach($toRemove as $key) {
		    unset($data[$key]);
		}
		
		return $this->db->where('hospital_id',$data['hospital_id'])
			->update($this->table,$data); 
	}
	public function update_hospital($data = [])
	{
		return $this->db->where('user_id',$data['user_id'])
			->update($this->table,$data); 
	} 
 
	public function delete($hospital_id = null)
	{
		$hospitalRow = $this->read_by_hospital_id($hospital_id);
		//echo $hospitalRow['user_id'];exit;

		$this->db->where('hospital_id',$hospital_id)->delete($this->table);
		$this->db->where('user_id', $hospitalRow['user_id'])->delete('user');

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

	public function approve($user_id = null, $password = null)
	{
		$this->db->where('user_id',$user_id)
			->update('user', array('status' => 1, 'password' => $password)); 

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function read_by_user_id($user_id = null)
	{
		return $this->db->select("hospital.name, user.email, user.password")
			->from('user')
			->join('hospital','hospital.user_id = user.user_id','left')
			->where('user.user_id', $user_id)
			->get()
			->row_array();
	}

	public function read_by_hospital_id($hospital_id = null)
	{
		return $this->db->select("user_id, hospital_id")
			->from('hospital')
			->where('hospital_id', $hospital_id)
			->get()
			->row_array();
	}
}
