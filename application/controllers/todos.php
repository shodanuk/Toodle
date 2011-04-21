<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Default Kohana controller. This controller should NOT be used in production.
 * It is for demonstration purposes only!
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Todos_Controller extends Controller {

  private $_testdata = array(
    '1' => array(
      'due_date' => '2011-04-23 16:30:00',
      'description' => 'Where did my description go?',
      'complete' => '0',
    ),
    '2' => array(
      'due_date' => '2011-04-24 07:30:00',
      'description' => 'Invade China',
      'complete' => '0',
    ),
    '3' => array(
      'due_date' => '2011-04-24 07:30:00',
      'description' => 'Start astronaut training at NASA.',
      'complete' => '0',
    ),
    '4' => array(
      'due_date' => '2011-04-25 12:10:00',
      'description' => 'Solve the riddle of the meaning of life. Post on Reddit. Sit back and relax as upvotes flood in.',
      'complete' => '0',
    ),
    '5' => array(
      'due_date' => '2011-04-25 13:08:00',
      'description' => 'Find all missing socks',
      'complete' => '0',
    ),
    '6' => array(
      'due_date' => '2011-04-27 10:40:00',
      'description' => 'Win Premier League with a team consisting only of Ali Dia clones.',
      'complete' => '0',
    ),
    '7' => array(
      'due_date' => '2011-04-28 15:50:00',
      'description' => 'Learn the language of the ghetto.',
      'complete' => '0',
    ),
    '8' => array(
      'due_date' => '2011-04-29 23:07:00',
      'description' => 'Rewrite Sesame Street to feature more cats and less spelling.',
      'complete' => '0',
    ),
    '9' => array(
      'due_date' => '2011-05-30 10:45:00',
      'description' => 'Consume own body weight in red liquorice.',
      'complete' => '0',
    ),
    '10' => array(
      'due_date' => '2011-05-28 14:35:00',
      'description' => 'Finish writing this bloody test data',
      'complete' => '1',
    ),
    '11' => array(
      'due_date' => '2011-05-29 09:12:00',
      'description' => 'Im so bored of writing this now',
      'complete' => '0',
    ),
    '12' => array(
      'due_date' => '2011-06-03 11:00:00',
      'description' => 'How many more of these do I have to do?',
      'complete' => '0',
    ),
    '13' => array(
      'due_date' => '2011-06-05 16:30:00',
      'description' => 'Oh, 2 more.',
      'complete' => '0',
    ),
    '14' => array(
      'due_date' => '2011-06-10 07:30:00',
      'description' => 'Almost there',
      'complete' => '0',
    ),
    '15' => array(
      'due_date' => '2011-06-11 07:30:00',
      'description' => 'YYEESSS. It\'s finished. Finally.',
      'complete' => '1',
    ),
  );

  // Set the name of the template to use
  //public $template = 'kohana/template';

  public function index() {
    header("Content-type: application/json");

    $return = array();
    $todos = ORM::factory('todo')->find_all();

    foreach($todos as $todo) {
      $return[] =  $todo->as_array();
    }

    echo json_encode($return);
  }

  public function read($id) {
    header("Content-type: application/json");

    $todo = ORM::factory('todo', $id)->as_array();
    echo json_encode($todo);
  }

  public function create() {
    header("Content-type: application/json");

    $todo = new Todo_Model();
    $todo->description = $this->input->post('description');
    $todo->due_date = $this->input->post('due_date');
    $todo->complete = $this->input->post('complete');
    $todo->date_added = Date('Y-m-d H:i:s');
    $todo->save();

    echo json_encode(array(
      'status' => 'success',
      'message' => 'New ToDo item created successfully',
    ));
  }

  public function update($id) {
    header("Content-type: application/json");

    $todo = new Todo_Model($id);
    $todo->description = $this->input->post('description');
    $todo->due_date = $this->input->post('due_date');
    $todo->complete = $this->input->post('complete');
    $todo->date_modified = Date('Y-m-d H:i:s');
    $todo->save();

    echo json_encode(array(
      'status' => 'success',
      'message' => 'ToDo item updated successfully',
    ));
  }

  public function delete($id) {
    header("Content-type: application/json");

    ORM::factory('todo')->delete(1);

    echo json_encode(array(
      'status' => 'success',
      'message' => 'ToDo item deleted successfully',
    ));
  }

  /*
  * Resets test data in DB. Nothing exciting.
  */
  public function reset() {
    $count = 0;

    foreach($this->_testdata as $id => $testTodo) {
      $todo = new Todo_Model($id);
      $todo->description = $testTodo['description'];
      $todo->due_date = $testTodo['due_date'];
      $todo->complete = $testTodo['complete'];
      $todo->date_added = Date('Y-m-d H:i:s');
      $todo->save();
      $count++;
    }

    $this->template->title = 'Test data reset';
    $this->template->copyright = "&#169; Terry Morgan, ".Date('Y');
    $this->template->content = "$count records added.";
  }

} // End Welcome Controller