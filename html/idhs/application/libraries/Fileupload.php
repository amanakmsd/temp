<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fileupload
{
  
    function do_upload($upload_path = null, $field_name = null) {
        if (empty($_FILES[$field_name]['name'])) {
            return null;
        } else {
            //-----------------------------
            $ci =& get_instance();
            $ci->load->helper('url');  

            //folder upload
            $file_path = $upload_path;
            if (!is_dir($file_path))
                mkdir($file_path, 0755,true);
            //ends of folder upload 

            //set config 
            $config = [
                'upload_path'   => $file_path,
                'allowed_types' => 'gif|jpg|png|jpeg|ico', 
                'overwrite'     => false,
                'maintain_ratio' => true,
                'encrypt_name'  => true,
                'remove_spaces' => true,
                'file_ext_tolower' => true 
            ]; 
            $ci->load->library('upload', $config);
            if($ci->security->xss_clean($field_name, TRUE)){
                if (!$ci->upload->do_upload($field_name)) {
                    return false;
                } else {
                    $file = $ci->upload->data();
                    return $file_path.$file['file_name'];
                }
            }else{
                return false;
            }
            
        }
    }   

    public function do_resize($file_path = null, $width = null, $height = null) {
        $ci =& get_instance();
        $ci->load->library('image_lib');
        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $file_path,
            'create_thumb'   => false,
            'maintain_ratio' => false,
            'width'          => $width,
            'height'         => $height,
        ]; 
        $ci->image_lib->initialize($config);
        $ci->image_lib->resize();
    }

    function do_multiple_upload($upload_path = null, $field_name = null) {
        $data = array();
        if(!empty($_FILES[$field_name]['name']) && count(array_filter($_FILES[$field_name]['name'])) > 0) {

            $ci =& get_instance();
            $ci->load->helper('url');  

            //folder upload
            $file_path = $upload_path;
            if (!is_dir($file_path))
                mkdir($file_path, 0755,true);
            //ends of folder upload 

            $filesCount = count($_FILES[$field_name]['name']); 
            for($i = 0; $i < $filesCount; $i++){ 
                $_FILES['file']['name']     = $_FILES[$field_name]['name'][$i]; 
                $_FILES['file']['type']     = $_FILES[$field_name]['type'][$i]; 
                $_FILES['file']['tmp_name'] = $_FILES[$field_name]['tmp_name'][$i]; 
                $_FILES['file']['error']     = $_FILES[$field_name]['error'][$i]; 
                $_FILES['file']['size']     = $_FILES[$field_name]['size'][$i]; 
                 
                // File upload configuration 
                $config['upload_path'] = $file_path; 
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                //$config['max_size']    = '100'; 
                //$config['max_width'] = '1024'; 
                //$config['max_height'] = '768'; 
                 
                // Load and initialize upload library 
                $ci->load->library('upload', $config); 
                //$ci->upload->initialize($config); 
                 
                // Upload file to server 
                if($ci->upload->do_upload('file')){ 
                    // Uploaded file data 
                    $fileData = $ci->upload->data(); 
                    $filename = $fileData['file_name']; 
                    
                    // Initialize array
                    $data[] = $file_path.$filename; 
                } 
            }
        }
        return $data;
    }
}

