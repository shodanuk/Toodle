<?php defined('SYSPATH') OR die('No direct access allowed.');

class Todos_Controller extends Controller {

  public function __construct() {
    parent::__construct();
    $this->session = Session::instance();
  }

  public function index($_id = false) {
    $view = new View('todos/index');

    $view->header = new View('layout/header');
    $view->footer = new View('layout/footer');

    $view->todoForm = new View('todos/elements/form');
    $view->todoList = new View('todos/elements/list');

    $view->header->pageTitle = "Your ToDos";

    $view->message = $this->session->get('message') ? $this->session->get_once('message') : false;

    if( $_POST ) {
      $post = new Validation($_POST);

      $post->pre_filter('trim', TRUE);
      $post->add_rules('description', 'required');
      $post->add_rules('due_date', 'required');

      if( $post->validate() ) {
        $saveStatus = $this->input->post('id') ? $this->_save($this->input->post('id')) : $this->_save();

        if( $saveStatus ) {
          $message = "ToDo item saved.";

          $view->todoForm->description  = "";
          $view->todoForm->due_date     = "";
          $view->todoForm->id           = "";
        } else {
          $message = "[ERROR] Save failed. Please try again.";
        }
      } else {
        if( $this->input->post('id') ) {
          $view->todoForm->id = $this->input->post('id');
        }

        $view->todoForm->description  = $this->input->post('description');
        $view->todoForm->due_date     = $this->input->post('due_date');

        $message = "[ERROR] Please correct the errors below and try again.";
      }

    } else if($_id) {
      $editTodo = new Todo_Model($_id);

      if ( $editTodo->loaded ) {
        $view->todoForm->id           = $_id;
        $view->todoForm->description  = $editTodo->description;
        $view->todoForm->due_date     = $editTodo->due_date;
      } else {
        $view->message = '[ERROR] ToDo item not found.';
      }

    }

    $view->todoList->todos = ORM::factory('todo')->find_all();

    $view->render(TRUE);
  }

  public function delete($id) {
    ORM::factory('todo')->delete($id);
    $this->session->set_flash('message', 'ToDo item deleted.');
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
            $this->session->set_flash('message', 'ToDo item completed.');
          } else {
            $this->session->set_flash('message', 'ToDo item uncompleted.');
          }
        } else {
          $this->session->set_flash('message', '[ERROR] ToDo item could not be saved.');
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
} // End Welcome Controller