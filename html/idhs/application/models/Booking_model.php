<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

	private $table = "booking";
 	
 	public function create($data = [])
	{
		unset($data['booking_id']);
		return $this->db->insert($this->table,$data);
	}

	public function read_by_id($booking_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('booking_id',$booking_id)
			->get()
			->row();
	}

	public function get_patient_details($booking_id = null)
	{
		return $this->db->select("booking.booking_id, booking.schedule_date, booking.schedule_time, patient.firstname patient_name, patient.email patient_email, doctor.firstname doctor_name, hospital.name hospital_name")
			->from('booking')
			->join('user patient','patient.user_id = booking.user_id','left')
			->join('user doctor','doctor.user_id = booking.doctor_id','left')
			->join('hospital','hospital.user_id = booking.hospital_id','left')
			->where('booking.booking_id', $booking_id)
			->get()
			->row_array();
	}

	public function read($booking_type = null, $query_department_id = null, $query_hospital_id = null)
	{
		$where = array();
		$all_uids = array();
		if($query_hospital_id) {
			$where['booking.hospital_id'] = $query_hospital_id;
		} elseif ($this->session->userdata('user_role') != 1) {
			$all_uids = $this->get_user_ids();
			//$where['booking.hospital_id'] = $all_uids;
		}
		
		/*
		$booking.status 1 = Pending
		$booking.status 2 = Rejected
		*/
		if($booking_type == '1') {
			$where['booking.status'] = 1;
		} else if($booking_type == '3') {
			$where['booking.status'] = 2;
		} else if($booking_type == '2') {
			$where['booking.status'] = 3;
		} else {
			$where['booking.status'] = 1;
		}

		if($query_department_id) {
			$where['booking.department_id'] = $query_department_id;
		}

		//print '<pre>';print_r($where);exit;

		$this->db->select("booking.*, department.name department_name, patient.firstname, patient.address, patient.age, doctor.firstname doctor_name, hospital.name hospital_name")
			->from($this->table)
			->join('department','department.dprt_id = booking.department_id','left')
			->join('user patient','patient.user_id = booking.user_id','left')
			->join('user doctor','doctor.user_id = booking.doctor_id','left')
			->join('hospital','hospital.user_id = booking.hospital_id','left');
			$this->db->where($where);

			if(!empty($all_uids)) {
				$this->db->where_in('booking.hospital_id',$all_uids);
			}
			$query = $this->db->get();
			return $query->result();
	}
 
	public function update($data = [])
	{
		return $this->db->where('booking_id',$data['booking_id'])
			->update($this->table,$data); 
	}

	public function reject($booking_id = null)
	{
		return $this->db->where('booking_id', $booking_id)
			->update($this->table, array('status' => 2));
		//echo $this->db->last_query();exit;
	}

	public function reschedule($booking_id = null)
	{
		return $this->db->where('booking_id', $booking_id)
			->update($this->table, array('status' => 1));
	}

	public function hospital_list()
	{
		$result = $this->db->select("user_id hospital_id, name")
			->from('hospital')
			->get()
			->result();

		return $result;
	}

	public function read_by_patient_id($user_id = null)
	{
		$where = array();

		if($user_id) {
			$where['booking.user_id'] = $user_id;
		}

		return $this->db->select("booking.*, department.name department_name, patient.firstname, patient.address, patient.age, doctor.firstname doctor_name, hospital.name hospital_name, hospital.address hospital_address")
			->from($this->table)
			->join('department','department.dprt_id = booking.department_id','left')
			->join('user patient','patient.user_id = booking.user_id','left')
			->join('user doctor','doctor.user_id = booking.doctor_id','left')
			->join('hospital','hospital.user_id = booking.hospital_id','left')
			->where($where)
			->get()
			->result();
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
