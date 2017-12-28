<?php
    class Pages extends Controller {
        public function __construct(){
        } 

        public function index(){
            if(isLoggedIn()){
                redirect('posts');
            }

            $data = [
                'title' => 'SharePosts',
                'description' => 'Sistema minimalista de postagem utilizado '
            ];       

            $this->view('pages/index', $data);
        }

        public function about(){
            $data = [
                'title' => 'Sobre',
                'description' => 'Sistema minimalista de postagem utilizado '
            ];
            $this->view('pages/about', $data);
        }
    }