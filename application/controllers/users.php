<?php defined('SYSPATH') OR die('No direct access allowed.');

class Users_Controller extends Controller {

  public function __construct() {
    parent::__construct();
    $this->session  = Session::instance();
    $this->auth = new Auth();
  }

  public function login() {
    // If the user is already logged in, redirect them to the homepage
    if( $this->auth->logged_in() ) {
      url::redirect('/');
    }

    $view             = new View('users/login');

    $view->header     = new View('layout/header');
    $view->footer     = new View('layout/footer');
    $view->loginForm  = new View('users/elements/loginform');

    $view->header->pageTitle = "Login";
    $view->message = $this->session->get('message') ? $this->session->get_once('message') : false;

    $view->loginForm->errors = null;

    // setup and initialize your form field names
    $form = array(
      'login_username'    => '',
      'login_password'    => '',
      'login_rememberme'  => '',
    );

    //  copy the form as errors, so the errors will be stored with keys corresponding to the form field names
    $errors = $form;

    if( $_POST ) {
      // First, validate the login form
      $post = new Validation($_POST);

      $post->pre_filter('trim', TRUE);
      $post->add_rules('login_username', 'required');
      $post->add_rules('login_password', 'required');

      if( $post->validate() ) {

        $username = $this->input->post('login_username');
        $password = $this->input->post('login_password');
        $remember = $this->input->post('login_rememberme');

        $user = ORM::factory('user', $username);

        if ( !$user->loaded ) {

          $view->loginForm->login_username    = $username;
          $view->loginForm->login_rememberme  = $remember;

          $view->message_type = "error";
          $view->message      = "Please correct the errors below and try again" ;
          $post->add_error('login_username', 'not_found');

        } elseif ( $this->auth->login($username, $password, $remember) ) {

          $this->session->set_flash(array('message_type'=>'good', 'message'=>'Welcome back!'));
          url::redirect($this->session->get('requested_url'));

        }  else {

          $view->loginForm->login_username    = $username;
          $view->loginForm->login_rememberme  = $remember;

          $view->message_type = "error";
          $view->message      = "Please correct the errors below and try again" ;
          $post->add_error('login_password', 'incorrect_password');

        }

      } else {
        // repopulate the form fields
        $view->loginForm->login_username    = $this->input->post('login_username');
        $view->loginForm->login_rememberme  = $this->input->post('login_rememberme');

        // populate the error fields, if any
        $view->loginForm->errors  = arr::overwrite($errors, $post->errors('form_errors'));
        $view->message_type       = "error";
        $view->message            = "Please correct the errors below and try again.";
      }

      $view->loginForm->errors = arr::overwrite($errors, $post->errors('form_errors'));
    }

    $view->render(TRUE);
  }

  public function logout() {
    // If the user is not logged in, redirect them to the homepage
    if( !$this->auth->logged_in() ) {
      url::redirect('/');
    }

  }

  public function my_profile() {
    // If the user is not logged in, redirect them to the login page
    if( $this->auth->logged_in() ) {
      url::redirect('/users/login');
    }

  }

  public function register() {
    // If the user is already logged in, redirect them to the homepage
    if( $this->auth->logged_in() ) {
      url::redirect('/');
    }

    $view                 = new View('users/register');

    $view->header         = new View('layout/header');
    $view->footer         = new View('layout/footer');
    $view->registerform   = new View('users/elements/registerform');

    $view->header->pageTitle = "Register";
    $view->message = $this->session->get('message') ? $this->session->get_once('message') : false;

    $view->registerform->errors = null;

    // setup and initialize your form field names
    $form = array(
      'register_username'   => '',
      'register_email'      => '',
    );

    //  copy the form as errors, so the errors will be stored with keys corresponding to the form field names
    $errors = $form;

    if( $_POST ) {
      // First, validate the login form
      $post = new Validation($_POST);

      $post->pre_filter('trim', TRUE);
      $post->add_rules('register_username', 'required');
      $post->add_rules('register_email', 'required', 'email');
      $post->add_rules('register_password', 'required');
      $post->add_rules('register_confirm', 'required', 'matches[register_password]');

      if( $post->validate() ) {

        $user = ORM::factory('user', $this->input->post('register_username'));

        if ( $user->loaded ) {

          // The username is already taken
          $view->registerform->register_username = $this->input->post('register_username');
          $view->registerform->register_email    = $this->input->post('register_email');

          $view->message_type = "error";
          $view->message      = "Please correct the errors below and try again" ;
          $post->add_error('register_username', 'already_taken');

        } else {
          $user = ORM::factory('user');

          $username = $this->input->post('register_username');
          $email    = $this->input->post('register_email');
          $password = $this->input->post('register_password');

          $user->username = $username;
          $user->email    = $email;
          $user->password = $this->auth->hash_password($password);

          if( $user->add(ORM::factory('role', 'login')) AND $user->save() ) {

            $this->auth->login($username, $password);
            $this->session->set_flash(array('message_type'=>'good', 'message'=>'Welcome! Thanks for signing up :)'));
            url::redirect($this->session->get('requested_url'));

          } else {

            $view->registerform->register_username = $username;
            $view->registerform->register_email    = $email ;

            $view->message_type = "error";
            $view->message      = "Hmmm, something went wrong and we couldn't register you. Please try again.";

          }
        }

      } else {
        // repopulate the form fields
        $view->registerform->register_username    = $this->input->post('register_username');
        $view->registerform->register_rememberme  = $this->input->post('rregister_ememberme');

        // populate the error fields, if any
        $view->registerform->errors = arr::overwrite($errors, $post->errors('form_errors'));
        $view->message_type         = "error";
        $view->message              = "Please correct the errors below and try again.";
      }

      $view->registerform->errors = arr::overwrite($errors, $post->errors('form_errors'));
    }

    $view->render(TRUE);
  }

} // End Users Controller