<?php defined('SYSPATH') OR die('No direct access allowed.');

class Todos_API_Controller extends Controller {

  public function index() {
    header("Content-type: application/json");

    $return = array();
    $todos = ORM::factory('todo')->find_all();

    foreach($todos as $todo) {
      $return[] =  $todo->as_array();
    }

    echo json_encode($return);
  }

  public function get($id) {
    header("Content-type: application/json");

    $todo = new Todo_Model($id);

    if( $todo->loaded ) {
      echo json_encode(array(
        'status'    => 'success',
        'todo'      => $todo->as_array(),
      ));
    } else {
      echo json_encode(array(
        'status'    => 'error',
        'message'   => 'ToDo item not found.'
      ));
    }
  }

  public function add() {
    header("Content-type: application/json");

    $todo = new Todo_Model();
    $todo->description  = $this->input->post('description');
    $todo->due_date     = $this->input->post('due_date');
    $todo->date_added   = Date('Y-m-d H:i:s');
    $todo->save();

    if($todo->saved) {
      echo json_encode(array(
        'status'  => 'success',
        'message' => 'New ToDo item saved.',
      ));
    } else {
      echo json_encode(array(
        'status'  => 'error',
        'message' => 'Save failed.',
      ));
    }
  }

  public function update($id) {
    header("Content-type: application/json");

    $todo = new Todo_Model($id);

    if( $todo->loaded ) {
      $todo->description    = $this->input->post('description');
      $todo->due_date       = $this->input->post('due_date');
      $todo->complete       = $this->input->post('complete');
      $todo->date_modified  = Date('Y-m-d H:i:s');
      $todo->save();

      if($todo->saved) {
        echo json_encode(array(
          'status'  => 'success',
          'message' => 'New ToDo item updated.',
        ));
      } else {
        echo json_encode(array(
          'status'  => 'error',
          'message' => 'Update failed.',
        ));
      }
    } else {
      echo json_encode(array(
        'status'    => 'error',
        'message'   => 'ToDo item not found.'
      ));
    }
  }

  public function complete($id) {
    header("Content-type: application/json");

    $todo = new Todo_Model($id);

    if( $todo->loaded ) {
      $todo->complete       = $todo->complete ? 0 : 1;
      $todo->date_modified  = Date('Y-m-d H:i:s');
      $todo->save();

      if($todo->saved) {
        echo json_encode(array(
          'status'  => 'success',
          'message' => 'New ToDo item updated.',
        ));
      } else {
        echo json_encode(array(
          'status'  => 'error',
          'message' => 'Update failed.',
        ));
      }
    } else {
      echo json_encode(array(
        'status'    => 'error',
        'message'   => 'ToDo item not found.'
      ));
    }
  }

  public function delete($id) {
    header("Content-type: application/json");

    $todo = new Todo_Model($id);

    if( $todo->loaded ) {
      ORM::factory('todo')->delete($id);
      echo json_encode(array(
        'status'  => 'success',
        'message' => 'ToDo item deleted.',
      ));
    } else {
      echo json_encode(array(
        'status'  => 'error',
        'message' => 'ToDo item not found. Delete failed.',
      ));
    }
  }
} // End Welcome Controller