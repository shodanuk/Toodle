<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Users controller
 *
 * @package     Toodle
 * @author      Terry Morgan <terry.morgan@marmaladeontoast.co.uk>
 * @copyright   (c) 2011 Terry Morgan
 */
class Users_Controller extends Controller {

  public function __construct()
  {
    parent::__construct();
    $this->session  = Session::instance();
    $this->auth = new Auth;
  }

  public function login() {
    // If the user is already logged in, redirect them to the homepage
    if( $this->auth->logged_in() || $this->auth->auto_login() === TRUE)
    {
      url::redirect('/');
    }

    $view               = new View('users/login');

    $view->header       = new View('layout/header');
    $view->footer       = new View('layout/footer');
    $view->login_form   = new View('users/elements/loginform');

    $view->header->page_title   = 'Login';
    $view->header->is_logged_in = false;
    $view->header->body_class   = 'login';

    $view->message = $this->session->get('message') ? $this->session->get_once('message') : false;

    $view->login_form->errors = null;

    // Setup and initialize your form field names
    $form = array(
      'login_username'    => '',
      'login_password'    => '',
      'login_rememberme'  => '',
    );

    //  Copy the form as errors, so the errors will be stored with keys corresponding to the form field names
    $errors = $form;

    if ($_POST)
    {
      // First, validate the login form
      $post = new Validation($_POST);

      $post->pre_filter('trim', TRUE);
      $post->add_rules('login_username', 'required');
      $post->add_rules('login_password', 'required');

      if ($post->validate())
      {

        $username = $this->input->post('login_username');
        $password = $this->input->post('login_password');
        $remember = $this->input->post('login_rememberme');

        $user = ORM::factory('user', $username);

        if ( ! $user->loaded)
        {
          $view->login_form->login_username    = $username;
          $view->login_form->login_rememberme  = $remember;

          $view->message_type = 'error';
          $view->message      = 'Please correct the errors below and try again' ;
          $post->add_error('login_username', 'not_found');
        }
        elseif ($this->auth->login($username, $password, ($remember ? TRUE : FALSE)))
        {
          $this->session->set_flash(array('message_type'=>'good', 'message'=>'Welcome back!'));
          url::redirect($this->session->get('requested_url'));
        }
        else
        {
          $view->login_form->login_username    = $username;
          $view->login_form->login_rememberme  = $remember;

          $view->message_type = 'error';
          $view->message      = 'Please correct the errors below and try again' ;
          $post->add_error('login_password', 'incorrect_password');
        }
      }
      else
      {
        // Repopulate the form fields
        $view->loginForm->login_username    = $this->input->post('login_username');
        $view->loginForm->login_rememberme  = $this->input->post('login_rememberme');

        // Populate the error fields, if any
        $view->loginForm->errors  = arr::overwrite($errors, $post->errors('form_errors'));
        $view->message_type       = 'error';
        $view->message            = 'Please correct the errors below and try again.';
      }

      $view->loginForm->errors = arr::overwrite($errors, $post->errors('form_errors'));
    }

    $view->render(TRUE);
  }

  public function logout()
  {
    // If the user is not logged in, redirect them to the homepage
    if ( ! $this->auth->logged_in())
    {
      url::redirect('/');
    }

    $this->auth->logout();
    url::redirect('/users/login');
  }

