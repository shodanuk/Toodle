<?php defined('SYSPATH') OR die('No direct access allowed.');

class Todos_Controller extends Controller {

  public function __construct() {
    parent::__construct();
    $this->session = Session::instance();

    $auth = new Auth();
    if (!$auth->logged_in()){
      $this->session->set("requested_url","/".url::current()); // this will redirect from the login page back to this page
      url::redirect('/users/login');
    }else{
      $this->user = $auth->get_user(); //now you have access to user information stored in the database
    }
  }

  public function index($id = false) {
    $view = new View('todos/index');

    $view->header = new View('layout/header');
    $view->footer = new View('layout/footer');

    $view->todoForm = new View('todos/elements/form');
    $view->todoList = new View('todos/elements/list');

    $view->header->pageTitle  = "Your ToDos";
    $view->header->isLoggedin = true;
    $view->header->username   = $this->user->username;

    $view->message_type  = $this->session->get('message_type') ? $this->session->get_once('message_type') : false;
    $view->message       = $this->session->get('message') ? $this->session->get_once('message') : false;

    $view->todoForm->errors = null;

    // setup and initialize your form field names
    $form = array(
      'description' => '',
      'due_date'    => '',
      'id'          => '',
    );

    //  copy the form as errors, so the errors will be stored with keys corresponding to the form field names
    $errors = $form;

    if( $_POST ) {
      $post = new Validation($_POST);

      $post->pre_filter('trim', TRUE);
      $post->add_rules('description', 'required');
      $post->add_rules('due_date', 'required');

      if( $post->validate() ) {
        // Attempt to save the todo item. If an id has been passed thru, we're editing
        // an existing item, otherwise we create a new item
        $saveStatus = $this->input->post('id') ? $this->_save($this->input->post('id')) : $this->_save();

        if( $saveStatus ) {
          $view->message_type = "good";
          $view->message      = "ToDo item saved.";

          $view->todoForm->description  = "";
          $view->todoForm->due_date     = "";
          $view->todoForm->id           = "";
        } else {
          $view->message_type = "error";
          $view->message      = "Save failed. Please try again.";
        }
      } else {
        // repopulate the form fields
        $view->todoForm->id           = $this->input->post('id');
        $view->todoForm->description  = $this->input->post('description');
        $view->todoForm->due_date     = $this->input->post('due_date');

        // populate the error fields, if any
        $view->todoForm->errors = arr::overwrite($errors, $post->errors('form_errors'));
        $view->message_type     = "error";
        $view->message          = "Please correct the errors below and try again.";
      }

    } else if( $id ) {
      // Attempt to load the requested todo item
      $editTodo = new Todo_Model($id);

      if ( $editTodo->loaded ) {
        $view->todoForm->id           = $editTodo->id;
        $view->todoForm->description  = $editTodo->description;
        $view->todoForm->due_date     = $editTodo->due_date;
      } else {
        $view->message_type = "error";
        $view->message      = 'ToDo item not found.';
      }

    }

    $view->todoList->todos = ORM::factory('todo')->find_all();
    $view->render(TRUE);
  }

  public function delete($id) {
    ORM::factory('todo')->delete($id);
    $this->session->set_flash(array('message_type'=>'good', 'message'=>'ToDo item deleted.'));
    url::redirect('/');
  }

  public function complete($id = false) {
    if ( $id ) {
      $todo = new Todo_Model($id);
      if ( $todo->loaded ) {
        $todo->complete = $todo->complete ? 0 : 1;
        $todo->save();

        if ( $todo->saved ) {
          if ( $todo->complete ) {
            $this->session->set_flash(array('message_type'=>'good', 'message'=>'ToDo item completed.'));
          } else {
            $this->session->set_flash(array('message_type'=>'good', 'message'=>'ToDo item uncompleted.'));
          }
        } else {
          $this->session->set_flash(array('message_type'=>'error', 'message'=>'ToDo item could not be saved.'));
        }
      }
    }

    url::redirect('/');
  }

  private function _save($id = false) {
    $todo = $id ? new Todo_Model($id) : new Todo_Model();
    $todo->description = $this->input->post('description');
    $todo->due_date = $this->input->post('due_date');
    $todo->complete = $this->input->post('complete');

    if( $id ) {
      $todo->date_modified = Date('Y-m-d H:i:s');
    } else {
      $todo->date_added = Date('Y-m-d H:i:s');
    }

    $todo->save();
    return $todo->saved;
  }
} // End Todos Controller