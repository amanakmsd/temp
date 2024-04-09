<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'booking_model',
			'department_model',
			'mail_model'
		));

		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}
		
	}

 
	public function index()
	{
		$bookingTypeList = array( 
            'new' => '1',
            'on_going' => '2',
            'past' => '3'
        );

		$url_components = parse_url($_SERVER['REQUEST_URI']);
		if(isset($url_components['query'])) {
			parse_str($url_components['query'], $params);
			if(isset($params['booking_type']) && $params['booking_type'] != '') {
				$booking_type = $bookingTypeList[$params['booking_type']];
				$query_booking_id = $params['booking_type'];
			} else {
				$booking_type = '';
				$query_booking_id = '';
			}

			if(isset($params['department']) && $params['department'] != '') {
				$query_department_id = $params['department'];
			} else {
				$query_department_id = '';
			}

			if(isset($params['hospital_id']) && $params['hospital_id'] != '') {
				$query_hospital_id = $params['hospital_id'];
			} else {
				$query_hospital_id = '';
			}
		} else {
			$booking_type = '';
			$query_booking_id = '';
			$query_department_id = '';
			$query_hospital_id = '';
		}

		$data['title'] = 'Booking List';
		$data['query_booking_id'] = $query_booking_id;
		$data['query_department_id'] = $query_department_id;
		$data['query_hospital_id'] = $query_hospital_id;
		$data['department_list'] = $this->department_model->department_list();
		$data['hospital_list'] = $this->booking_model->hospital_list();
		$data['bookings'] = $this->booking_model->read($booking_type, $query_department_id, $query_hospital_id);
		$data['content'] = $this->load->view('booking_list',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function rescdule($booking_id = null) 
	{
		if ($this->booking_model->reschedule($booking_id)) {
			#set success message
			$this->session->set_flashdata('message', 'Booking has been rescheduled successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('booking');
	}

	public function reject($booking_id = null) 
	{	
		//$patient_data = $this->booking_model->get_patient_details($booking_id);
		//print '<pre>';print_r($patient_data);exit;
		if ($this->booking_model->reject($booking_id)) {
			#set success message
			$patient_data = $this->booking_model->get_patient_details($booking_id);
			$user_data['name'] = $patient_data['patient_name'];
			$user_data['email'] = $patient_data['patient_email'];
			$user_data['schedule_date_time'] = date('d M Y', strtotime($patient_data['schedule_date'])). ' '.$patient_data['schedule_time'];
			$user_data['subject'] = "Appointment Update from ".$patient_data['hospital_name']."";
			$user_data['mail_type'] = 'booking_rejection';
			$user_data['hospital_name'] = $patient_data['hospital_name'];
			
			$mail_sent_status = $this->mail_model->send_mail($user_data);
			//print '<pre>';print_r($mail_sent_status);exit;

			$this->session->set_flashdata('message', 'Booking has been rejected.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('booking');
	}
}
