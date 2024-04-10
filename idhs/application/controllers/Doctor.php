<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'doctor_model',
			'department_model'
		));

		if ($this->session->userdata('isLogIn') == false) {
			redirect('login');
		}
		
	}

 
	public function index()
	{
		$url_components = parse_url($_SERVER['REQUEST_URI']);
		if(isset($url_components['query'])) {
			parse_str($url_components['query'], $params);
			if(isset($params['department']) && $params['department'] != 'all') {
				$department_id = $params['department'];
			} else {
				$department_id = '';
			}
		} else {
			$department_id = '';
		}

		$data['title'] = 'Doctor List';
		$data['doctors'] = $this->doctor_model->read($department_id);
		$data['department_list'] = $this->department_model->department_list();
		$data['query_depart_id'] = $department_id;
		$data['content'] = $this->load->view('doctor',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	} 

	public function email_check($email,$user_id)
    {
        $emailExists = $this->db->select('email')
            ->where('email',$email) 
            ->where_not_in('user_id',$user_id) 
            ->get('user')
            ->num_rows();

        if ($emailExists > 0) {
            $this->form_validation->set_message('email_check', 'The {field} field must contain a unique value.');
            return false;
        } else {
            return true;
        }
    }

	public function create()
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		} elseif ($this->session->userdata('user_role') == 1) {
			redirect('hospital');
		}
		

		$data['title'] = 'Add Doctor';
		#-------------------------------#
		$this->form_validation->set_rules('firstname', 'Name' ,'required|max_length[50]');
		$this->form_validation->set_rules('specialist', 'Speciality','required|max_length[50]');

		if ($this->input->post('user_id',true) == null) {
			$this->form_validation->set_rules('email', 'Email','required|max_length[50]|valid_email|is_unique[user.email]');
		} else {
			$cur_user_id = $this->input->post('user_id',true);
			$this->form_validation->set_rules('email', 'Email', "required|max_length[50]|valid_email|callback_email_check[$cur_user_id]");
		}

		$this->form_validation->set_rules('mobile', 'Phone Number','required|max_length[20]');
		
		$this->form_validation->set_rules('start_career', 'Start Career','max_length[10]');
		$this->form_validation->set_rules('registration_number', 'Registration Number','required|max_length[255]');
		$this->form_validation->set_rules('consultancy_fees', 'Consultancy fees','required|max_length[255]');

		$this->form_validation->set_rules('experience', 'Experience','required|max_length[50]');

		#-------------------------------#
		//picture upload
		$picture = $this->fileupload->do_upload(
			'assets/images/doctor/',
			'picture'
		);
		// if picture is uploaded then resize the picture
		if ($picture !== false && $picture != null) {
			$this->fileupload->do_resize( 
                $picture, 293, 350
			);
		}
		//if picture is not uploaded
		if ($picture === false) {
			$this->session->set_flashdata('exception', 'Invalid Picture');
		}
		#-------------------------------# 
		//when create a user
		if ($this->input->post('user_id',true) == null) {
			$data['doctor'] = (object)$postData = [
				'user_id'      => $this->input->post('user_id',true),
				'firstname'    => $this->input->post('firstname',true),
				'specialist' 	   => $this->input->post('specialist',true),
				'mobile'       => $this->input->post('mobile',true),
				'email' 	   => $this->input->post('email',true),
				'start_career' => date('Y-m-d', strtotime(($this->input->post('start_career',true) != null)? $this->input->post('start_career',true): date('Y-m-d'))),
				'password' 	   => md5('admin@123'),
				'user_role'    => 3,
				'registration_number'  => $this->input->post('registration_number',true),
				'consultancy_fees' 	   => $this->input->post('consultancy_fees',true),
				'department_id' => $this->input->post('department_id',true),
				'experience' => $this->input->post('experience',true),
				'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture', true)),
				'created_by'   => $this->session->userdata('user_id'),
				'updated_by'   => $this->session->userdata('user_id'),
				'create_date'  => date('Y-m-d'),
				'update_date'  => date('Y-m-d'),
				'status'       => 1,
			]; 
		} else { //update a user
			$data['doctor'] = (object)$postData = [
				'user_id'      => $this->input->post('user_id',true),
				'firstname'    => $this->input->post('firstname',true),
				'specialist' 	   => $this->input->post('specialist',true),
				'mobile'       => $this->input->post('mobile',true),
				'email' 	   => $this->input->post('email',true),
				'start_career' => date('Y-m-d', strtotime(($this->input->post('start_career',true) != null)? $this->input->post('start_career',true): date('Y-m-d'))),
				'registration_number'  => $this->input->post('registration_number',true),
				'consultancy_fees' 	   => $this->input->post('consultancy_fees',true),
				'department_id' => $this->input->post('department_id',true),
				'experience' => $this->input->post('experience',true),
				'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture', true)),
				'updated_by'   => $this->session->userdata('user_id'),
				'update_date'  => date('Y-m-d')
			]; 
		}
		
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $user_id then insert data
			if (empty($postData['user_id'])) {
				if ($this->doctor_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Doctor has been added successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}

				//update profile picture
				if ($postData['user_id'] == $this->session->userdata('user_id')) {
					$this->session->set_userdata([
						'picture'   => $postData['picture'],
						'fullname'  => $postData['firstname'].' '.$postData['lastname']
					]); 
				}

				redirect('doctor/create');
			} else {
				if ($this->doctor_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'The Doctor details have been updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}
				
				redirect('doctor/edit/'.$postData['user_id']);
			}

		} else {
			$data['department_list'] = $this->department_model->department_list(); 
			$data['content'] = $this->load->view('doctor_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}
 

	public function profile($user_id = null)
	{
		$data['title'] = 'View Details';
		#-------------------------------#
		$data['user'] = $this->doctor_model->read_by_id($user_id);
		$data['content'] = $this->load->view('doctor_profile',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function edit($user_id = null) 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		} elseif ($this->session->userdata('user_role') == 1) {
			redirect('hospital');
		}
		
		$user_role = $this->session->userdata('user_role');
		if ($user_role == 1 && $this->session->userdata('user_id') == $user_id)
			$data['title'] = 'Edit Profile';  
		elseif ($user_role == 2)
			$data['title'] = 'Edit Profile';
		else
			$data['title'] = 'Edit Profile';  
		#-------------------------------#
		$data['department_list'] = $this->department_model->department_list(); 
		$data['doctor'] = $this->doctor_model->read_by_id($user_id);
		#-------------------------------#
		/*if (($data['doctor']->user_id != $this->session->userdata('user_id'))
		&& $this->session->userdata('user_role') != 1)
			redirect('login');*/
		#-------------------------------#
		$data['content'] = $this->load->view('doctor_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}
 

	public function delete($user_id = null) 
	{ 
		if ($this->doctor_model->delete($user_id)) {
			#set success message
			$this->session->set_flashdata('message', 'The Doctor has been deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('doctor');
	}

	public function doctor_list_by_depart_id()
	{
		$department_id = $this->input->post('department_id', true);
		if($department_id) {
			$result = $this->db->select("user_id, firstname name")
			->from('user')
			->where('department_id',$department_id)
			->where('user_role',3)
			->where('status',1)
			->get()
			->result();
			echo json_encode($result);
		} else {
			echo json_encode(array());
		}
	}

}
