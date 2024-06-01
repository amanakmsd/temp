<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hospital extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array(
			'hospital_model',
			'department_model',
			'organ_model',
			'speciality_model',
			'mail_model'
		));
	}

 
	public function index()
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		} elseif ($this->session->userdata('user_role') == 2) {
			redirect('doctor');
		}

		$data['title'] = 'Hospital List';
		$data['organ_list'] = $this->organ_model->organ_list();
		$data['speciality_list'] = $this->speciality_model->speciality_list();
		$data['hospitals'] = $this->hospital_model->read();
		$data['content'] = $this->load->view('hospital',$data,true);
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

    public function licenceno_check($licence_no, $user_id)
    {
        $licenceNoExists = $this->db->select('hospital_id')
            ->where('license_no',$licence_no) 
            ->where_not_in('user_id',$user_id) 
            ->get('hospital')
            ->num_rows();

        if ($licenceNoExists > 0) {
            $this->form_validation->set_message('licenceno_check', 'The {field} field must contain a unique value.');
            return false;
        } else {
            return true;
        }
    }
    
	public function create()
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}

		$data['title'] = 'Add Hospital';
		#-------------------------------#
		$this->form_validation->set_rules('name', 'Hospital Name', 'required|max_length[50]');
		if ($this->input->post('hospital_id',true) == null) {
			$this->form_validation->set_rules('email', 'Email','required|max_length[50]|valid_email|is_unique[user.email]');
			$this->form_validation->set_rules('license_no', 'Licence Number','required|max_length[50]|is_unique[hospital.license_no]');
		} else {
			$cur_user_id = $this->input->post('user_id',true);
			$this->form_validation->set_rules('email', 'Email', "required|max_length[50]|valid_email|callback_email_check[$cur_user_id]");
			$this->form_validation->set_rules('license_no', 'Licence Number', "required|max_length[50]|callback_licenceno_check[$cur_user_id]");
		}
		
		$this->form_validation->set_rules('year_of_commencement', 'Year of Commencement','required|max_length[10]');
		$this->form_validation->set_rules('hospital_ownership', 'Hospital Ownership','required|max_length[10]');
		$this->form_validation->set_rules('services_type', 'Services Type','required|max_length[50]');
		$this->form_validation->set_rules('pm_jay', 'PM-JAY' ,'required');
        $this->form_validation->set_rules('start_time', 'Hosptal Start Time' ,'required|max_length[10]');
        $this->form_validation->set_rules('end_time', 'Hospital End Time' ,'required|max_length[10]');
		$this->form_validation->set_rules('no_of_ambulance', 'No. of Ambulance','required|max_length[20]');
		$this->form_validation->set_rules('emergency_service', 'Emergency service availability','required');
		#-------------------------------#

		//Hospital images upload
		$hospital_images = $this->fileupload->do_multiple_upload(
			'assets/images/hospital/',
			'hospital_images'
		);

		//Logo upload
		$picture = $this->fileupload->do_upload(
			'assets/images/hospital/',
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

		/**********Get latitude and longitude*******/
		$gmapAddress = '';

		if($this->input->post('address',true)) {
			$gmapAddress = $gmapAddress.$this->input->post('address',true);
		}

		if($this->input->post('address2',true)) {
			$gmapAddress = $gmapAddress.', '.$this->input->post('address2',true);
		}

		if($this->input->post('city',true)) {
			$gmapAddress = $gmapAddress.', '.$this->input->post('city',true);
		}

		if($this->input->post('state',true)) {
			$gmapAddress = $gmapAddress.', '.$this->input->post('state',true);
		}

		$gmapAddress = $gmapAddress.', India';

		if($this->input->post('zip',true)) {
			$gmapAddress = $gmapAddress.', '.$this->input->post('zip',true);
		}

		$GOOGLE_API_KEY = 'AIzaSyD9ceQmvdZ9dRNtpCz6v6j9vYHT70RFvuc'; 
		// Formatted address 
		$formatted_address = str_replace(' ', '+', $gmapAddress); 
		 
		// Get geo data from Google Maps API by address 
		$geocodeFromAddr = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$formatted_address}&key={$GOOGLE_API_KEY}"); 

		// Decode JSON data returned by API 
		$apiResponse = json_decode($geocodeFromAddr); 
		 
		// Retrieve latitude and longitude from API data 
		$latitude  = $apiResponse->results[0]->geometry->location->lat;  
		$longitude = $apiResponse->results[0]->geometry->location->lng; 

		/**********End Get lattitude and longitude*******/

		#-------------------------------# 
		//when create a user
		if ($this->input->post('hospital_id',true) == null) {
			$data['hospital'] = (object)$postData = [
				'hospital_id'      => $this->input->post('hospital_id',true),
				'name'    => $this->input->post('name',true),
				'license_no' 	   => $this->input->post('license_no',true),
				'mobile' 	   => $this->input->post('mobile',true),
				'year_of_commencement' => $this->input->post('year_of_commencement',true),
				'hospital_ownership' 	   => $this->input->post('hospital_ownership',true),
				'services_type' 	   => $this->input->post('services_type',true),
				'no_of_ambulance' 	   => $this->input->post('no_of_ambulance',true),
				'organs_operated' 	   => !empty($this->input->post('organs_operated',true)) ? implode(',',$this->input->post('organs_operated',true)) : '',
				//'speciality_operations' 	   => !empty($this->input->post('speciality_operations',true)) ? implode(',',$this->input->post('speciality_operations',true)) : '',
				'bed_type' 	   => !empty($this->input->post('bed_type',true)) ? implode(',',$this->input->post('bed_type',true)) : '',
				'parking_area' 	   => $this->input->post('parking_area',true),
				'waiting_hall' 	   => $this->input->post('waiting_hall',true),
				'labs' 	   => $this->input->post('labs',true),
				'pharmacy' 	   => $this->input->post('pharmacy',true),
				'premises_area' 	   => $this->input->post('premises_area',true),
				'emergency_service' 	   => $this->input->post('emergency_service',true),
				'address' 	   => $this->input->post('address',true),
				'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture', true)),
				'address2' 	   => $this->input->post('address2',true),
				'state' 	   => $this->input->post('state',true),
				'city' 	   => $this->input->post('city',true),
				'zip' 	   => $this->input->post('zip',true),
				'manual' 	   => $this->input->post('manual',true),
				'semi_electric' 	   => $this->input->post('semi_electric',true),
				'fully_electric' 	   => $this->input->post('fully_electric',true),
				'hospital_images'      => (!empty($hospital_images) ? implode(',',$hospital_images) : $this->input->post('old_hospital_images', true)),
				'email' 	   => $this->input->post('email',true),
				'password' 	   => md5($passwordText),
				'user_role'    => 2,
				'created_by'   => $this->session->userdata('user_id'),
				'updated_by'   => $this->session->userdata('user_id'),
				'create_date'  => date('Y-m-d'),
				'update_date'  => date('Y-m-d'),
				'user_id'      => $this->input->post('user_id',true),
				'latitude'      => (!empty($latitude)?$latitude:''),
				'longitude'      => (!empty($longitude)?$longitude:''),
				'start_time'   => $this->input->post('start_time',true),
            	'end_time'   => $this->input->post('end_time',true),
            	'pm_jay'   => $this->input->post('pm_jay',true),
			]; 
		} else { //update a user
			$data['hospital'] = (object)$postData = [
				'hospital_id'      => $this->input->post('hospital_id',true),
				'name'    => $this->input->post('name',true),
				'license_no' 	   => $this->input->post('license_no',true),
				'mobile' 	   => $this->input->post('mobile',true),
				'year_of_commencement' => $this->input->post('year_of_commencement',true),
				'year_of_commencement' => $this->input->post('year_of_commencement',true),
				'hospital_ownership' 	   => $this->input->post('hospital_ownership',true),
				'services_type' 	   => $this->input->post('services_type',true),
				'no_of_ambulance' 	   => $this->input->post('no_of_ambulance',true),
				'organs_operated' 	   => !empty($this->input->post('organs_operated',true)) ? implode(',',$this->input->post('organs_operated',true)) : '',
				//'speciality_operations' 	   => !empty($this->input->post('speciality_operations',true)) ? implode(',',$this->input->post('speciality_operations',true)) : '',
				'bed_type' 	   => !empty($this->input->post('bed_type',true)) ? implode(',',$this->input->post('bed_type',true)) : '',
				'parking_area' 	   => $this->input->post('parking_area',true),
				'waiting_hall' 	   => $this->input->post('waiting_hall',true),
				'labs' 	   => $this->input->post('labs',true),
				'pharmacy' 	   => $this->input->post('pharmacy',true),
				'premises_area' 	   => $this->input->post('premises_area',true),
				'emergency_service' 	   => $this->input->post('emergency_service',true),
				'address' 	   => $this->input->post('address',true),
				'picture'      => (!empty($picture)?$picture:$this->input->post('old_picture', true)),
				'address2' 	   => $this->input->post('address2',true),
				'state' 	   => $this->input->post('state',true),
				'city' 	   => $this->input->post('city',true),
				'zip' 	   => $this->input->post('zip',true),
				'manual' 	   => $this->input->post('manual',true),
				'semi_electric' 	   => $this->input->post('semi_electric',true),
				'fully_electric' 	   => $this->input->post('fully_electric',true),
				'hospital_images'      => (!empty($hospital_images) ? implode(',',$hospital_images) : $this->input->post('old_hospital_images', true)),
				'email' 	   => $this->input->post('email',true),
				'updated_by'   => $this->session->userdata('user_id'),
				'update_date'  => date('Y-m-d'),
				'user_id'      => $this->input->post('user_id',true),
				'latitude'      => (!empty($latitude)?$latitude:''),
				'longitude'      => (!empty($longitude)?$longitude:''),
				'start_time'   => $this->input->post('start_time',true),
            	'end_time'   => $this->input->post('end_time',true),
            	'pm_jay'   => $this->input->post('pm_jay',true),
			];

			if(empty($this->input->post('organs_operated',true))) {
				$postData['disease_operated'] = '';
			}
		}
		
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $user_id then insert data
			if (empty($postData['hospital_id'])) {
				if ($this->hospital_model->create($postData)) {
					#set success message

					$user_data['name'] = $postData['name'];
					$user_data['email'] = $postData['email'];
					$user_data['password'] = $passwordText;
					$user_data['subject'] = "Welcome to IDHS - Access Your Hospital Panel";
					$user_data['mail_type'] = 'hospital_onboard';

					$mail_sent_status = $this->mail_model->send_mail($user_data);
					$this->session->set_flashdata('message', 'Hospital registration has been completed successfully and a mail has been sent to hospital with credentials.');
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}

				redirect('hospital');
			} else {
				if ($this->hospital_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', 'Hospital details have been updated successfully.');

					//update profile picture
					if ($postData['user_id'] == $this->session->userdata('user_id')) {

						if(empty($this->input->post('organs_operated',true))) {
							$this->session->set_userdata([
								'disease_operated' => ''
							]); 
						}

						$this->session->set_userdata([
							'picture' => (!empty($picture)?$picture:$this->input->post('old_picture', true)),
							'fullname' => $this->input->post('name',true),
							'organs_operated' => !empty($this->input->post('organs_operated',true)) ? implode(',',$this->input->post('organs_operated',true)) : ''
						]); 
					}
				} else {
					#set exception message
					$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
				}
				
				if($this->session->userdata('user_role') == 2) {
					redirect('hospital/profile');
				} else {
					$encr_hospital_id = $this->my_encrypt->encode($postData['hospital_id']);
					redirect('hospital/profile/'.$encr_hospital_id);
				}
			}

		} else {
			$data['organ_list'] = $this->organ_model->organ_list();
			$data['speciality_list'] = $this->speciality_model->speciality_list();
			$data['department_list'] = $this->department_model->department_list(); 
			$data['content'] = $this->load->view('hospital_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		} 
	}
 

	public function profile($hospital_id = null)
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}

		$hospital_id = $this->my_encrypt->decode($hospital_id);

		$data['title'] = 'Hospital Profile';
		#-------------------------------#
		$data['organ_list'] = $this->organ_model->organ_list();
		$data['speciality_list'] = $this->speciality_model->speciality_list();
		$data['hospital'] = $this->hospital_model->read_by_id($hospital_id);
		$data['content'] = $this->load->view('hospital_profile',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function edit($user_id = null) 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}
		//echo $user_id;exit;

		$user_id = $this->my_encrypt->decode($user_id);
		//echo $user_id;exit;

		$user_role = $this->session->userdata('user_role');
		if ($user_role == 1 && $this->session->userdata('user_id') == $user_id)
			$data['title'] = 'Edit Profile';  
		elseif ($user_role == 2)
			$data['title'] = 'Edit Profile';  
		else
			$data['title'] = 'Edit Profile';  
		#-------------------------------#
		$data['department_list'] = $this->department_model->department_list(); 
		$data['hospital'] = $this->hospital_model->read_by_id($user_id);
		#-------------------------------#
		//if (($data['doctor']->user_id != $this->session->userdata('user_id'))
		//&& $this->session->userdata('user_role') != 1)
		//	redirect('login');
		#-------------------------------#
		$data['organ_list'] = $this->organ_model->organ_list();
		$data['speciality_list'] = $this->speciality_model->speciality_list();
		$data['content'] = $this->load->view('hospital_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}
 

	public function delete($user_id = null) 
	{

		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		} elseif ($this->session->userdata('user_role') == 2) {
			redirect('doctor');
		}

		$user_id = $this->my_encrypt->decode($user_id);

		if ($this->hospital_model->delete($user_id)) {
			#set success message
			$this->session->set_flashdata('message', 'The Hospital has been deleted successfully.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('hospital');
	}

	public function approve($user_id = null) 
	{
		if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		} elseif ($this->session->userdata('user_role') == 2) {
			redirect('doctor');
		}

		$user_id = $this->my_encrypt->decode($user_id);
		
		$user_data = $this->hospital_model->read_by_user_id($user_id);
		$passwordText = $this->getRandomString();
		$password = md5($passwordText);
		$user_data['password'] = $passwordText;
		$user_data['subject'] = "Welcome to IDHS - Access Your Hospital Panel";
		$user_data['mail_type'] = 'hospital_onboard';

		if ($this->hospital_model->approve($user_id, $password)) {
			#set success message

			$mail_sent_status = $this->mail_model->send_mail($user_data);
			$this->session->set_flashdata('message', 'Hospital has been approved successfully and a mail has been sent to hospital with credentials.');
		} else {
			#set exception message
			$this->session->set_flashdata('exception', 'Something went wrong! Please try again.');
		}
		redirect('hospital');
	}

	public function update_disease_operated()
    {
    	if ($this->session->userdata('isLogIn') == false) {
			redirect('admin/login');
		}

        $user_id = $this->input->post('user_id', true);
        $user_id = $this->my_encrypt->decode($user_id);

        $disease_operated = $this->input->post('disease_operated', true);

        $data = array();
        if (!empty($user_id) && !empty($disease_operated)) {
            $postData = array();
            $postData['user_id'] = $user_id;
            $postData['disease_operated'] = implode(',',$disease_operated);
            if ($this->hospital_model->update_hospital($postData)) {
            	$this->session->set_userdata([
					'disease_operated'   => $postData['disease_operated']
				]); 
				$data['status'] = true;
			} else {
				$data['status'] = false;
			}
        } else {
            $data['status']  = false;
        }

        echo json_encode($data);
    }

    public function update_hospital_avaibility()
    {
    	if ($this->session->userdata('isLogIn') == false) {
			redirect('hospital/login');
		}

        $user_id = $this->input->post('hospital_id', true);
        $user_id = $this->my_encrypt->decode($user_id);

        $hospital_avaiability = $this->input->post('hospital_avaiability', true);

        $data = array();
        if (!empty($user_id) && !empty($hospital_avaiability)) {
            $postData = array();
            $postData['user_id'] = $user_id;
            $postData['hospital_avaiability'] = $hospital_avaiability;
            if ($this->hospital_model->update_hospital($postData)) {
            	$this->session->set_userdata([
					'hospital_avaiability'   => $hospital_avaiability
				]); 
				$data['status'] = true;
			} else {
				$data['status'] = false;
			}
        } else {
            $data['status']  = false;
        }

        echo json_encode($data);
    }

    public function getRandomString() {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	 
	    for ($i = 0; $i < 8; $i++) {
	        $index = rand(0, strlen($characters) - 1);
	        $randomString .= $characters[$index];
	    }
	 
	    return $randomString;
	}

}
