<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disease extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'disease_model',
			'organ_model'
		));

		if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		}
		
	}

 
	public function index()
	{
		$diseaseTypeList = array( 
            'top_care' => '1',
            'seasonal_care' => '2',
            'emergency_care' => '3'
        );

		$url_components = parse_url($_SERVER['REQUEST_URI']);
		if(isset($url_components['query'])) {
			parse_str($url_components['query'], $params);
			if(isset($params['disease_type']) && $params['disease_type'] != 'all') {
				$disease_type = $diseaseTypeList[$params['disease_type']];
				$query_disease_id = $params['disease_type'];
			} else {
				$disease_type = '';
				$query_disease_id = '';
			}
		} else {
			$disease_type = '';
			$query_disease_id = '';
		}

		$data['title'] = 'Disease List';
		$data['query_disease_id'] = $query_disease_id;
		$data['organ_list'] = $this->organ_model->organ_list();
		$data['diseases'] = $this->disease_model->read($disease_type);
		$data['content'] = $this->load->view('disease_list',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

	public function create()
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}
		
		$data['title'] = 'Add Disease';

		$this->form_validation->set_rules('name', 'Name' ,'required|max_length[50]');
		$this->form_validation->set_rules('organ_related[]', 'Organs Related','required');
		$this->form_validation->set_rules('disease_type', 'Disease Type' ,'required|max_length[50]');
		
		//when create a user
		if ($this->input->post('disease_id',true) == null) {
			$data['disease'] = (object)$postData = [
				'disease_id'      => $this->input->post('disease_id',true),
				'name'    => $this->input->post('name',true),
				'disease_type'    => $this->input->post('disease_type',true),
				'organ_related'		=> !empty($this->input->post('organ_related',true)) ? implode(',',$this->input->post('organ_related',true)) : '',
				'created_by'   => $this->session->userdata('user_id'),
				'updated_by'   => $this->session->userdata('user_id'),
				'create_date'  => date('Y-m-d'),
				'update_date'  => date('Y-m-d')
			]; 
		} else { //update a user
			$data['disease'] = (object)$postData = [
				'disease_id'      => $this->input->post('disease_id',true),
				'name'    => $this->input->post('name',true),
				'disease_type'    => $this->input->post('disease_type',true),
				'organ_related'		=> !empty($this->input->post('organ_related',true)) ? implode(',',$this->input->post('organ_related',true)) : '',
				'updated_by'   => $this->session->userdata('user_id'),
				'update_date'  => date('Y-m-d')
			]; 
		}
		
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $user_id then insert data
			if (empty($postData['disease_id'])) {
				if ($this->disease_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Disease has been added successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}

				redirect('disease');
			} else {
				if ($this->disease_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Disease details have been updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}
				
				redirect('disease');
			}

		} else {
			$data['organ_list'] = $this->organ_model->organ_list();
			$data['content'] = $this->load->view('disease_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}

	public function edit($disease_id = null) 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}

		$disease_id = $this->my_encrypt->decode($disease_id);
		
		$data['title'] = 'Edit Disease';
		$data['organ_list'] = $this->organ_model->organ_list();
		$data['disease'] = $this->disease_model->read_by_id($disease_id);
		$data['content'] = $this->load->view('disease_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}
 

	public function delete($disease_id = null) 
	{
		$disease_id = $this->my_encrypt->decode($disease_id);
		
		if ($this->disease_model->delete($disease_id)) {
			#set success message
			$this->session->set_flashdata('message', 'Disease has been deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('disease');
	}
}
