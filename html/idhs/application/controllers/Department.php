<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'department_model'
		));
		
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		} elseif ($this->session->userdata('user_role') == 1) {
			redirect('hospital');
		}

	}
 
	public function index()
	{
		$data['title'] = 'Department List';
		#-------------------------------#
		$data['departments'] = $this->department_model->read();
		$data['content'] = $this->load->view('department',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 

 	public function create()
	{
		$data['title'] = 'Add Department';
		#-------------------------------#
		$this->form_validation->set_rules('name', 'Department Name','required|max_length[100]');
		$this->form_validation->set_rules('description', 'Description','trim');
		$this->form_validation->set_rules('status', 'Status', 'required');
		#-------------------------------#
		$data['department'] = (object)$postData = [
			'dprt_id' 	  => $this->input->post('dprt_id',true),
			'name' 		  => $this->input->post('name',true),
			'description' => $this->input->post('description',true),
			'status'      => $this->input->post('status',true),
			'created_by'  => $this->session->userdata('user_id')
		]; 
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $dprt_id then insert data
			if (empty($postData['dprt_id'])) {
				if ($this->department_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Department added successfully.');
					redirect('department');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try later.');
					redirect('department/create');
				}
				
			} else {
				if ($this->department_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'The department updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try later.');
				}
				redirect('department/edit/'.$postData['dprt_id']);
			}

		} else {
			$data['content'] = $this->load->view('department_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}

	public function edit($dprt_id = null) 
	{
		$data['title'] = 'Edit Department';
		#-------------------------------#
		$data['department'] = $this->department_model->read_by_id($dprt_id);
		$data['content'] = $this->load->view('department_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}
 

	public function delete($dprt_id = null) 
	{
		if ($this->department_model->delete($dprt_id)) {
			#set success message
			$this->session->set_flashdata('message', 'The department deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try later.');
		}
		redirect('department');
	}
  
}
