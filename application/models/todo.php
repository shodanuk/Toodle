<?php defined('SYSPATH') OR die('No direct access allowed.');

class Todo_Model extends ORM {
  protected $has_one = array('user');
} // End ToDo Model