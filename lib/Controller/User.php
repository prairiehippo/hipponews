<?php
namespace Controller;

class User extends Controller {

    protected $user_model;

    protected function _loadModels(){
        $this->user_model = new \Model\User();
    }

    public function create() {
        $error = null;
        $username = $this->request->get('username');
        $email = $this->request->get('email');
        $password = $this->request->get('password');
        $password_check = $this->request->get('password_check');

        // Do the create
        if($this->request->get('create', false)) {

            if(empty($username) || empty($email) ||
               empty($password) || empty($password_check) ) {
                $error = 'You did not fill in all required fields.';
            }

            if(is_null($error)) {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Your email address is invalid';
                }
            }

            if(is_null($error)) {
                if($password != $password_check) {
                    $error = "Your passwords didn't match.";
                }
            }

            if(is_null($error)) {
                if($this->user_model->checkUserNameExists($username)) {
                    $error = 'Your chosen username already exists. Please choose another.';
                }
            }

            if(is_null($error)) {
                $params = array(
                    $username,
                    $email,
                    md5($username . $email),
                );

                $this->user_model->create($params);
                $this->redirect('user/login');
                exit;
            }
        }

        // Show the create form
        $response = new \Response\HTTPResponse($this->config);
        $response->setView('user_create.phtml');
        $response->set('error', $error);
        echo $response->render();
    }

    public function account() {
        $error = null;

        if(!$this->session->isAuthenticated()) {
            $this->redirect('user/login');
            exit;
        }

        if($this->request->get('updatepw')){
            $password = $this->request->get('password');
            $password_check = $this->request->get('password_check');

            if(empty($password) || empty($password_check) ||
                $password != $password_check ) {
                $error = 'The password fields were blank or they did not match. Please try again.';
            }
            else {
                $this->user_model->updateUserPassword($this->session->username, $password);
                $error = 'Your password was changed.';
            }
        }

        $details = $this->user_model->getUser($this->session->username);

        $response = new \Response\HTTPResponse($this->config);
        $response->setView('user_account.phtml');
        $response->set('error', $error);
        $response->set('details', $details);
        echo $response->render();
    }

    public function login() {
        $error = null;

        if($this->session->isAuthenticated()){
            $this->redirect('/');
        }

        // Do the login
        if($this->request->get('login', false)) {
            $username = $this->request->get('user');
            $password = $this->request->get('password');
            $user_model = new \Model\User($this->config);
            if($user = $this->user_model->login($username, $password)){
               $this->session->regenerate();
               $this->session->username = $user['username'];
               $this->session->authenticate();
               $this->redirect('/');
               exit;
            }
            else {
                $error = 'Your username/password did not match.';
            }
        }

        $response = new \Response\HTTPResponse($this->config);
        $response->setView('user_login.phtml');
        $response->set('error', $error);
        echo $response->render();
    }

    public function logout() {
        // Log out, redirect
        $this->session->destroy();
        $this->redirect('/');
    }
}
