<?php
    class Posts extends Controller {

        public function __construct(){
            if(!isLoggedIn()){
                redirect('users/login');
            }
            $this->postModel = $this->model('Post');
            $this->userModel = $this->model('User');
        }

        public function index(){
            //Get posts 
            $posts = $this->postModel->getPosts();
            $data = [
                'posts' => $posts
            ]; 
            
            $this->view('posts/index', $data);
        } 

        public function add(){
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate data
                if(empty($data['title'])){
                    $data['title_err'] = 'O campo titulo não pode ser vazio!';
                }

                if(empty($data['body'])){
                    $data['body_err'] = 'O campo texto não pode ser vazio!';
                }

                // Make sure no erros 
                if(empty($data['title_err']) && empty($data['body_err'])){
                    // Validated
                    if($this->postModel->addPost($data)){
                        flash('post_message', 'Post adicionado');
                        redirect('posts');
                    } else {
                        die('Opss! Algo deu errado :(');
                    }
                } else {
                    //Load view with erros 
                    $this->view('posts/add', $data);
                }

            } else {
                $data = [
                    'title' => '',
                    'body' => '',
                ];
    
            }
           
            $this->view('posts/add', $data);
        }

        public function edit($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'id' => $id,
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate data
                if(empty($data['title'])){
                    $data['title_err'] = 'O campo titulo não pode ser vazio!';
                }

                if(empty($data['body'])){
                    $data['body_err'] = 'O campo texto não pode ser vazio!';
                }

                // Make sure no erros 
                if(empty($data['title_err']) && empty($data['body_err'])){
                    // Validated
                    if($this->postModel->updatePost($data)){
                        flash('post_message', 'Post editado');
                        redirect('posts');
                    } else {
                        die('Opss! Algo deu errado :(');
                    }
                } else {
                    //Load view with erros 
                    $this->view('posts/edit', $data);
                }

            } else {
                // Get existing post from model
                $post = $this->postModel->getPostById($id);

                // Check for owner
                if($post->user_id != $_SESSION['user_id']){
                    redirect('posts');
                }
                $data = [
                    'id' => $id,
                    'title' => $post->title,
                    'body' => $post->body
                ];
    
            }
           
            $this->view('posts/edit', $data);
        }

        public function show($id){
            $post = $this->postModel->getPostById($id);         
            $user = $this->userModel->getUserById($post->user_id);

            $data = [
                'post' => $post,
                'user' => $user
            ];
            $this->view('posts/show', $data);
        }

        public function delete($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Get existing from model
                $post = $this->postModel->getPostById($id);   
                // Check for owner
                if($post->user_id != $_SESSION['user_id']){
                    redirect('posts');
                }

                if($this->postModel->deletePost($id)){
                    flash('post_message', 'Post apagado');
                    redirect('posts');
                }
            } else {
                die('Opss! Algo deu errado');
            }
        }
    }