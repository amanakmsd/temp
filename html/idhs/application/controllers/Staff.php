<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'staff_model',
			'mail_model'
		));

		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}
		
	}

 
	public function index()
	{
		$data['title'] = 'Staff List';
		$data['staffs'] = $this->staff_model->read();
		$data['content'] = $this->load->view('staff',$data,true);
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
		

		$data['title'] = 'Add Staff';
		#-------------------------------#
		$this->form_validation->set_rules('firstname', 'Name' ,'required|max_length[50]');

		if ($this->input->post('user_id',true) == null) {
			$this->form_validation->set_rules('email', 'Email','required|max_length[50]|valid_email|is_unique[user.email]');
		} else {
			$cur_user_id = $this->input->post('user_id',true);
			$this->form_validation->set_rules('email', 'Email', "required|max_length[50]|valid_email|callback_email_check[$cur_user_id]");
		}
		$this->form_validation->set_rules('mobile', 'Phone Number','required|max_length[20]');
		$this->form_validation->set_rules('relationship', 'Role','required|max_length[50]');

		#-------------------------------#
		//picture upload
		$picture = $this->fileupload->do_upload(
			'assets/images/staff/',
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

		$passwordText = $this->getRandomString();
		#-------------------------------# 
		//when create a user
		if ($this->input->post('user_id',true) == null) {
			//print '<pre>';print_r($this->input->post('user_permissions',true));exit;
			$data['staff'] = (object)$postData = [
				'user_id'      => $this->input->post('user_id',true),
				'firstname'    => $this->input->post('firstname',true),
				'mobile'       => $this->input->post('mobile',true),
				'email' 	   => $this->input->post('email',true),
				'relationship' 	   => $this->input->post('relationship',true),
				'password' 	   => md5($passwordText),
				'user_role'    => 4,
				'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture', true)),
				'created_by'   => $this->session->userdata('user_id'),
				'updated_by'   => $this->session->userdata('user_id'),
				'create_date'  => date('Y-m-d'),
				'update_date'  => date('Y-m-d'),
				'status'       => 1,
				'user_permissions' => !empty($this->input->post('user_permissions',true)) ? implode(',',$this->input->post('user_permissions',true)) : ''
			]; 
		} else { //update a user
			$data['staff'] = (object)$postData = [
				'user_id'      => $this->input->post('user_id',true),
				'firstname'    => $this->input->post('firstname',true),
				'specialist' 	   => $this->input->post('specialist',true),
				'mobile'       => $this->input->post('mobile',true),
				'email' 	   => $this->input->post('email',true),
				'relationship' 	   => $this->input->post('relationship',true),
				'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture', true)),
				'updated_by'   => $this->session->userdata('user_id'),
				'update_date'  => date('Y-m-d'),
				'user_permissions' => !empty($this->input->post('user_permissions',true)) ? implode(',',$this->input->post('user_permissions',true)) : ''
			]; 
		}
		
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $user_id then insert data
			if (empty($postData['user_id'])) {
				if ($this->staff_model->create($postData)) {

					$user_data['name'] = $postData['firstname'];
					$user_data['email'] = $postData['email'];
					$user_data['password'] = $passwordText;
					$user_data['subject'] = "Welcome to ".$this->session->userdata('fullname')." – Access Your Staff Panel";
					$user_data['mail_type'] = 'staff_onboard';
					$user_data['hospital_name'] = $this->session->userdata('fullname');
					
					$mail_sent_status = $this->mail_model->send_mail($user_data);
					#set success message
					$this->session->set_flashdata('message', 'Staff has been added successfully and a mail has been sent to hospital with credentials.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}

				redirect('staff');
			} else {
				if ($this->staff_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'The staff details have been updated successfully.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}
				
				redirect('staff');
			}

		} else {
			$data['content'] = $this->load->view('staff_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}

	public function edit($user_id = null) 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		} elseif ($this->session->userdata('user_role') == 1) {
			redirect('hospital');
		}
		
		$user_role = $this->session->userdata('user_role');
		
		$data['title'] = 'Edit Profile'; 
		$data['staff'] = $this->staff_model->read_by_id($user_id);
		$data['content'] = $this->load->view('staff_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}
 

	public function delete($user_id = null) 
	{ 
		if ($this->staff_model->delete($user_id)) {
			#set success message
			$this->session->set_flashdata('message', 'The Staff has been deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('staff');
	}

	public function getRandomString() {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	 
	    for ($i = 0; $i < 6; $i++) {
	        $index = rand(0, strlen($characters) - 1);
	        $randomString .= $characters[$index];
	    }
	 
	    return $randomString;
	}
}
