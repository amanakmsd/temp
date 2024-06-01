<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'dashboard_model',
            'setting_model',
            'mail_model'
        )); 
    }
 
    public function index() {
        $redirection = $this->uri->segment(1);

        if(empty($redirection)) {
            redirect('hospital/login');
        }

        // redirect to dashboard home page
        if($this->session->userdata('isLogIn')) 
            $this->redirectTo($this->session->userdata('user_role'));

        $this->form_validation->set_rules('email', 'Email','required|max_length[50]|valid_email');
        $this->form_validation->set_rules('password', 'Password','required|max_length[32]|md5');
        
        #-------------------------------#
        $setting = $this->setting_model->read();
        $data['title']   = (!empty($setting->title)?$setting->title:null);
        $data['logo']    = (!empty($setting->logo)?$setting->logo:null); 
        $data['favicon'] = (!empty($setting->favicon)?$setting->favicon:null); 
        $data['footer_text'] = (!empty($setting->footer_text)?$setting->footer_text:null); 

        $data['user'] = (object)$postData = [
            'email'     => $this->input->post('email',true),
            'password'  => md5($this->input->post('password',true))
        ]; 
        #-------------------------------#
        if ($this->form_validation->run() === true) {
            //check user data
            $check_user = $this->dashboard_model->check_user($postData); 

            if ($postData['user_role'] == 10) {
                $check_user = $this->dashboard_model->check_patient($postData); 
            } else {
                $check_user = $this->dashboard_model->check_user($postData); 
            }

            if ($check_user->num_rows() === 1) {
                //retrive setting data and store to session

                if($check_user->row()->user_role == 2) {
                    $profile_picture = $check_user->row()->hospital_logo;
                    $profile_name = $check_user->row()->hospital_name;
                } else {
                    $profile_name = $check_user->row()->firstname.' '.$check_user->row()->lastname;
                }

                $this->session->set_userdata([
                    'isLogIn'   => true,
                    'user_id' => (($postData['user_role']==10)?$check_user->row()->id:$check_user->row()->user_id),
                    'patient_id' => (($postData['user_role']==10)?$check_user->row()->patient_id:null),
                    'email'     => $check_user->row()->email,
                    'fullname'  => $profile_name,
                    'user_role' => (($postData['user_role']==10)?10:$check_user->row()->user_role),
                    'picture'   => $profile_picture, 
                    'title'     => (!empty($setting->title)?$setting->title:null),
                    'address'   => (!empty($setting->description)?$setting->description:null),
                    'logo'      => (!empty($setting->logo)?$setting->logo:null),
                    'favicon'      => (!empty($setting->favicon)?$setting->favicon:null),
                    'footer_text' => (!empty($setting->footer_text)?$setting->footer_text:null),
                    'demoM'     => 2,
                    'user_permissions'     => $check_user->row()->user_permissions,
                    'created_by'     => $check_user->row()->created_by,
                    'relationship'     => $check_user->row()->relationship,
                    'organs_operated'     => $check_user->row()->organs_operated,
                    'disease_operated'     => $check_user->row()->disease_operated,
                    'hospital_avaiability'     => $check_user->row()->hospital_avaiability,
                    'created_by' => $check_user->row()->created_by

                ]);

                //redirect to dashboard home page
                $this->redirectTo($check_user->row()->user_role);

            } else {
                #set exception message
                $this->session->set_flashdata('exception', 'Incorrect Email/Password!');
                //redirect to login form
                redirect($redirection.'/login');
            }

        } else {
            $this->load->view('layout/login_wrapper',$data);
        } 
    }

    public function home(){    
        if ($this->session->userdata('isLogIn') == false ) {
            redirect('hospital/login');
        }

        $data['title'] = 'Home';  
        $data['content']  = $this->load->view('home',$data,true);
        $this->load->view('layout/main_wrapper',$data);
    }


    public function redirectTo($user_role = null)
    {
        //redirect to dashboard/home page
        switch ($user_role) {
            case 1:
                    redirect('hospital');
                break; 
            case 2:
                    redirect('dashboard/home');
                break;  
            case 3:
                    redirect('doctor');
                break; 
            case 4:
                    redirect('dashboard/profile');
                break;  
            case 5:
                    redirect('dashboard_nurse/home');
                break; 
            case 6:
                    redirect('dashboard_pharmacist/home');
                break;  
            case 7:
                    redirect('dashboard_receptionist/home');
                break;  
            case 8:
                    redirect('dashboard_representative/home');
                break;
            case 9:
                    redirect('dashboard_case_manager/home');
                break; 
            case 10:
                    redirect('dashboard_patient/home');
                break; 
            //if $user_role is not set 
            //then redirect to login
            default: 
                    redirect('login');
                break;
        }        
    } 

    public function profile()
    {  
        $data['title'] = 'My Profile';
        #------------------------------# 
        $user_id = $this->session->userdata('user_id');
        $data['user']    = $this->dashboard_model->profile($user_id);
        $data['content'] = $this->load->view('profile', $data, true);
        $this->load->view('layout/main_wrapper',$data);
    } 

    public function email_check($email, $user_id)
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

    #------------------------------
    # get language info
    #------------------------------
    public function getLanguage(){
        $setting_table = 'setting';
        $default_lang  = 'english';

         //set language  
        $data = $this->db->get($setting_table)->row();
        if (!empty($data->language)) {
            $language = $data->language; 
        } else {
            $language = $default_lang; 
        } 

        $result = $this->db->select('*')
              ->from('language')
              ->get()
              ->result(); 
        $list = array();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                if($language==$key){
                    $text = $value->$language;
                }
                $list[$value->phrase] = $value->$language;
            }
        }

        echo json_encode($list);
    }

    


    public function logout()
    {   
        $user_role = $this->session->userdata('user_role');
        $this->session->sess_destroy();

        if($user_role == 1) {
            redirect('admin/login');
        } else {
            redirect('hospital/login');
        }
    }

    

    public function signup()
    {
        $setting = $this->setting_model->read();
        $data['title']   = 'Signup';
        $data['logo']    = (!empty($setting->logo)?$setting->logo:null); 
        $data['favicon'] = (!empty($setting->favicon)?$setting->favicon:null); 
        $data['footer_text'] = (!empty($setting->footer_text)?$setting->footer_text:null); 

        #-------------------------------#
        $this->form_validation->set_rules('name', 'Hospital Name' ,'required|max_length[50]');
        $this->form_validation->set_rules('email', 'Email','required|max_length[50]|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('license_no', 'Licence Number','required|max_length[50]|is_unique[hospital.license_no]');

        //$this->form_validation->set_rules('registration_number', 'Registration Number','required|max_length[50]|is_unique[user.registration_number]');

        $this->form_validation->set_rules('hospital_ownership', 'Hospital Ownership','required|max_length[10]');
        $this->form_validation->set_rules('services_type', 'Services Type','required|max_length[50]');
        $this->form_validation->set_rules('pm_jay', 'PM-JAY' ,'required');
        $this->form_validation->set_rules('start_time', 'Hosptal Start Time' ,'required|max_length[10]');
        $this->form_validation->set_rules('end_time', 'Hospital End Time' ,'required|max_length[10]');
        $this->form_validation->set_rules('address', 'Building Name' ,'required|max_length[50]');
        $this->form_validation->set_rules('address2', 'Street Name' ,'required|max_length[50]');
        $this->form_validation->set_rules('city', 'City' ,'required|max_length[50]');
        $this->form_validation->set_rules('state', 'State' ,'required|max_length[50]');
        $this->form_validation->set_rules('zip', 'Pin Code' ,'required|max_length[7]');
        
        #-------------------------------#


        //Logo upload
        $picture = $this->fileupload->do_upload(
            'assets/images/hospital/',
            'picture'
        );
        //print '<pre>';print_r($picture);exit;
    
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
        
        $otpString = $this->getRandomDigit();

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

        $data['hospital'] = (object)$postData = [
            'name'    => $this->input->post('name',true),
            'license_no'       => $this->input->post('license_no',true),
            'mobile'       => $this->input->post('mobile',true),
            'hospital_ownership'       => $this->input->post('hospital_ownership',true),
            'services_type' => $this->input->post('services_type',true),
            'address'      => $this->input->post('address',true),
            'picture'      => (!empty($picture)?$picture:''),
            'address2'     => $this->input->post('address2',true),
            'state'        => $this->input->post('state',true),
            'city'     => $this->input->post('city',true),
            'zip'      => $this->input->post('zip',true),
            'email'        => $this->input->post('email',true),
            'password'     => md5('admin@123'),
            'user_role'    => 2,
            'create_date'  => date('Y-m-d'),
            'update_date'  => date('Y-m-d'),
            'status'       => 0,
            'signup_otp'   => $otpString,
            'latitude'      => (!empty($latitude)?$latitude:''),
            'longitude'      => (!empty($longitude)?$longitude:''),
            'start_time'   => $this->input->post('start_time',true),
            'end_time'   => $this->input->post('end_time',true),
            'pm_jay'   => $this->input->post('pm_jay',true),
        ];
        
        #-------------------------------#
        if ($this->form_validation->run() === true) {

            $user_id = $this->dashboard_model->insert_temp_hospital($postData);
            if ($user_id) {
                $redirectUrl = 'hospital/verify_otp/'.$this->my_encrypt->encode($user_id);
                //echo $redirectUrl;exit;

                $user_data['name'] = $postData['name'];
                $user_data['email'] = $postData['email'];
                $user_data['verifyUrl'] = $redirectUrl;
                $user_data['otp'] = $otpString;
                $user_data['subject'] = "Welcome to IDHS - Verify OTP";
                $user_data['mail_type'] = 'hospital_signup_verify';
                $mail_sent_status = $this->mail_model->send_mail($user_data);

                #set success message
                $this->session->set_flashdata('message', 'We have sent you a mail with OTP. Please verify that OTP.');
                
                redirect($redirectUrl);
            } else {
                #set exception message
                $this->session->set_flashdata('exception', 'Something went wrong! Please verify all the details and try again.');
                $this->load->view('layout/signup_wrapper',$data);
            }
        } else {
            #set exception message
            $this->load->view('layout/signup_wrapper',$data);
        } 
    }

    public function resetPassword(){
        if ($this->session->userdata('isLogIn') == false
            && $this->session->userdata('user_id') != '')
            redirect('hospital/login');  
        $data['title'] = 'Change Password';

        $this->form_validation->set_rules('password', 'Current Password','required|max_length[20]|min_length[6]');
        $this->form_validation->set_rules('new_password', 'New Password','required|max_length[20]|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm New Password','required|max_length[20]|min_length[6]');
        #-------------------------------#
        $data['user'] = (object)$postData = [
            'user_id'      => $this->input->post('user_id',true),
            'password'    => md5($this->input->post('new_password',true))
        ];
        #-------------------------------#
        if ($this->form_validation->run() === true) {

            $postData1 = [
                'email' => $this->session->userdata('email'),
                'password' => md5($this->input->post('password',true))
            ];

            $check_user = $this->dashboard_model->check_user($postData1);

            if ($check_user->num_rows() === 1) {

                if($this->input->post('new_password',true) === $this->input->post('confirm_password',true)) {
                    if ($this->dashboard_model->update($postData)) {
                        #set success message
                        $this->session->set_flashdata('message', 'Password has been updated successfully.');
                    } else {
                        #set exception message
                        $this->session->set_flashdata('exception', 'Something went wrong! Please try after sometime.');
                    }
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', 'New Password and Confirm New Password does not match. New Password and and Confirm New Password must be same.');
                }

            } else {
                #set exception message
                $this->session->set_flashdata('exception', 'Incorrect current password!');
            }

            redirect('dashboard/change-password');
        } else {
            $data['content'] = $this->load->view('reset_password',$data,true);
            $this->load->view('layout/main_wrapper',$data);
        } 
    }

    public function getRandomDigit() {
        $characters = '0123456789';
        $randomString = '';
     
        for ($i = 0; $i < 6; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
     
        return $randomString;
    }

    public function verify_otp($encrypt_user_id)
    {
        $setting = $this->setting_model->read();
        $data['title']   = 'Signup';
        $data['logo']    = (!empty($setting->logo)?$setting->logo:null); 
        $data['favicon'] = (!empty($setting->favicon)?$setting->favicon:null); 
        $data['footer_text'] = (!empty($setting->footer_text)?$setting->footer_text:null); 
        //echo $this->my_encrypt->encode(44);exit;
        //$encrypt_user_id = $_GET['user'];
        //echo $encrypt_user_id;exit;

        $user_id = $this->my_encrypt->decode($encrypt_user_id);

        #-------------------------------#

        if($user_id) {
            $this->form_validation->set_rules('signup_otp', 'OTP' ,'required|max_length[6]');
            

            $postData = [
                'user_id' => $user_id,
                'signup_otp' => $this->input->post('signup_otp',true)
            ];
            
            #-------------------------------#
            if ($this->form_validation->run() === true) {

                $check_user = $this->dashboard_model->verify_otp($postData);

                //print '<pre>';print_r($check_user);exit;

                if (!empty($check_user)) {

                    $updateData = [
                        'hospital_id' => $user_id,
                        'signup_otp' => null,
                        'status' => 2
                    ];

                    $this->dashboard_model->update_temp_hospital($updateData);

                    $cur_user_id = $this->dashboard_model->insert_hospital($check_user);

                    if($cur_user_id) {
                        $this->session->set_flashdata('message', 'Thanks for successfully registering on our portal, we will review your profile and get back to you.');
                        redirect('hospital/login');
                    } else {
                        #set exception message
                        $this->session->set_flashdata('exception', 'Something went wrong! Please try after sometime.');
                        $this->load->view('layout/verifyotp_wrapper',$data);
                    }
                    
                } else {
                    #set exception message
                    $this->session->set_flashdata('exception', 'Something went wrong! Please enter valid OTP.');
                    $this->load->view('layout/verifyotp_wrapper',$data);
                }
            } else {
                #set exception message
                $this->load->view('layout/verifyotp_wrapper',$data);
            }
        } else {
            $this->session->set_flashdata('exception', 'Something went wrong! Please try later.');
            $this->load->view('layout/verifyotp_wrapper',$data);
        }
    }
 
}
