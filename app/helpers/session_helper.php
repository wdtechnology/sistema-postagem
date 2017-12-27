<?php
    session_start();
    
    // File message helper 
    // Exemple - flash('register_success', 'Registre efetuado com sucesso!', 'alert alert-success');
    // Display - echo flash('register_success');
    function flash($name = '', $menssage = '', $class = 'alert alert-success')
    { 
        if(!empty($name)){
            if(!empty($menssage) && empty($_SESSION[$name])){
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }

                if(!empty($_SESSION[$name. '_class'])){
                    unset($_SESSION[$name. '_class']);
                }

                $_SESSION[$name] = $menssage;
                $_SESSION[$name. '_class'] = $class;
            } elseif(empty($menssage) && !empty($_SESSION[$name])){
                $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
                echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name. '_class']);
            }
        }
    }
    
    function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        } else {
            return false;
        }
    }       