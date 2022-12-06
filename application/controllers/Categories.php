<?php
    class Categories extends CI_Controller{

        public function index(){
            $data['title'] = 'Categories';

            $data['categories'] = $this->category_model->get_categories();

            $this->load->view('templates/header');
            $this->load->view('categories/index', $data);
            $this->load->view('templates/footer');
        }

        // metoda pentru crearea categoriilor
        public function create(){
            if(!$this->session->userdata('logged_in')) {
                redirect('users/login');
            }
            // titlul paginii
            $data['title'] = 'Create Category';

            // validare pt field-ul Name
            $this->form_validation->set_rules('name', 'Name', 'required');

            // daca validarea nu merge, arata aceeasi pagina (+ validarile)
            if($this->form_validation->run() === False){
                $this->load->view('templates/header');
                $this->load->view('categories/create', $data);
                $this->load->view('templates/footer');
            // daca validarea merge
            } else {
                // acceseaza metoda create_category din model
                $this->category_model->create_category();

                    // mesaj
                    $this->session->set_flashdata('category_created', 'Your category has been created');

                // redirect catre categorii
                redirect('categories');
            }
        }

        public function posts($id){
            $data['title'] = $this->category_model->get_category($id)->name;

            $data['posts'] = $this->post_model->get_posts_by_category($id);

            $this->load->view('templates/header');
            $this->load->view('posts/index', $data);
            $this->load->view('templates/footer');
        }


    }