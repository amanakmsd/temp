<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organ extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'organ_model'
		));

		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		}
		
	}

 
	public function index()
	{
		$data['title'] = 'Organs';
		$data['organs'] = $this->organ_model->read();
		$data['content'] = $this->load->view('organ_list',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function create()
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		}
		
		$data['title'] = 'Add Organ';

		$this->form_validation->set_rules('name', 'Name' ,'required|max_length[50]');
		
		//when create a user
		if ($this->input->post('organ_id',true) == null) {
			$data['organ'] = (object)$postData = [
				'organ_id'      => $this->input->post('organ_id',true),
				'name'    => $this->input->post('name',true),
				'created_by'   => $this->session->userdata('user_id'),
				'updated_by'   => $this->session->userdata('user_id'),
				'create_date'  => date('Y-m-d'),
				'update_date'  => date('Y-m-d')
			]; 
		} else { //update a user
			$data['organ'] = (object)$postData = [
				'organ_id'      => $this->input->post('organ_id',true),
				'name'    => $this->input->post('name',true),
				'updated_by'   => $this->session->userdata('user_id'),
				'update_date'  => date('Y-m-d')
			]; 
		}
		
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $user_id then insert data
			if (empty($postData['organ_id'])) {
				if ($this->organ_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Organ has been added successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}

				redirect('organ');
			} else {
				if ($this->organ_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Organ details have been updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}
				
				redirect('organ');
			}

		} else {
			$data['content'] = $this->load->view('organ_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}

	public function edit($organ_id = null) 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		}
		
		$data['title'] = 'Edit Organ'; 
		$data['organ'] = $this->organ_model->read_by_id($organ_id);
		$data['content'] = $this->load->view('organ_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}
 

	public function delete($organ_id = null) 
	{ 
		if ($this->organ_model->delete($organ_id)) {
			#set success message
			$this->session->set_flashdata('message', 'Organ has been deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('organ');
	}
}
