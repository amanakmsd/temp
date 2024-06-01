<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'package_model',
			'department_model'
		));

		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}
		
	}

 
	public function index()
	{
		$data['title'] = 'Packages';
		$data['packages'] = $this->package_model->read();
		$data['content'] = $this->load->view('package',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function subscribed()
	{
		$data['title'] = 'Subscribed';
		$data['packages'] = $this->package_model->package_subscribed();
		$data['content'] = $this->load->view('package_subscribed',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function create()
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}
		
		$data['title'] = 'Add Package';
		
		$this->form_validation->set_rules('name', 'Name' ,'required|max_length[50]');
		$this->form_validation->set_rules('price', 'Price','required|max_length[20]');
		$this->form_validation->set_rules('start_date', 'Start Date','required|max_length[20]');
		$this->form_validation->set_rules('end_date', 'End Date','required|max_length[20]');

		if($this->session->userdata('user_role') != 1) { 
			$this->form_validation->set_rules('department_id', 'Department','required');
			$this->form_validation->set_rules('test_includes', 'Test Includes','required');
		}
		
		$this->form_validation->set_rules('description', 'Description','required');

		
		//when create a user
		if ($this->input->post('package_id',true) == null) {
			$data['package'] = (object)$postData = [
				'package_id'      => $this->input->post('package_id',true),
				'name'    => $this->input->post('name',true),
				'price'       => $this->input->post('price',true),
				'department_id' 	   => $this->input->post('department_id',true),
				'test_includes' 	   => $this->input->post('test_includes',true),
				'description' 	   => $this->input->post('description',true),
				'start_date'		=> !empty($this->input->post('start_date',true)) ? date('Y-m-d',strtotime($this->input->post('start_date',true))) : '',
				'end_date'		=> !empty($this->input->post('end_date',true)) ? date('Y-m-d',strtotime($this->input->post('end_date',true))) : '',
				'created_by'   => $this->session->userdata('user_id'),
				'updated_by'   => $this->session->userdata('user_id'),
				'create_date'  => date('Y-m-d'),
				'update_date'  => date('Y-m-d')
			]; 
		} else { //update a user
			$data['package'] = (object)$postData = [
				'package_id'      => $this->input->post('package_id',true),
				'name'    => $this->input->post('name',true),
				'price'       => $this->input->post('price',true),
				'department_id' 	   => $this->input->post('department_id',true),
				'test_includes' 	   => $this->input->post('test_includes',true),
				'description' 	   => $this->input->post('description',true),
				'start_date'		=> !empty($this->input->post('start_date',true)) ? date('Y-m-d',strtotime($this->input->post('start_date',true))) : '',
				'end_date'		=> !empty($this->input->post('end_date',true)) ? date('Y-m-d',strtotime($this->input->post('end_date',true))) : '',
				'updated_by'   => $this->session->userdata('user_id'),
				'update_date'  => date('Y-m-d')
			]; 
		}
		
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $user_id then insert data
			if (empty($postData['package_id'])) {
				if ($this->package_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Package has been added successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}

				redirect('package');
			} else {
				if ($this->package_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Package details have been updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}
				
				redirect('package');
			}

		} else {
			$data['department_list'] = $this->department_model->department_list();
			$data['content'] = $this->load->view('package_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}

	public function edit($package_id = null) 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}
		
		$data['department_list'] = $this->department_model->department_list();
		$data['title'] = 'Edit Package'; 
		$data['package'] = $this->package_model->read_by_id($package_id);
		$data['content'] = $this->load->view('package_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}
 

	public function delete($package_id = null) 
	{ 
		if ($this->package_model->delete($package_id)) {
			#set success message
			$this->session->set_flashdata('message', 'Package has been deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('package');
	}
}
