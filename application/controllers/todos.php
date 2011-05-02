<?php defined('SYSPATH') OR die('No direct access allowed.');
// === TextMate error handling ===
@include_once '/Applications/TextMate.app/Contents/SharedSupport/Bundles/PHP.tmbundle/Support/textmate.php';

/**
 * Todos_Controller
 *
 * @package     Toodle
 * @author      Terry Morgan <terry.morgan@marmaladeontoast.co.uk>
 * @copyright   (c) 2011 Terry Morgan
 */
class Todos_Controller extends Controller {

  public function __construct()
  {
    parent::__construct();
    $this->session = Session::instance();

    $auth = new Auth;
    if ($auth->logged_in() || $auth->auto_login() == TRUE)
    {
      $this->user = $auth->get_user();
    }
    else
    {
      $this->session->set('requested_url', '/'.url::current());
      url::redirect('/users/login');
    }
  }

  public function index($id = false)
  {
    $view             = new View('todos/index');
    $view->header     = new View('layout/header');
    $view->footer     = new View('layout/footer');
    $view->todo_form  = new View('todos/elements/form');
    $view->todo_list  = new View('todos/elements/list');

    $view->header->page_title   = 'Your ToDos';
    $view->header->is_logged_in = true;
    $view->header->username     = $this->user->username;
    $view->header->body_class   = 'index';

    $view->message_type  = $this->session->get('message_type') ? $this->session->get_once('message_type') : false;
    $view->message       = $this->session->get('message') ? $this->session->get_once('message') : false;

    $view->todo_form->errors = null;

    // Setup and initialize your form field names
    $form = array(
      'description' => '',
      'id'          => '',
    );

    // Copy the form as errors, so the errors will be stored with keys corresponding to the form field names
    $errors = $form;

    if ($_POST)
    {
      $post = new Validation($_POST);

      $post->pre_filter('trim', TRUE);
      $post->add_rules('description', 'required');

      if ($post->validate())
      {
        // Process the description and attempt to extract a due date and / or time,
        // if they've been entered.

        $id = $this->input->post('id');
        $todo = new Todo_Model($id);

        if ( ! $id)
        {
          $todo->date_added = Date('Y-m-d H:i:s');
        }

        $todo->complete = $this->input->post('complete');
        $todo->user_id  = $this->user->id;

        // get_due_date will return an array of due date and description if a due date has
        // been enter and a string containing the description, if not.
        $desc_parts = todo::get_due_date($this->input->post('description'));

        if (is_array($desc_parts))
        {
          $todo->description  = trim($desc_parts['description']);

          // A due date and a description have been entered, validate the due date
          $due_date = trim($desc_parts['due_date']);

          // Attempt to extract a valid date and time from the due date
          if ($mysql_timestamp = todo::convert_due_date($due_date))
          {
            $todo->due_date = $mysql_timestamp;
          }
        }
        else
        {
          $todo->description  = trim($desc_parts);
        }

        if ($todo->save())
        {
          $view->message_type = 'good';
          $view->message      = 'ToDo item saved.';

          $view->todo_form->description  = "";
          $view->todo_form->id           = "";
        }
        else
        {
          $view->message_type = 'error';
          $view->message      = 'Save failed. Please try again.';
        }
      }
      else
      {
        // Repopulate the form fields
        $view->todo_form->id           = $this->input->post('id');
        $view->todo_form->description  = $this->input->post('description');

        // Populate the error fields, if any
        $view->todo_form->errors  = arr::overwrite($errors, $post->errors('form_errors'));
        $view->message_type       = 'error';
        $view->message            = 'Please correct the errors below and try again.';
      }
    }
    elseif ($id)
    {
      // Attempt to load the requested todo item
      $edit_todo = new Todo_Model($id);

      if ($edit_todo->loaded)
      {
        $view->todo_form->id           = $edit_todo->id;
        $view->todo_form->description = $edit_todo->due_date
                                          ? todo::display_due_date($edit_todo->due_date)." | ".$edit_todo->description
                                          : $edit_todo->description;
      }
      else
      {
        $view->message_type = 'error';
        $view->message      = 'ToDo item not found.';
      }
    }

    $per_page = 10;
    $offset   = 0;

    $view->todo_list->todos = ORM::factory('todo')
                                ->where('user_id', $this->user->id)
                                ->orderby('due_date', 'ASC')
                                ->find_all($per_page, $offset);
    $view->render(TRUE);
  }

  public function delete($id)
  {
    ORM::factory('todo')->delete($id);
    $this->session->set_flash(array('message_type'=>'good', 'message'=>'ToDo item deleted.'));
    url::redirect('/');
  }

  public function complete($id = false)
  {
    if ($id)
    {
      $todo = new Todo_Model($id);
      if ($todo->loaded) {
        $todo->complete = $todo->complete ? 0 : 1;

        if ($todo->save())
        {
          if ($todo->complete)
          {
            $flash_message = array('message_type'=>'good', 'message'=>'ToDo item completed.');
          }
          else
          {
            $flash_message = array('message_type'=>'good', 'message'=>'ToDo item uncompleted.');
          }
        }
        else
        {
          $flash_message = array('message_type'=>'error', 'message'=>'ToDo item could not be saved.');
        }
        $this->session->set_flash($flash_message);
      }
    }
    url::redirect('/');
  }
} // End Todos Controller