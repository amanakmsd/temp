<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'schedule_model',
			'doctor_model',
			'department_model'
		));
		
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}

	}

 	public function create()
	{
		if ($this->session->userdata('user_role') == 1) {
			redirect('hospital');
		}

		$data['title'] = 'Add Schedule';  
		#-------------------------------#
		$this->form_validation->set_rules('department_id', 'Department','required|min_length[1]');
		$this->form_validation->set_rules('doctor_id', 'Doctor Name','required|min_length[1]');
		$this->form_validation->set_rules('start_date', 'Start Date','required|max_length[10]');
		$this->form_validation->set_rules('end_date', 'End Date','required|max_length[10]');
		$this->form_validation->set_rules('start_time[]', 'Start Time','required|min_length[1]');
		$this->form_validation->set_rules('end_time[]', 'End Time','required|min_length[1]');
		$this->form_validation->set_rules('off_duty_days[]', 'Off duty days','min_length[4]');
		$this->form_validation->set_rules('petient_per_day', 'Total petient per day' ,'max_length[5]');
		$this->form_validation->set_rules('status', 'Status','required');
		#-------------------------------# 
		$data['schedule'] = (object)$postData = [
			'schedule_id' 	 	=> $this->input->post('schedule_id',true),
			'doctor_id' 	 	=> $this->input->post('doctor_id',true),
			'start_time' 	 	=> !empty($this->input->post('start_time',true)) ? implode(',',$this->input->post('start_time',true)) : '',
			'end_time' 	 	 	=> !empty($this->input->post('end_time',true)) ? implode(',',$this->input->post('end_time',true)) : '',
			'status'         	=> $this->input->post('status',true),
			'off_duty_days'		=> !empty($this->input->post('off_duty_days',true)) ? implode(',',$this->input->post('off_duty_days',true)) : '',
			'petient_per_day'	=> $this->input->post('petient_per_day',true),
			'leave_days'		=> $this->input->post('leave_days',true),
			'start_date'		=> !empty($this->input->post('start_date',true)) ? date('Y-m-d',strtotime($this->input->post('start_date',true))) : '',
			'end_date'		=> !empty($this->input->post('end_date',true)) ? date('Y-m-d',strtotime($this->input->post('end_date',true))) : '',
			'department_id'		=> $this->input->post('department_id',true)
		];  
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $schedule_id then insert data
			if (empty($postData['schedule_id'])) {
				
				if ($this->schedule_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message','The schedule for the doctor has been added successfully in the system.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! please try again.');
				}
				redirect('schedule/create');
			} else {
				if ($this->schedule_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Schedule updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! please try again.');
				}
				redirect('schedule/edit/'.$postData['schedule_id']);
			}

		} else {
			$data['doctor_list'] = $this->doctor_model->doctor_list();
			$data['department_list'] = $this->department_model->department_list();
			$data['content'] = $this->load->view('schedule_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		}
	}

	public function edit($schedule_id = null) 
	{
		if ($this->session->userdata('user_role') == 1) {
			redirect('hospital');
		}

		$data['title'] = 'Edit Schedule';
		#-------------------------------#
		$data['schedule'] = $this->schedule_model->read_by_id($schedule_id);
		$data['doctor_list'] = $this->doctor_model->doctor_list();
		$data['department_list'] = $this->department_model->department_list();
		$data['content'] = $this->load->view('schedule_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function delete($schedule_id = null) {
		if ($this->session->userdata('user_role') == 1) {
			redirect('hospital');
		}

		if ($this->schedule_model->delete($schedule_id)) {
			#set success message
			$this->session->set_flashdata('message', 'Schedule deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! please try again.');
		}
		redirect('schedule');
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
                    
                    if(in_array($date, $leave_days)) {
                        $list .= '<p>No schedule available</p>';
                        break;
                    }

                    $week_day = date('l', strtotime($date_sql));
                    $off_duty_days = explode(',', $value->off_duty_days);
                    if(in_array($week_day, $off_duty_days)) {
                        $list .= '<p>No schedule available</p>';
                        break;
                    }

                    if($value->start_time) {
                        $start_slots = explode(',', $value->start_time);
                        $end_slots = explode(',', $value->end_time);

                        for ($i=0; $i < count($start_slots) ; $i++) { 
                        	$list .= "<button type='button' class='btn btn-success'>".date('h:i A', strtotime($start_slots[$i]))." - ".date('h:i A', strtotime($end_slots[$i]))."</button>";
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


}
