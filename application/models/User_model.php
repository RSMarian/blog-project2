<?php

class User_model extends CI_Model {
    public function register($enc_password) {
        // array pt user data
        $data = array (
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => $enc_password,
            'zipcode' => $this->input->post('username'),
        );

        // insert user in db
        return $this->db->insert('users', $data);
    }

    public function login($username, $password) {
        // validare
        $this->db->where('username', $username);
        $this->db->where('password', $password);

        $result = $this->db->get('users');

        if($result->num_rows() == 1){
            return $result->row(0)->id;
        } else {
            return false;
        }
    }

    // verificare daca exista deja username-ul
    public function check_username_exists($username){
        $query = $this->db->get_where('users', array('username' => $username));
        if(empty($query->row_array())) {
            return true;
        } else {
            return false;
        }
    }

    // verificare daca exista deja email-ul
    public function check_email_exists($email){
        $query = $this->db->get_where('users', array('email' => $email));
        if(empty($query->row_array())) {
            return true;
        } else {
            return false;
        }
    }
}