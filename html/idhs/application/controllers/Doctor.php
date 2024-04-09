<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'doctor_model',
			'department_model'
		));

		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}
		
	}

 
	public function index()
	{
		$url_components = parse_url($_SERVER['REQUEST_URI']);
		if(isset($url_components['query'])) {
			parse_str($url_components['query'], $params);
			if(isset($params['department']) && $params['department'] != 'all') {
				$department_id = $params['department'];
			} else {
				$department_id = '';
			}
		} else {
			$department_id = '';
		}

		//$all_users = $this->doctor_model->get_user_ids();

		//print '<pre>';print_r($all_users);exit;

		$data['title'] = 'Doctor List';
		$data['doctors'] = $this->doctor_model->read($department_id);
		$data['department_list'] = $this->department_model->department_list();
		$data['query_depart_id'] = $department_id;
		$data['content'] = $this->load->view('doctor',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 

	public function email_check($email,$user_id)
    {
        $emailExists = $this->db->select('email')
            ->where('email',$email) 
            ->where_not_in('user_id',$user_id) 
            ->get('user')
            ->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email_check', 'The {field} field must contain a unique value.');
            return false;
        } else {
            return true;
        }
    }

	public function create()
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		} elseif ($this->session->userdata('user_role') == 1) {
			redirect('hospital');
		}
		

		$data['title'] = 'Add Doctor';
		#-------------------------------#
		$this->form_validation->set_rules('firstname', 'Name' ,'required|max_length[50]');
		$this->form_validation->set_rules('specialist', 'Speciality','required|max_length[50]');

		if ($this->input->post('user_id',true) == null) {
			$this->form_validation->set_rules('email', 'Email','required|max_length[50]|valid_email|is_unique[user.email]');
		} else {
			$cur_user_id = $this->input->post('user_id',true);
			$this->form_validation->set_rules('email', 'Email', "required|max_length[50]|valid_email|callback_email_check[$cur_user_id]");
		}

		$this->form_validation->set_rules('mobile', 'Phone Number','required|max_length[20]');
		
		$this->form_validation->set_rules('start_career', 'Start Career','max_length[10]');
		$this->form_validation->set_rules('registration_number', 'Registration Number','required|max_length[255]');
		$this->form_validation->set_rules('consultancy_fees', 'Consultancy fees','required|max_length[10]');
		$this->form_validation->set_rules('consultancy_validity', 'Consultancy validity','required|max_length[10]');

		$this->form_validation->set_rules('experience', 'Experience','required|max_length[50]');

		#-------------------------------#
		//picture upload
		$picture = $this->fileupload->do_upload(
			'assets/images/doctor/',
			'picture'
		);
		// if picture is uploaded then resize the picture
		if ($picture !== false && $picture != null) {
			$this->fileupload->do_resize( 
                $picture, 293, 350
			);
		}
		//if picture is not uploaded
		if ($picture === false) {
			$this->session->set_flashdata('exception', 'Invalid Picture');
		}
		#-------------------------------# 
		//when create a user
		if ($this->input->post('user_id',true) == null) {
			$data['doctor'] = (object)$postData = [
				'user_id'      => $this->input->post('user_id',true),
				'firstname'    => $this->input->post('firstname',true),
				'specialist' 	   => $this->input->post('specialist',true),
				'mobile'       => $this->input->post('mobile',true),
				'email' 	   => $this->input->post('email',true),
				'start_career' => date('Y-m-d', strtotime(($this->input->post('start_career',true) != null)? $this->input->post('start_career',true): date('Y-m-d'))),
				'password' 	   => md5('admin@123'),
				'user_role'    => 3,
				'registration_number'  => $this->input->post('registration_number',true),
				'consultancy_fees' 	   => $this->input->post('consultancy_fees',true),
				'consultancy_validity' 	   => $this->input->post('consultancy_validity',true),
				'department_id' => $this->input->post('department_id',true),
				'experience' => $this->input->post('experience',true),
				'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture', true)),
				'created_by'   => $this->session->userdata('user_id'),
				'updated_by'   => $this->session->userdata('user_id'),
				'create_date'  => date('Y-m-d'),
				'update_date'  => date('Y-m-d'),
				'status'       => 1,
			]; 
		} else { //update a user
			$data['doctor'] = (object)$postData = [
				'user_id'      => $this->input->post('user_id',true),
				'firstname'    => $this->input->post('firstname',true),
				'specialist' 	   => $this->input->post('specialist',true),
				'mobile'       => $this->input->post('mobile',true),
				'email' 	   => $this->input->post('email',true),
				'start_career' => date('Y-m-d', strtotime(($this->input->post('start_career',true) != null)? $this->input->post('start_career',true): date('Y-m-d'))),
				'registration_number'  => $this->input->post('registration_number',true),
				'consultancy_fees' 	   => $this->input->post('consultancy_fees',true),
				'consultancy_validity' 	   => $this->input->post('consultancy_validity',true),
				'department_id' => $this->input->post('department_id',true),
				'experience' => $this->input->post('experience',true),
				'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture', true)),
				'updated_by'   => $this->session->userdata('user_id'),
				'update_date'  => date('Y-m-d')
			]; 
		}
		
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $user_id then insert data
			if (empty($postData['user_id'])) {
				if ($this->doctor_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Doctor has been added successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}

				//update profile picture
				if ($postData['user_id'] == $this->session->userdata('user_id')) {
					$this->session->set_userdata([
						'picture'   => $postData['picture'],
						'fullname'  => $postData['firstname'].' '.$postData['lastname']
					]); 
				}

				redirect('doctor/create');
			} else {
				if ($this->doctor_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'The Doctor details have been updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}
				
				redirect('doctor/edit/'.$postData['user_id']);
			}

		} else {
			$data['department_list'] = $this->department_model->department_list();
			$data['content'] = $this->load->view('doctor_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}
 

	public function profile($user_id = null)
	{
		$data['title'] = 'View Details';
		#-------------------------------#
		$data['user'] = $this->doctor_model->read_by_id($user_id);
		//print_r($data['user']);exit;
		$data['user_schedule'] = $this->doctor_schedule_by_id($user_id);
		//print '<pre>';print_r($data['user_schedule']);exit;
		$data['content'] = $this->load->view('doctor_profile',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function edit($user_id = null) 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		} elseif ($this->session->userdata('user_role') == 1) {
			redirect('hospital');
		}
		
		$user_role = $this->session->userdata('user_role');
		if ($user_role == 1 && $this->session->userdata('user_id') == $user_id)
			$data['title'] = 'Edit Profile';  
		elseif ($user_role == 2)
			$data['title'] = 'Edit Profile';
		else
			$data['title'] = 'Edit Profile';  
		#-------------------------------#
		$data['department_list'] = $this->department_model->department_list(); 
		$data['doctor'] = $this->doctor_model->read_by_id($user_id);
		#-------------------------------#
		/*if (($data['doctor']->user_id != $this->session->userdata('user_id'))
		&& $this->session->userdata('user_role') != 1)
			redirect('login');*/
		#-------------------------------#
		$data['content'] = $this->load->view('doctor_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}
 

	public function delete($user_id = null) 
	{ 
		if ($this->doctor_model->delete($user_id)) {
			#set success message
			$this->session->set_flashdata('message', 'The Doctor has been deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('doctor');
	}

	public function doctor_list_by_depart_id()
	{
		$department_id = $this->input->post('department_id', true);
		if($department_id) {
			$result = $this->db->select("user_id, firstname name")
			->from('user')
			->where('department_id',$department_id)
			->where('user_role',3)
			->where('status',1)
			->get()
			->result();
			echo json_encode($result);
		} else {
			echo json_encode(array());
		}
	}

	public function doctor_schedule_by_id($doctor_id = null)
    {
    	$doctor_post_id = $this->input->post('doctor_id', true);
    	//echo $doctor_post_id;exit;

    	if($doctor_post_id) {
    		$doctor_id = $doctor_post_id;
    	} else {
    		$doctor_id = $doctor_id;
    	}
        if (!empty($doctor_id)) {
            $date_sql = date('Y-m-d');
        	//$date_sql = date('2024-04-05');
        	//$date_sql = date('2024-03-04');
            $query = $this->db->select('*')
                ->from('schedule')
                ->where('doctor_id',$doctor_id) 
                ->where("end_date >=", "$date_sql")
                ->where('status','1')
                ->get();

            $list = null;
            if ($query->num_rows() > 0) {
            	$leave_days_dates = array();
            	$off_duty_days_dates = array();
            	$scheduled_days_dates = array();
                foreach ($query->result() as $value) {
                    //print_r($value);exit;
                    $leave_days_array = explode(',', $value->leave_days);
                    $leave_days = array_map('trim', $leave_days_array);

                    $leave_days_array1 = array();
                    foreach ($leave_days as $leave_row) {
                    	$leave_days_array1[] = date('Y-m-d', strtotime($leave_row));
                    }

                    array_push($leave_days_dates , ...$leave_days_array1);

                    $week_day = date('l', strtotime($date_sql));
                    $off_duty_days = explode(',', $value->off_duty_days);

                    $off_duty_days1 = $this->getDatesFromRange($value->start_date, $value->end_date, $off_duty_days);
                    array_push($off_duty_days_dates , ...$off_duty_days1);


                    $scheduled_days_dates1 = $this->getScheduledDatesFromRange($value->start_date, $value->end_date, $off_duty_days1, $leave_days_array1);
                   
                    array_push($scheduled_days_dates , ...$scheduled_days_dates1);


                    if(in_array($date_sql, $leave_days_array1)) {
                        $list = '<p>No schedule available</p>';
                        continue;
                    } elseif(in_array($week_day, $off_duty_days)) {
                        $list = '<p>No schedule available</p>';
                        continue;
                    } elseif(in_array($date_sql, $scheduled_days_dates1)) {
	                    if($value->start_time) {
	                        $start_slots = explode(',', $value->start_time);
	                        $end_slots = explode(',', $value->end_time);

	                        $total_time = 0;
	                        for ($k=0; $k < count($start_slots) ; $k++) {
	                        	$time_diff = $this->getTimeDiff($start_slots[$k], $end_slots[$k]);
	                        	$total_time = $total_time + $time_diff;
	                        }
	                       
	                       	$slot_time = floor($total_time/$value->petient_per_day);
	                       	//echo $slot_time;exit;

	                       	$slotsCount = 0;
	                       	$lastSlot = '';

	                        for ($i=0; $i < count($start_slots) ; $i++) {
	                        	$schedule_slots = $this->getTimeSlots($slot_time, $start_slots[$i], $end_slots[$i]);
	                        	//print '<pre>';print_r($schedule_slots);exit;
	                        	
	                        	foreach ($schedule_slots as $schedule_slot) {

	                        		if($slotsCount < $value->petient_per_day) {
	                        			$list .= "<button type='button' class='btn btn-success'>".date('h:i A', strtotime($schedule_slot['slot_start_time']))."</button>";
	                        		}
	                        		$slotsCount++;
	                        		$lastSlot = $schedule_slot;
	                        	}
	                        }

	                        if($slotsCount < $value->petient_per_day) {
                        		$list .= "<button type='button' class='btn btn-success'>".date('h:i A', strtotime($lastSlot['slot_end_time']))."</button>";
                        	}
	                    }
	                }
                }

                $data['off_duty_days_dates'] = $off_duty_days_dates;
                $data['leave_days_dates'] = $leave_days_dates;
                $data['scheduled_days_dates'] = $scheduled_days_dates;
                $data['message'] = $list;
                $data['status'] = true;
            } else {
            	$data['off_duty_days_dates'] = array();
                $data['leave_days_dates'] = array();
                $data['scheduled_days_dates'] = array();
                $data['message'] = '<p>No schedule available</p>';
                $data['status'] = false;
            } 
        } else {
        	$data['off_duty_days_dates'] = array();
            $data['leave_days_dates'] = array();
            $data['scheduled_days_dates'] = array();
            $data['message'] = '<p>No schedule available</p>';
            $data['status']  = null;
        }

        //print '<pre>';print_r($scheduled_days_dates);exit;
        if($doctor_post_id) {
        	echo json_encode($data);
        } else {
        	return $data;
        }
        
    }

    public function getScheduledDatesFromRange($start, $end, $off_duty_days, $leave_days_array, $format = 'Y-m-d') {
    	// Declare an empty array 
	    $array = array(); 
	      
	    // Variable that store the date interval 
	    // of period 1 day 
	    $interval = new DateInterval('P1D'); 
	  
	    $realEnd = new DateTime($end); 
	    $realEnd->add($interval); 
	  
	    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
	  
	    // Use loop to store date into array 
	    foreach($period as $date) {
	    	$cur_date = $date->format($format);
	    	if(in_array($cur_date, $off_duty_days)) {
	    		continue;
	    	} elseif(in_array($cur_date, $leave_days_array)) {
	    		continue;
	    	} else {
	    		$array[] = $cur_date;
	    	}
	    } 
	  
	    // Return the array elements 
	    return $array; 
    }

    // Function to get all the dates in given range 
	public function getDatesFromRange($start, $end, $off_duty_days, $format = 'Y-m-d') { 
	      
	    // Declare an empty array 
	    $array = array(); 
	      
	    // Variable that store the date interval 
	    // of period 1 day 
	    $interval = new DateInterval('P1D'); 
	  
	    $realEnd = new DateTime($end); 
	    $realEnd->add($interval); 
	  
	    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
	  
	    // Use loop to store date into array 
	    foreach($period as $date) {
	    	$cur_date = $date->format($format);
	    	$week_day = date('l', strtotime($cur_date));
	    	if(in_array($week_day, $off_duty_days)) {
	    		$array[] = $cur_date;
	    	}
	    } 
	  
	    // Return the array elements 
	    return $array; 
	}

    public function doctor_schedule_by_date()
    {
        $doctor_id = $this->input->post('doctor_id', true);
        $date = $this->input->post('date', true);

        if (!empty($doctor_id) && !empty($date)) {
            $date_sql = date('Y-m-d', strtotime($date));
            $query = $this->db->select('*')
                ->from('schedule')
                ->where('doctor_id',$doctor_id) 
                ->where("'$date_sql' BETWEEN start_date and end_date")
                ->where('status','1')
                ->get();

            $list = null;
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $value) {
                    //print_r($value);exit;
                    $leave_days_array = explode(',', $value->leave_days);
                    $leave_days = array_map('trim', $leave_days_array);
                    
                    $leave_days_array1 = array();
                    foreach ($leave_days as $leave_row) {
                    	$leave_days_array1[] = date('Y-m-d', strtotime($leave_row));
                    }
                    
                    $week_day = date('l', strtotime($date_sql));
                    $off_duty_days = explode(',', $value->off_duty_days);

                    if(in_array($date_sql, $leave_days_array1)) {
                        $list = '<p>No schedule available</p>';
                        continue;
                    } elseif(in_array($week_day, $off_duty_days)) {
                        $list = '<p>No schedule available</p>';
                        continue;
                    } else {
	                    if($value->start_time) {
	                        $start_slots = explode(',', $value->start_time);
	                        $end_slots = explode(',', $value->end_time);

	                        $total_time = 0;
	                        for ($k=0; $k < count($start_slots) ; $k++) {
	                        	$time_diff = $this->getTimeDiff($start_slots[$k], $end_slots[$k]);
	                        	$total_time = $total_time + $time_diff;
	                        }
	                        //echo $total_time;exit;
	                       	$slot_time = floor($total_time/$value->petient_per_day);
	                       	//echo $slot_time;exit;

	                       	$slotsCount = 0;
	                       	$lastSlot = '';

	                        for ($i=0; $i < count($start_slots) ; $i++) {
	                        	$schedule_slots = $this->getTimeSlots($slot_time, $start_slots[$i], $end_slots[$i]);
	                        	
	                        	foreach ($schedule_slots as $schedule_slot) {

	                        		//print_r($schedule_slot);exit;
	                        		if($slotsCount < $value->petient_per_day) {
		                        		$list .= "<button type='button' class='btn btn-success'>".date('h:i A', strtotime($schedule_slot['slot_start_time']))."</button>";
		                        	}

	                        		$slotsCount++;
	                        		$lastSlot = $schedule_slot;
	                        	}
	                        	
	                        }

	                        if($slotsCount < $value->petient_per_day) {
                        		$list .= "<button type='button' class='btn btn-success'>".date('h:i A', strtotime($lastSlot['slot_end_time']))."</button>";
                        	}
	                    }
	                }
                } 
                $data['message'] = $list;
                $data['status'] = true;
            } else {
                $data['message'] = '<p>No schedule available</p>';
                $data['status'] = false;
            } 
        } else { 
            $data['status']  = null;
        }

        echo json_encode($data);
    }

    function getTimeDiff($start_time, $end_time) {
    	$start = new DateTime($start_time); 
		$end = new DateTime($end_time);
		$datetime_1 = $start->format('H:i');
	    $datetime_2 = $end->format('H:i');
		 
		$from_time = strtotime($datetime_1); 
		$to_time = strtotime($datetime_2); 
		$diff_minutes = round(abs($from_time - $to_time) / 60,2);
		return $diff_minutes;
    }

    function getTimeSlots($interval, $start_time, $end_time)
	{
	    $start = new DateTime($start_time);
	    $end = new DateTime($end_time);
	    $startTime = $start->format('H:i');
	    $endTime = $end->format('H:i');

	    $i=0;
	    $time = [];
	    while(strtotime($startTime) <= strtotime($endTime)){
	        $start = $startTime;
	        $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
	        $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
	        $i++;
	        if(strtotime($startTime) <= strtotime($endTime)){
	            $time[$i]['slot_start_time'] = $start;
	            $time[$i]['slot_end_time'] = $end;
	        }
	    }
	    return $time;
	}

	public function check_doctor_schedule()
    {
        $doctor_id = $this->input->post('doctor_id', true);
        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);

        if (!empty($doctor_id) && !empty($start_date) && !empty($end_date)) {
            $start_date_sql = date('Y-m-d', strtotime($start_date));
            $end_date_sql = date('Y-m-d', strtotime($end_date));
            $result = $this->db->select('*')
                ->from('schedule')
                ->where('doctor_id',$doctor_id) 
                ->where("'$start_date_sql' BETWEEN start_date AND end_date")
                ->get()
                ->row();

            if ($result) {
            	$message = "There is already a schedule available between ".$result->start_date." and ".$result->end_date.". Do you want to modify the existing schedule ?";
                $data['message'] = $message;
                $data['result'] = $result;
                $data['status'] = true;
            } else {
            	$data['message'] = '';
                $data['result'] = '';
                $data['status'] = false;
            } 
        } else {
        	$data['message'] = '';
        	$data['result'] = '';
            $data['status']  = false;
        }

        echo json_encode($data);
    }

}
