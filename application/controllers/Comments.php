<?php

// controller pentru comentarii
class Comments extends CI_Controller {
    // metoda pentru crearea comentariilor
    // pasam $post_id pt a-l putea folosi
    public function create($post_id) {
        // dam valoarea slug-ului postului variabilei $slug
        $slug = $this->input->post('slug');
        // 
        $data['post'] = $this->post_model->get_posts($slug);

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');

        if($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('posts/view', $data);
            $this->load->view('templates/footer');
        } else {
            $this->comment_model->create_comment($post_id);
            redirect('posts/'.$slug);
        }
    }
}