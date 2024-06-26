<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array(
            'dashboard_model',
            'setting_model'
        )); 
    }
 
    public function index() {
        $redirection = $this->uri->segment(1);

        if(empty($redirection)) {
            redirect('admin/login');
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
        $this->form_validation->set_rules('license_no', 'Licence Number','required|max_length[50]');
        $this->form_validation->set_rules('hospital_ownership', 'Hospital Ownership','required|max_length[10]');
        $this->form_validation->set_rules('services_type', 'Services Type','required|max_length[50]');
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
            'status'        => 2
        ];
        
        #-------------------------------#
        if ($this->form_validation->run() === true) {

            if ($this->dashboard_model->insert_hospital($postData)) {
                #set success message
                $this->session->set_flashdata('message', 'Thanks for successfully registering on our portal, we will review your profile and get back to you.');
                redirect('hospital/signup');
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
 
}
