<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'content_management_model'
		));

		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		}
	}

	public function about_us() 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		} elseif ($this->session->userdata('user_role') == 2) {
			redirect('doctor');
		}
		
		$data['title'] = 'About Us'; 
		$data['data'] = $this->content_management_model->read_by_id(1);
		$data['content'] = $this->load->view('aboutus_privacypolicy_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function privacy_policy() 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		} elseif ($this->session->userdata('user_role') == 2) {
			redirect('doctor');
		}
		
		$data['title'] = 'Privacy Policy'; 
		$data['data'] = $this->content_management_model->read_by_id(2);
		$data['content'] = $this->load->view('aboutus_privacypolicy_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function faq() 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		} elseif ($this->session->userdata('user_role') == 2) {
			redirect('doctor');
		}
		
		$data['title'] = 'FAQ'; 
		$data['faqs'] = $this->content_management_model->read('faq');
		$data['content'] = $this->load->view('faq_list',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function create()
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		} elseif ($this->session->userdata('user_role') == 2) {
			redirect('doctor');
		}
		
		$data['title'] = 'Add FAQ';
		
		$this->form_validation->set_rules('name', 'Name' ,'required|max_length[150]');
		$this->form_validation->set_rules('content', 'Content','required|max_length[300]');
		
		//when create a user
		if ($this->input->post('content_id',true) == null) {
			$data['faq'] = (object)$postData = [
				'content_id'      => $this->input->post('content_id',true),
				'name'    => $this->input->post('name',true),
				'content'       => $this->input->post('content',true),
				'type'			=> 'faq',
				'created_by'   => $this->session->userdata('user_id'),
				'updated_by'   => $this->session->userdata('user_id'),
				'created_at'  => date('Y-m-d'),
				'updated_at'  => date('Y-m-d')
			]; 
		} else { //update a user
			$data['faq'] = (object)$postData = [
				'content_id'      => $this->input->post('content_id',true),
				'name'    => $this->input->post('name',true),
				'content'       => $this->input->post('content',true),
				'updated_by'   => $this->session->userdata('user_id'),
				'updated_at'  => date('Y-m-d')
			]; 
		}
		
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $user_id then insert data
			if (empty($postData['content_id'])) {
				if ($this->content_management_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'The Faq has been added successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}

				redirect('content/faq');
			} else {
				if ($this->content_management_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'The Faq details have been updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}
				
				redirect('content/faq');
			}

		} else {
			$data['content'] = $this->load->view('faq_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}

	public function edit($content_id = null)
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		} elseif ($this->session->userdata('user_role') == 2) {
			redirect('doctor');
		}
		
		$user_role = $this->session->userdata('user_role');
		
		$data['title'] = 'Edit Faq'; 
		$data['faq'] = $this->content_management_model->read_by_id($content_id);
		$data['content'] = $this->load->view('faq_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function update() {
		if ($this->input->post('content_id',true) != null) {
			$postData = [
				'content_id' => $this->input->post('content_id',true),
				'content' => $this->input->post('content',true),
				'updated_by' => $this->session->userdata('user_id'),
				'updated_at' => date('Y-m-d')
			];

			if ($this->content_management_model->update($postData)) {
				#set success message
				$this->session->set_flashdata('message', 'Content has been updated successfully.');
			} else {
				#set exception message
				$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
			}
			redirect('content/about_us');
		}
	}

	public function delete($content_id = null) 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		} elseif ($this->session->userdata('user_role') != 1) {
			redirect('doctor');
		}

		if ($this->content_management_model->delete($content_id)) {
			#set success message
			$this->session->set_flashdata('message', 'The FAQ has been deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('content/faq');
	}
}
