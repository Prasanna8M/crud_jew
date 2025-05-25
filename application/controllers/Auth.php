<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function register() {
        // print_r($this->input->post());
        // exit;
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required');
            // $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if ($this->form_validation->run() == TRUE) {
                $data = [
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
                ];

                $this->Auth_model->insert_user($data);
                $this->session->set_flashdata('success', 'Registration successful. Please login.');
                redirect('auth/login');
            }
        }
        $this->load->view('auth/register');
    }

    public function login() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == TRUE) {
                $user = $this->Auth_model->get_user($this->input->post('email'));

                if ($user && password_verify($this->input->post('password'), $user->password)) {
                    $this->session->set_userdata(['user_id' => $user->id, 'user_name' => $user->name]);
                    redirect('auth/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Invalid credentials.');
                }
            }
        }
        $this->load->view('auth/login');
    }

    public function dashboard() {
        // if (!$this->session->userdata('user_id')) {
        //     redirect('auth/login');
        // }
        $this->load->view('dashboard');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

}
