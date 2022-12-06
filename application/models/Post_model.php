<?php

class Post_model extends CI_Model{
    // creez o functie __construct (care se executa in fiecare obiect al clasei)
    public function __construct(){
        // incarc baza de date
        $this->load->database();
    }
    
    // creez metoda care ia valorile din tabelul "posts" pt a avea acces la ele in controller, unde valoarea variabilei $slug nu este setata(?) 
    public function get_posts($slug = FALSE, $limit = FALSE, $offset = FALSE){
        if($limit){
            $this->db->limit($limit, $offset);
        }
        // daca valoarea lui $slug nu este setata
        if($slug === FALSE){
            // ordonez posturile descrescator pt a fi sus ultimul adaugat
            $this->db->order_by('posts.id','DESC');

            $this->db->join('categories', 'categories.id = posts.category_id');
            // iau tabelul posts din db si il pun in variabila $querry
            $query = $this->db->get('posts');
            // returnez valoarea lui $querry ca array
            return $query->result_array();
            // result_array este folosit in general pentru loop-uri foreach
        }

        // daca valoarea este setata
        // iau tabelul posts din db, unde variabila $slug ia valorile din coloana 'slug' din tabel si le formatez ca array
        $query = $this->db->get_where('posts', array('slug' => $slug));
        // returnez primul rand(?) din array-ul asociat variabilei $query
        return $query->row_array();
    }
    
    // metoda pentru crearea posturilor
    public function create_post($post_image){
        // iau inputul 'title' din form(?)
        $slug = url_title($this->input->post('title'));

        // creez array-ul data si pasez valorile din form
        // adaug fieldul category_id pentru adaugarea in db
        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'body' => $this->input->post('body'),
            'category_id' => $this->input->post('category_id'),
            'user_id' => $this->session->userdata('user_id'),
            'post_image' => $post_image
        );

        // introduc valorile variabilei $data in db, in tabelul 'posts'
        return $this->db->insert('posts', $data);
    }

    // metoda pentru stergerea posturilor
    // pasam variabila $id
    public function delete_post($id){
        // pasam variabilei id-ul postului si stergem postul cu id-ul respectiv
        $this->db->where('id', $id);
        $this->db->delete('posts');
        return true;
    }
    
    // metoda pentru updatarea postului in database
    public function update_post(){
        // dam variabilei $slug valoarea titlului din form si o punem sub forma "url-friendly" (Nume titlu -> Nume-titlu)
        $slug = url_title($this->input->post('title'));

        // creez array-ul data si pasez valorile din form (title&body) + valoarea slug-ului (titlul "url friendly")
        // adaug fieldul category_id pentru adaugarea in db
        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'body' => $this->input->post('body'),
            'category_id' => $this->input->post('category_id')
        );

        // updatez tabelul 'posts' din db si pasez datele din form + id-ul postului
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('posts', $data);
    }

    // metoda pentru a lua categoriile din db
    public function get_categories(){
        // ordonare dupa nume
        $this->db->order_by('name');
        // iau tabelul 'categories' din db si pun valorile in $querry
        $query = $this->db->get('categories');
        // returnez valorile din $query sub forma de array
        return $query->result_array();
    }

    public function get_posts_by_category($category_id){
        $this->db->order_by('posts.id','DESC');

        $this->db->join('categories', 'categories.id = posts.category_id');

        $query = $this->db->get_where('posts', array('category_id' => $category_id));

        return $query->result_array();
    }
}