  public function my_profile()
  {
    // If the user is not logged in, redirect them to the login page
    if ( ! $this->auth->logged_in())
    {
      url::redirect('/users/login');
    }

    $view               = new View('users/my_profile');
    $view->header       = new View('layout/header');
    $view->footer       = new View('layout/footer');
    $view->profile_form = new View('users/elements/register_form');

    $logged_in_user = $this->auth->get_user();

    $view->header->page_title   = 'My Profile';
    $view->header->is_logged_in = true;
    $view->header->username     = $logged_in_user->username;
    $view->header->body_class   = "my_profile";

    $view->message = $this->session->get('message') ? $this->session->get_once('message') : false;

    $view->profile_form->action            = 'my_profile';
    $view->profile_form->errors            = null;
    $view->profile_form->register_username = $logged_in_user->username;
    $view->profile_form->register_email    = $logged_in_user->email;

    // Setup and initialize your form field names
    $form = array(
      'register_username' => '',
      'register_email'    => '',
    );

    // Copy the form as errors, so the errors will be stored with keys corresponding to the form field names
    $errors = $form;

    if ($_POST)
    {
      // First, validate the login form
      $post = new Validation($_POST);

      $post->pre_filter('trim', TRUE);
      $post->add_rules('register_username', 'required');
      $post->add_rules('register_email', 'required', 'email');

      if ($post->validate())
      {
        $username = $this->input->post('register_username');
        $email    = $this->input->post('register_email');

        $user->username = $username;
        $user->email    = $email;
        $user->save();

        if ($user->saved)
        {
          $view->message_type = 'good';
          $view->message      = 'Profile saved.';
        }
        else
        {
          $view->profile_form->register_username = $username;
          $view->profile_form->register_email    = $email ;

          $view->message_type = 'error';
          $view->message      = 'Hmmm, something went wrong and we couldn\'t register you. Please try again.';
        }
      }
      else
      {
        // Repopulate the form fields
        $view->profile_form->register_username = $this->input->post('register_username');
        $view->profile_form->register_email    = $this->input->post('register_rememberme');

        // Populate the error fields, if any
        $view->profile_form->errors = arr::overwrite($errors, $post->errors('form_errors'));
        $view->message_type         = 'error';
        $view->message              = 'Please correct the errors below and try again.';
      }

      $view->profile_form->errors = arr::overwrite($errors, $post->errors('form_errors'));
    }

    $view->render(TRUE);
  }

  public function register()
  {
    // If the user is already logged in, redirect them to the homepage
    if ($this->auth->logged_in())
    {
      url::redirect('/');
    }

    $view                 = new View('users/register');

    $view->header         = new View('layout/header');
    $view->footer         = new View('layout/footer');
    $view->register_form   = new View('users/elements/register_form');

    $view->header->page_title     = "Register";
    $view->header->is_logged_in   = false;
    $view->header->body_class     = "register";

    $view->message = $this->session->get('message') ? $this->session->get_once('message') : false;

    $view->register_form->action = 'register';
    $view->register_form->errors = null;

    // Setup and initialize your form field names
    $form = array(
      'register_username' => '',
      'register_email'    => '',
      'register_password' => '',
      'register_confirm'  => '',
    );

    //  Copy the form as errors, so the errors will be stored with keys corresponding to the form field names
    $errors = $form;

    if ($_POST)
    {
      // First, validate the login form
      $post = new Validation($_POST);

      $post->pre_filter('trim', TRUE);
      $post->add_rules('register_username', 'required');
      $post->add_rules('register_email', 'required', 'email');
      $post->add_rules('register_password', 'required');
      $post->add_rules('register_confirm', 'required', 'matches[register_password]');

      if ($post->validate())
      {
        $user = ORM::factory('user', $this->input->post('register_username'));

        if ($user->loaded)
        {
          // The username is already taken
          $view->register_form->register_username = $this->input->post('register_username');
          $view->register_form->register_email    = $this->input->post('register_email');

          $view->message_type = "error";
          $view->message      = "Please correct the errors below and try again" ;
          $post->add_error('register_username', 'already_taken');
        }
        else
        {
          $username = $this->input->post('register_username');
          $email    = $this->input->post('register_email');
          $password = $this->input->post('register_password');

          $user = ORM::factory('user');
          $user->username = $username;
          $user->email    = $email;
          $user->password = $password;

          if ($user->add(ORM::factory('role', 'login')) AND $user->save())
          {
            if ($this->auth->login($username, $password))
            {
              $this->session->set_flash(array('message_type'=>'good', 'message'=>'Welcome! Thanks for signing up :)'));
              url::redirect($this->session->get('requested_url'));
            }
            else
            {
              $this->session->set_flash(array('message_type'=>'error', 'message'=>'Can\'t log you in. Sorry :('));
              url::redirect('/users/login');
            }
          }
          else
          {
            $view->register_form->register_username = $username;
            $view->register_form->register_email    = $email ;

            $view->message_type = "error";
            $view->message      = "Hmmm, something went wrong and we couldn't register you. Please try again.";
          }
        }
      }
      else
      {
        // Repopulate the form fields
        $view->register_form->register_username    = $this->input->post('register_username');
        $view->register_form->register_rememberme  = $this->input->post('register_rememberme');

        // Populate the error fields, if any
        $view->register_form->errors  = arr::overwrite($errors, $post->errors('form_errors'));
        $view->message_type           = "error";
        $view->message                = "Please correct the errors below and try again.";
      }

      $view->register_form->errors = arr::overwrite($errors, $post->errors('form_errors'));
    }
    $view->render(TRUE);
  }
} // End Users Controller