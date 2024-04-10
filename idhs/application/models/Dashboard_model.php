<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	private $table = "user";
	 public function __construct()
    {
        parent::__construct();
        //$this->db->query('SET SESSION sql_mode = ""');
    }
 
	public function check_user($data = [])
	{
		return $this->db->select("user.*, hospital.picture hospital_logo, hospital.name hospital_name")
			->from($this->table)
			->join('hospital','hospital.user_id = user.user_id','left')
			->where('email',$data['email'])
			->where('password',$data['password'])
			->where('status',1)
			->get();
	} 
 
	public function check_patient($data = [])
	{
		return $this->db->select("*")
			->from("patient")
			->where('email',$data['email'])
			->where('password',$data['password'])
			->where('status',1)
			->get();
	}  

	public function read_by_id($user_id = null)
	{
		return $this->db->select("user.*, department.name AS department")
			->from('user')
			->join('department', 'department.dprt_id = user.department_id', 'left')
			->where('user.user_id',$user_id)
			->get()
			->row();
	} 

	public function profile($user_id = null)
	{
		return $this->db->select("*")
			->from("user") 
			->where('user_id', $user_id)
			->get()
			->row();
	} 

	public function notify()
	{
		return $this->db->query('
			SELECT COUNT(*) AS total_app,
				(SELECT COUNT(*) FROM patient) AS total_patient,
				(SELECT COUNT(*) FROM user WHERE user_role = 2) AS total_doctor,
				(SELECT COUNT(*) FROM user WHERE user_role = 3) AS total_representative
			FROM appointment
		')
		->row();
	}

	public function getNotice(){
		return $this->db->select('*')
			->from('notice')
			->limit(4)
			->order_by('id','desc')
			->get()
			->result();
	}
 
	public function update($data = [])
	{
		return $this->db->where('user_id',$data['user_id'])
			->update("user" ,$data); 
	} 

	public function chart_patient($year,$month1)
	{
        $result =  $this->db->query("
            SELECT COUNT(patient_id) AS patient
            FROM patient WHERE Year(create_date)='$year' AND Month(create_date)='$month1' GROUP BY Year(create_date),Month(create_date)
        ")
        ->result(); 
        if(!empty($result)){
        	foreach ($result as $value) {
        		return $value->patient;
        	}
        	
        }else{
        	return 0;
        }
    }

    public function chart_appoint($year,$month1)
	{
        $result =  $this->db->query("
            SELECT COUNT(id) AS appoint
            FROM appointment WHERE Year(create_date)='$year' AND Month(create_date)='$month1' GROUP BY Year(create_date),Month(create_date)
        ")
        ->result(); 
        if(!empty($result)){
        	foreach ($result as $value) {
        		return $value->appoint;
        	}
        	
        }else{
        	return 0;
        }
    }

    public function chart_prescription($year,$month1)
	{
        $result =  $this->db->query("
            SELECT COUNT(id) AS prescription
            FROM pr_prescription WHERE Year(date)='$year' AND Month(date)='$month1' GROUP BY Year(date),Month(date)
        ")
        ->result(); 
        if(!empty($result)){
        	foreach ($result as $value) {
        		return $value->prescription;
        	}
        	
        }else{
        	return 0;
        }
    }


	public function chart(){
        $query1 =  $this->db->query('
            SELECT  
                create_date AS date,
                EXTRACT(MONTH FROM create_date) AS month,
                COUNT(patient_id) AS patient
            FROM patient
            WHERE create_date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)
            GROUP BY EXTRACT(YEAR_MONTH FROM create_date)
        ')
        ->result(); 

		$query2 = $this->db->query('
            SELECT 
                create_date AS date,
                EXTRACT(MONTH FROM create_date) AS month,
                COUNT(appointment_id) AS appointment
            FROM appointment
            WHERE create_date >= DATE_SUB(NOW(),INTERVAL 1 YEAR)
            GROUP BY EXTRACT(YEAR_MONTH FROM create_date)
        ')
        ->result(); 

        return [$query1,$query2]; 
	}

	public function chart_debit($year,$month){
        $result = $this->db->select('SUM(paid) as paid')->where('YEAR(date)', $year)->where('MONTH(date)', $month)->where('status', 1)->group_by('YEAR(date)', 'MONTH(date)')->get('acm_invoice')->row(); 
        if(!empty($result)){
        	return $result->paid;
        }else{
        	return 0;
        }
    }

    public function chart_credit($year,$month){
       $result = $this->db->select('SUM(amount) as amount')->where('YEAR(date)', $year)->where('MONTH(date)', $month)->where('status', 1)->group_by('YEAR(date)', 'MONTH(date)')->get('acm_payment')->row(); 
       if(!empty($result)){
        	return $result->amount;
        }else{
        	return 0;
        }
    }

    public function insert_hospital($data = [])
	{
		$user_array = array('email' => $data['email'], 'password' => $data['password'], 'user_role' => $data['user_role'], 'create_date' => $data['create_date'], 'update_date' => $data['update_date'], 'status' => $data['status']);
		$this->db->insert('user',$user_array);
		$user_id = $this->db->insert_id();

		$toRemove = ['email', 'password', 'user_role', 'status']; 
		foreach($toRemove as $key) {
		    unset($data[$key]);
		}

		$data['user_id'] = $user_id;
		return $this->db->insert('hospital',$data);
	}

  
}
