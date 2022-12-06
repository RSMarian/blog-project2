<?php

class Users extends CI_Controller {
    // metoda pentru register
    public function register() {
        $data['title'] = 'Sign Up';

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

        if($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('users/register', $data);
            $this->load->view('templates/footer');
        } else {
            // criptarea parolei
            $enc_password = md5($this->input->post('password'));

            $this->user_model->register($enc_password);

            // mesaj
            $this->session->set_flashdata('user_registered', 'You are now registered and can log in');

            redirect('posts');

        }
    }

    // metoda pentru login
    public function login() {
        $data['title'] = 'Sign In';

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('users/login', $data);
            $this->load->view('templates/footer');
        } else {
            // ia username-ul
            $username = $this->input->post('username');
            // ia & cripteaza parola
            $password = md5($this->input->post('password'));

            // logheaza userul
            $user_id = $this->user_model->login($username, $password);

            if($user_id){
                // creeaza sesiune
                $user_data = array(
                    'user_id' => $user_id,
                    'username' => $username,
                    'logged_in' => true
                );

                $this->session->set_userdata($user_data);
                

                // mesaj
                $this->session->set_flashdata('user_loggedin', 'You are now logged in');

                redirect('posts');
            } else {
                // mesaj
                $this->session->set_flashdata('login_failed', 'Login is invalid');

                redirect('users/login');
            }
        }
    }


    public function logout(){
        // unset datele userului
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        // mesaj
        $this->session->set_flashdata('user_loggedout', 'You are now logged out');

        redirect('users/login');
    }



    // verificare daca exista deja username-ul
    public function check_username_exists($username) {
        $this->form_validation->set_message('check_username_exists', 'That username is taken. Please choose a different one');

        if($this->user_model->check_username_exists($username)) {
            return true;
        } else {
            return false;
        }
    }

    // verificare daca exista deja email-ul
    public function check_email_exists($email){
        $this->form_validation->set_message('check_email_exists', 'That email is taken. Please choose a different one');

        if($this->user_model->check_email_exists($email)) {
            return true;
        } else {
            return false;
        }
    }


}