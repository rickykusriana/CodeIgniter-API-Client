<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MX_Controller {

    var $api = '';

    function __construct()
    {
        parent::__construct();
        $this->api = 'http://localhost/test-babastudio-server/api';
    }

    public function index()
    {
        $data['get_profile'] = json_decode($this->curl->simple_get($this->api.'/profile'));
        $this->load->view('table', $data);
    }

    public function create()
    {
        if ($this->input->post()) {

            if ( ! empty($_FILES['image']['name'])) {
                
                $file = $this->upload();

                if ($file['status'] == 'error') {
                    $this->session->set_flashdata('alert', $file['data']);
                    redirect('profile');
                }
                else {
                    $data = array(
                        'name'      =>  $this->input->post('name'),
                        'address'   =>  $this->input->post('address'),
                        'email'     =>  $this->input->post('email'),
                        'phone'     =>  $this->input->post('phone'),
                        'image'     =>  $file['data']['file_name']
                    );

                    $insert =  $this->curl->simple_post($this->api.'/profile', $data, array(CURLOPT_BUFFERSIZE => 10)); 
            
                    if ($insert) {
                        $this->session->set_flashdata('alert', 'Saved');
                    }
                    else {
                        $this->session->set_flashdata('alert', 'Failed');
                    }

                    redirect('profile');
                }
            }
        }
        else {
            $data['button'] = 'Simpan';
            $data['action'] = site_url(uri_string());
            $this->load->view('form', $data);
        }
    }

    public function update($id)
    {
        if ($this->input->post()) {

            $data = array(
                        'name'      =>  $this->input->post('name'),
                        'address'   =>  $this->input->post('address'),
                        'email'     =>  $this->input->post('email'),
                        'phone'     =>  $this->input->post('phone'));

            if ( ! empty($_FILES['image']['name'])) {
                
                $file = $this->upload();

                if ($file['status'] == 'error') {
                    $this->session->set_flashdata('alert', $file['data']);
                    redirect('profile');
                }
                else {
                    
                    // Remove existing file
                    $check = json_decode($this->curl->simple_get($this->api.'/profile/'.$id));
                    @unlink('./upload/'.$check[0]->image);

                    $data['image'] = $file['data']['file_name'];
                }
            }

            $update = $this->curl->simple_put($this->api.'/profile/'.$id, $data, array(CURLOPT_BUFFERSIZE => 10)); 
            
            if ($update) {
                $this->session->set_flashdata('alert', 'Updated');
            }
            else {
                $this->session->set_flashdata('alert', 'Failed');
            }

            redirect('profile');
        }
        else {
            $data['button'] = 'Update';
            $data['query']  = json_decode($this->curl->simple_get($this->api.'/profile/'.$id));
            $data['action'] = site_url(uri_string());
            $this->load->view('form', $data);
        }
    }

    public function delete($id)
    {
        if (empty($id)) {
            $this->session->set_flashdata('alert', 'Data not found');
            redirect('profile');
        }
        else {

            // Remove existing file
            $check = json_decode($this->curl->simple_get($this->api.'/profile/'.$id));
            @unlink('./upload/'.$check[0]->image);

            $delete = $this->curl->simple_delete($this->api.'/profile/'.$id, array(CURLOPT_BUFFERSIZE => 10));
            $this->session->set_flashdata('alert', 'Deleted');
            redirect('profile');
        }
    }

    public function upload()
    {
        $config['upload_path']      = './upload/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['encrypt_name']     = TRUE;
        $config['overwrite']        = FALSE;
        $config['max_size']         = 30000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('image')) {
            return array(
                        'status' => 'error',
                        'data'   => $this->upload->display_errors());
        }
        else {
            return array(
                        'status' => 'success',
                        'data'   => $this->upload->data());
        }
    }

}
