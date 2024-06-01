<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Speciality extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'speciality_model'
		));

		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		}
		
	}

 
	public function index()
	{
		$data['title'] = 'Spciality List';
		$data['specialities'] = $this->speciality_model->read();
		$data['content'] = $this->load->view('speciality_list',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function create()
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		}
		
		$data['title'] = 'Add Speciality';

		$this->form_validation->set_rules('name', 'Name' ,'required|max_length[50]');
		
		//when create a user
		if ($this->input->post('speciality_id',true) == null) {
			$data['speciality'] = (object)$postData = [
				'speciality_id'      => $this->input->post('speciality_id',true),
				'name'    => $this->input->post('name',true),
				'created_by'   => $this->session->userdata('user_id'),
				'updated_by'   => $this->session->userdata('user_id'),
				'create_date'  => date('Y-m-d'),
				'update_date'  => date('Y-m-d')
			]; 
		} else { //update a user
			$data['speciality'] = (object)$postData = [
				'speciality_id'      => $this->input->post('speciality_id',true),
				'name'    => $this->input->post('name',true),
				'updated_by'   => $this->session->userdata('user_id'),
				'update_date'  => date('Y-m-d')
			]; 
		}
		
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $user_id then insert data
			if (empty($postData['speciality_id'])) {
				if ($this->speciality_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Speciality has been added successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}

				redirect('speciality');
			} else {
				if ($this->speciality_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Speciality details have been updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}
				
				redirect('speciality');
			}

		} else {
			$data['content'] = $this->load->view('speciality_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}

	public function edit($speciality_id = null) 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		}
		
		$data['title'] = 'Edit speciality'; 
		$data['speciality'] = $this->speciality_model->read_by_id($speciality_id);
		$data['content'] = $this->load->view('speciality_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}
 

	public function delete($speciality_id = null) 
	{ 
		if ($this->speciality_model->delete($speciality_id)) {
			#set success message
			$this->session->set_flashdata('message', 'Speciality has been deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('speciality');
	}
}
