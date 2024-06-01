<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'patient_model',
			'booking_model'
		));

		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		}
		
	}

 
	public function index()
	{
		$data['title'] = 'Patient List';
		$data['patients'] = $this->patient_model->read();
		$data['content'] = $this->load->view('patient',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function profile($user_id = null)
	{
		$user_id = $this->my_encrypt->decode($user_id);

		$data['title'] = 'View Details';
		$data['user'] = $this->patient_model->read_by_id($user_id);
		$data['user_booking'] = $this->booking_model->read_by_patient_id($user_id);
		$data['content'] = $this->load->view('patient_profile',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function delete($user_id = null) 
	{ 
		$user_id = $this->my_encrypt->decode($user_id);
		
		if ($this->patient_model->delete($user_id)) {
			#set success message
			$this->session->set_flashdata('message', 'The Patient has been deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('patient');
	}
}
