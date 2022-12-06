<?php
    // controller pentru posts
    class Posts extends CI_Controller{

        // metoda default pentru controllerul "Posts"
        public function index($offset = 0){
            // config pagination
            $config ['base_url'] = base_url() . 'posts/index/';
            $config['total_rows'] = $this->db->count_all('posts');
            $config['per_page'] = 3;
            $config['uri_segment'] = 3;

            // init pagination
            $this->pagination->initialize($config);

            // creez array-ul 'title' inauntrul variabilei data si ii dau valoarea 'Latest Posts'
            $data['title'] = 'Latest Posts';

            // creez array-ul 'posts' inauntrul variabilei data si ii pasez metoda get_posts(), pentru a avea acces la $posts in view-uri
            $data['posts'] = $this->post_model->get_posts(FALSE, $config['per_page'], $offset);
            //print_r($data['posts']); <-- verific continutul array-ului post din variabila $data


            $this->load->view('templates/header');
            $this->load->view('posts/index', $data);
            $this->load->view('templates/footer');
        }

        // metoda pentru afisarea unui singur post
        // setam variabila $slug ca fiind null(?)
        public function view($slug = null){
            // creez array-ul 'post' inauntrul variabilei $data si ii dauvaloareavariabilei$slug(?) din metoda get_posts
            $data['post'] = $this->post_model->get_posts($slug);
            $post_id = $data['post']['id'];
            $data['comments'] = $this->comment_model->get_comments($post_id);
            // daca array-ul post din variabila $data este gol
            if(empty($data['post'])){
                // arata eroare 404
                show_404();
            }

            // creez array-ul 'title' in variabila $data si ii pasez valorile din key-ul(?) 'title' din array-ul 'post'; ($data['post'] acceseaza metoda din model care ia valorile din tabelul 'posts' din db si le formateaza ca array)
            $data['title'] = $data['post']['title'];
            // facem asta pt a introduce dinamic in view numele din db fiecarui titlu de post in parte
            // print_r($data['title']);

            
            $this->load->view('templates/header');
            // incarc view-ul "view" din folderul posts si pasez $data pentru a putea folosi valorile variabilelor inauntrul view-ului
            $this->load->view('posts/view', $data);
            $this->load->view('templates/footer');
        }
        // metoda pentru crearea post-urilor 
        public function create(){
            // login check
            if(!$this->session->userdata('logged_in')) {
                redirect('users/login');
            }
            // creez array-ul 'title' in variabila $data si ii dau valoarea 'Create Post' pentru folosi $title in view dupa ce pasam $data in incarcarea view-ului
            $data['title'] = 'Create Post';
            
            // array 'categories', care ia valorile array-ului din metoda get_categories
            // pt ca pasam $data in view, o sa avem acces la $categories in view-ul in care pasam 
            $data['categories'] = $this->post_model->get_categories();

            // reguli de validare pentru form-ul de creare a posturilor
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('body', 'Body', 'required');

            // daca nu se valideaza
            if($this->form_validation->run() === FALSE){
                // afisez view-ul create
                $this->load->view('templates/header');
                $this->load->view('posts/create', $data);
                $this->load->view('templates/footer');
            // altfel (daca se valideaza)
            }else {
                // configuratii pt img upload (create&edit)
                $config['upload_path'] = './assets/images/posts';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['max_width'] = '2000';
                $config['max_height'] = '2000';

                $this->load->library('upload', $config);

                if(!$this->upload->do_upload()){
                    $errors = array('error' => $this->upload->display_errors());
                    $post_image = 'noimage.jpg';
                }else{
                    $data = array('upload_data' => $this->upload->data());
                    $post_image = $_FILES['userfile']['name'];
                }

                // acceez metoda create_post din post_model
                $this->post_model->create_post($post_image);
                
                            // mesaj
            $this->session->set_flashdata('post_created', 'Your post has been successfully created');
                // redirectionare catre view-ul default din controllerul posts (care afiseaza toate posturile)
                redirect('posts');
            }
        }
        
        // metoda pentru stergerea posturilor
        public function delete($id){
            if(!$this->session->userdata('logged_in')) {
                redirect('users/login');
            }
            // accesez metoda delete_post din model, unde pasez id-ul postului
            $this->post_model->delete_post($id);
            // redirectionare catre posturi
            
            $this->session->set_flashdata('post_deleted', 'Your post has been deleted');

            redirect('posts');
        }

        // metoda pentru editarea posturilor 
        public function edit($slug){
            if(!$this->session->userdata('logged_in')) {
                redirect('users/login');
            }
            // accesez metoda get_posts din model, unde pasez variabila $slug 
            $data['post'] = $this->post_model->get_posts($slug);

            // Check user
            if($this->session->userdata('user_id') != $this->post_model->get_posts($slug)['user_id']) {
                redirect('posts');
            }

            $data['categories'] = $this->post_model->get_categories();

            // daca nu exista nicio valoare in array-ul 'post'
            if(empty($data['post'])){
                // arata eroare 404
                show_404();
            }

            // titlul view-ului de edit
            $data['title'] = 'Edit Post';

            $this->load->view('templates/header');
            // incarc view-ul edit
            $this->load->view('posts/edit', $data);
            $this->load->view('templates/footer');
        }
        
        // metoda pentru update in db ale posturilor editate
        public function update(){
            if(!$this->session->userdata('logged_in')) {
                redirect('users/login');
            }
            // accesam metoda update_post din model
            $this->post_model->update_post();

                // alert
                $this->session->set_flashdata('post_updated', 'Your post has been updated');

            redirect('posts');
        }
    }

