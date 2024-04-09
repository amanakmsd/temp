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

	public function index()
	{  
		$data['title'] = 'Doctors Schedule List';
		$data['schedules'] = $this->schedule_model->read();
		$data['content'] = $this->load->view('schedule',$data,true);
		$this->load->view('layout/main_wrapper',$data);
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
		$this->form_validation->set_rules('petient_per_day', 'Total petient per day' ,'required|max_length[5]');
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
			'department_id'		=> $this->input->post('department_id',true),
			'created_by'   => $this->session->userdata('user_id'),
			'updated_by'   => $this->session->userdata('user_id')
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
				redirect('schedule');
			} else {

				if($this->input->post('add_schedule_between')) {
					//echo $postData['start_date'];exit;
					$date_before_start = date('Y-m-d', strtotime($postData['start_date'] .' -1 day'));
					$date_after_end = date('Y-m-d', strtotime($postData['end_date'] .' 1 day'));

					$scheduleObject = $this->schedule_model->read_by_id($postData['schedule_id']);

					$scheduleArray = $scheduleArray1 = (array) $scheduleObject;

					if($postData['start_date'] == $scheduleArray['start_date'] && $postData['end_date'] == $scheduleArray['end_date']) {
						if ($this->schedule_model->update($postData)) {
							#set success message
							$this->session->set_flashdata('message', 'Schedule updated successfully.');
						} else {
							#set exception message
							$this->session->set_flashdata('exception', 'Something went wrong! please try again.');
						}
					} elseif ($postData['start_date'] == $scheduleArray['start_date'] && $postData['end_date'] != $scheduleArray['end_date']) {
						$this->schedule_model->create($postData);
						$scheduleArray['start_date'] = $date_after_end;
						$this->schedule_model->update($scheduleArray);
					} elseif ($postData['start_date'] != $scheduleArray['start_date'] && $postData['end_date'] == $scheduleArray['end_date']) {
						$this->schedule_model->create($postData);
						$scheduleArray['end_date'] = $date_before_start;
						$this->schedule_model->update($scheduleArray);
					} else {
						$scheduleArray['end_date'] = $date_before_start;
						$scheduleArray1['start_date'] = $date_after_end;

						$this->schedule_model->create($postData);
						$this->schedule_model->update($scheduleArray);
						$this->schedule_model->create($scheduleArray1);
					}
					$this->session->set_flashdata('message', 'Schedule updated successfully.');
				} else {
					if ($this->schedule_model->update($postData)) {
						#set success message
						$this->session->set_flashdata('message', 'Schedule updated successfully.');
					} else {
						#set exception message
						$this->session->set_flashdata('exception', 'Something went wrong! please try again.');
					}
				}
				redirect('schedule');
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

	public function check_schedule_exists(
        $patient_id  = null,
        $doctor_id  = null,
        $schedule_id  = null,
        $date  = null 
    ) {
        if (!empty($patient_id) && !empty($doctor_id) && !empty($schedule_id)) {
            $num_rows = $this->db->select('*')
                ->from('appointment')
                ->where('patient_id', $patient_id)
                ->where('doctor_id', $doctor_id)
                ->where('schedule_id', $schedule_id) 
            ->where('date', $date)
                ->get()
                ->num_rows();
                
            if ($num_rows > 0) {
                return false;
            } else {
                return true; 
            }
        } else {
            return null; 
        }
    }
}
