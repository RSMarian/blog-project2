<?php
    // controller pt adaugarea paginilor statice cu usurinta
    class Pages extends CI_Controller{

        // creez metoda/functie(?) view cu argumentul (variabila)page care are valoarea default 'home'
        public function view($page = 'home'){ 

            // daca nu(!) exista fisierul denumit (valoarea variabilei $page).php in interiorul APPPATH/views/pages/ (ex: C:/xampp/htdocs/blog_project2/application/views/pages/)

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
            // file_exists() -> metoda predefinita php
            // APPPATH -> constanta predefinita din codeigniter care contine locatia catre folderul aplicatiei(ex: C:/xampp/htdocs/blog_project2/application)

                // arata o eroare 404 (show_404() -> functie predefinita codeigniter)
                show_404();
            }

            // creez array-ul 'title' in variabila $data, cu valoarea variabilei $page, prima litera uppercase
            $data['title'] = ucfirst($page);
            // $data -> variabilele pe care vrem sa le pasam in view
            // ucfirst() -> functie predefinita php, converteste primul caracter dintr-un string in uppercase

            // afisez view-ul header.php din folderul templates
            $this->load->view('templates/header');

            // variabila page ia valoarea denumirii view-ului curent?
            $this->load->view('pages/'.$page, $data);

            // afisez view-ul footer.php din folderul templates
            $this->load->view('templates/footer');

            //* this->load->view se va uita tot timpul inauntrul folderului view;
            //****** DATELE PASATE INTR-UN VIEW TREBUIE SA FIE SUB FORMA DE ARRAY
        }
    }


///// 1. de unde isi ia $page valoarea?